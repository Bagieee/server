<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>WTC - WorkstationToolCheck</title>
        <link href="Styles/qrcode.css" rel="stylesheet">

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
        
        <form action="../FullPHP/qrcode-gen.php" id="eingabe_div" method="get">
            


        Raum: 
        <select name="raumid" id="raumid" methode="get" onchange="this.form.submit();">
        <?php
          $raumid = 0;
          if(isset($_GET['raumid'])){
            $raumid = $_GET['raumid'];
            echo '<option value="0" disabled hidden >Raum auswählen</option>';
          }
          else {
            echo '<option value="0" disabled hidden selected>Raum auswählen</option>';
          }
          require_once("dbCon.php");
          $stmt = $pdo->prepare("SELECT * FROM tblraum");
          $stmt->execute();    
          foreach ($stmt->fetchAll() as $row){
            echo "<option value='".$row['raumId']."'>" . $row['raumBezeichnung'] ."</option>";
          }
        ?>
        </select>
        <script type="text/javascript">
         document.getElementById('raumid').value = "<?php echo $_GET['raumid'];?>";
        </script>
        
        </form>
        <form action="../FullPHP/qrcode-gen.php" id="eingabe_div" method="get">

            Tisch:
            <select name="tischid" id="tischid" methode="get" onchange="this.form.submit();">
            <?php
                if(!isset($_GET['raumid'])){
                    echo "<option> Bitte wählen sie zuerst einen Raum aus. </option>";
                }
                else{
                    $tischid = 0;
                    if(isset($_GET['raumid'])){
                      $raumid = $_GET['raumid'];
                      echo '<option value="0" disabled hidden>Tisch auswählen</option>';
                    }
                    else {
                      echo '<option value="0" disabled hidden selected>Tisch auswählen</option>';
                    }
                    require_once("dbCon.php");
                    $stmt = $pdo->prepare("SELECT * FROM tbltisch where tischRaumId = ?");
                    $stmt->execute([$raumid]);    
                    foreach ($stmt->fetchAll() as $row){
                      echo "<option value='".$row['tischId']."'>" . $row['tischNummer'] ."</option>";
                    }
                }
                

            ?>
        
        </select>
        <script type="text/javascript">
         document.getElementById('tischid').value = "<?php echo $_GET['tischid'];?>";
        </script>
        </form>
        

        <div id="qrcode"></div>
        
     

        <!-- MUSS NOCH ANGEPASST WERDEN -> FARBE GRÜN UND BLINKEND WENN FORM AUSGEFÜLLT -->
        <!-- <button id="checkSub_btn"class="btn_a">QR-CODE BESTÄTIGEN UND ABSCHICKEN</button> -->
            
            
            
            
            
            
            
        </div>
    </body>

    <script>
        function generateCode() {
            var qrSize = 256;

            $('#qrcode').empty();
            $('#qrcode').qrcode({
                width: qrSize,
                height: qrSize,
                text: 
                $('#in_a').val()
                + "/"
                + $('#in_b').val()
                
            });
        }


        function FormPruefung() {
        var check = true;

        if (document.getElementById('eingabe_div').value == '') {
            check = false;
        }

        if (check) {
            document.getElementById('gen_btn').disabled = false;
        }
    }
    </script>

</html>