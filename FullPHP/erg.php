<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>WTC - WorkstationToolCheck</title>
        <link href="Styles/tisch.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/130527/qrcode.js"></script>  

        <!-- UIKIT und BOOTSTRAP EINBINDUNG -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit-icons.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="container">
        
        <div id="titel">
            <a href="index.php"><h1>WTC - WorkstationToolCheck</h1></a>  
        </div>


        <div id="output1">
            <div id="tablediv">
                <table id="tables">
                    <tr>
                        <th>Datum/Uhrzeit</th>
                        <th>Raum/Tisch</th>
                        <th>Name</th>
                        <th>Ergebniss</th>
                        <th>Kommentar</th>
                    </tr>
                <?php

                require_once("dbCon.php");

                $stmt = $pdo->prepare("SELECT * FROM tblScan");
                $stmt->execute();
                foreach($stmt->fetchAll() as $row){
                    if ($row['scanErgebniss'] === 1){
                        $ergebniss = "Vollständig";
                        $class = "backgroundGreen";
                    }
                    else {
                        $ergebniss = "Unvollständig";
                        $class = "backgroundRed";
                    }
                    echo "<tr id='".$class."'>";
                    echo "<td>".$row['scanTime']."</td>";
                    echo "<td> Raum/Tisch </td>";
                    echo "<td>".$row['scanName']."</td>";
                    echo "<td>".$ergebniss."</td>";
                    echo "<td>".$row['scanKommentar']."</td>";
                    echo "</tr>";
                }

                ?>
                
                </table>
            </div>
        </div>

</body>
</html>

        
        

        
        