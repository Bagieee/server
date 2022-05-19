<?php

require_once('dbCon.php');
require('libs/pdf/fpdf.php');
include('libs/phpqrcode/phpqrcode.php');

$tischRaumId = $_GET['tischRaumId'];

class PDF extends FPDF{

}

$x;
$y = 15;
$c = 0;
$count = 0;
$pic;
$pdf = new PDF();

$pdf->AddPage();
$pdf->Line(105,0,105,500);
    $stmt = $pdo->prepare("SELECT tischNummer, tischRaumId FROM tbltisch where tischRaumId = ? order by tischRaumId, tischNummer");
    $stmt->execute([$tischRaumId]);      
        foreach ($stmt->fetchAll() as $row){
            if ($count == 3)
            {
                $count = 0;
                $pdf->AddPage();
                $y=5;
                $pdf->Line(105,0,105,500);
            }
            if ($c == 0){
                
                $url = $row["tischRaumId"].'/'.$row["tischNummer"];
                $filename = "qr_".$row["tischRaumId"].$row["tischNummer"].".png";
                QRcode::png($url, $filename, 4, 10, 4);
                chmod($filename, 0777);
                $pdf->Image($filename, 20, $y, NULL, NULL,'PNG');
                $pdf->SetY($y+3);
                $pdf->SetX(30);
                $pdf->SetFont('Arial','',14);
                $pdf->Write(5,$row["tischRaumId"].'/'.$row["tischNummer"]);
                $c=1;    
                
            }
            else if ($c == 1){
                
                $url = $row["tischRaumId"].'/'.$row["tischNummer"];
                $filename = "qr_".$row["tischRaumId"].$row["tischNummer"].".png";
                QRcode::png($url, $filename, 4, 10, 4);
                chmod($filename, 0777);
                $pdf->Image($filename, 110, $y, NULL, NULL,'PNG');
                $pdf->SetY($y+3);
                $pdf->SetX(120);
                $pdf->SetFont('Arial','',14);
                $pdf->Write(5,$row["tischRaumId"].'/'.$row["tischNummer"]);
                $c=0;
                $count++;
                $y += 85;
                $pdf->Line(0,$y-1.5,300,$y-1.5);
            }
            
        }

$pdf->Output('Raum'.$row["tischRaumId"], 'D');

$images = glob("./" . "qr_*.png");

foreach ($images as $image){
    unlink("./" . $image);
}

