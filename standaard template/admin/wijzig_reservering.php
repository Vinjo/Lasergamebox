<?php
require('../functions.php');
$access->admin();

$reserveringnr = $_GET['reserveringnr'];

$factor = Factoren();

if (isset($_POST['opslaan'])) {
wijzig_reservering();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Header -->
        <?php head(); ?>
    </head>
    
    <body>
        <!-- Static navbar -->
            <?php static_navbar(); ?>
            
            
        
        <?php                 
                $stmt = $pdo->prepare("SELECT * FROM reservering JOIN klant ON reservering.klantnr = klant.klantnr WHERE reserveringnr=?");
                $stmt->execute(array($_GET['reserveringnr']));
                $reservering = $stmt->fetch();

                $naam = $reservering["naam"];
                $achternaam = $reservering["achternaam"];
                $telefoonnummer = $reservering["telnummer"];
                $email = $reservering["email"];
                $postcode = $reservering["postcode"];
                $huisnummer = $reservering["huisnummer"];
                $straat = $reservering["straat"];
                $woonplaats = $reservering["woonplaats"];
                $van = $reservering["van"];
                $tot = $reservering["tot"];
                $pistolen = $reservering["aantal_pistolen"];
                $status = $reservering["status"];
				
		$datumvan = $reservering["van"];
                $vandatum = date("d-m-Y", strtotime($datumvan));

            	$datumtot = $reservering["tot"];
            	$totdatum = date("d-m-Y", strtotime($datumtot));
                
                $telchecker = "/^[0-9\_]{10,10}/";
				
				$date1 = date_create(''.$van.'');
				$date2 = date_create(''.$tot.'');
				$dagen = date_diff($date1, $date2);
				
				if($dagen->days >= 0 && $dagen->days <= 1){
					//prijs perdag
					$pakketkosten = ($pistolen * 5) + 10;
					$borg = $pakketkosten;
					$test = "dag";
					
				}elseif($dagen->days >= 2 && $dagen->days <= 3){
					//prijs per weekend
					$pakketkosten = ($pistolen * $factor['pistoolPrijs'] + 10) * $factor['weekend'];
					$borg = $pakketkosten;
					$test = "weekend";
					
				}else {
					//prijs per week
					$pakketkosten = ($pistolen * $factor['pistoolPrijs'] + 10) * $factor['week'];
					$borg = $pakketkosten;
					$test = "week";
				}
				
				if($pistolen <= 10){
					$aanbetaling = 10;
				}else{
					$aanbetaling = 20;
				}
				$totaal = $aanbetaling + $pakketkosten + $borg;
                
                
				
				
				
				print $weekendfactor;
				
                ?>
        <!-- Admin Bar -->
        <?php adminnav(); ?>
        
        <div class="container">
              
            <!-- Layout  -->
            <section>
            <br><br>
            <?php        

                ?>
              <div class="col-md-10 col-md-offset-1">
                <div id="aanmaak" class="tab-pane fade in active">
                    <div class="balk"><b>Aanpassen reservering</b></div>              
                <form role="form" class="form-horizontal" method="post" action="wijzig_reservering.php?reserveringnr=<?php print $reserveringnr?>">
                    <fieldset> 
                        
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Reserveringnr</label>
                                            <div class="col-md-4">
                                                <input readonly type="text" placeholder="<?php print $reserveringnr ?>" name="reserveringnr" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Status</label>
                                            <div class="col-md-4">
                                                <select name="status" class="form-control">
                                                    <option value="1" <?php if ($status == "1" ) print 'selected'; ?>>In beoordeling</option>
                                                    <option value="2" <?php if ($status == "2" ) print 'selected'; ?>>In behandeling</option>
                                                    <option value="3" <?php if ($status == "3" ) print 'selected'; ?>>Behandeld</option>
                                                    <option value="4" <?php if ($status == "4" ) print 'selected'; ?>> Geannuleerd</option>
                                                </select>
                                            </div>
                                        </div>


                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-md-6 text-left">Persoonlijke gegevens:</div>
                                            <div class="col-md-6 text-left">Bestelling:</div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Voornaam</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $naam ?>" name="naam" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Van</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="<?php print $vandatum ?>" name="van" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Achternaam</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $achternaam ?>" name="achternaam" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Tot</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="<?php print $totdatum ?>" name="tot" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Telefoonnummer</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $telefoonnummer ?>" name="telnummer" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Pistolen</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="<?php print $pistolen ?>" name="aantal_pistolen" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Email</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $email ?>" name="email" class="form-control">
                                        </div>
                                        <label class="col-md-2 control-label"></label>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                            
                                        <div class="form-group">
                                            <div class="col-md-6 text-left">Adres gegevens:</div>
                                            <div class="col-md-6 text-left">Prijsopgave:</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Postcode</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $postcode ?>" name="postcode" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Aanbetaling</label>
                                            <div class="col-md-4">
                                                <input readonly type="text" placeholder="&#8364 <?php print $aanbetaling?>" name="aanbetaling" class="form-control">
                                            </div>
                                        </div>                                        
                                        
                                         <div class="form-group">
                                            <label class="col-md-2 control-label">Huisnummer</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $huisnummer ?>" name="huisnummer" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Pakket kosten</label>
                                            <div class="col-md-4">
                                                <input readonly type="text" placeholder="&#8364 <?php print $pakketkosten?>" name="pakket_kosten" class="form-control">
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Straat</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $straat ?>" name="straat" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Borg</label>
                                            <div class="col-md-4">
                                                <input readonly type="text" placeholder="&#8364 <?php print $borg?>" name="borg" class="form-control">
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Plaats</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $woonplaats ?>" name="woonplaats" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Totaal</label>
                                            <div class="col-md-4">
                                                <input readonly type="text" placeholder="&#8364 <?php print $totaal?>" name="totaal" class="form-control">
                                            </div>
                                        </div>   
                                </form>
                        
                  <div class="form-group">       
                  <?php // <div class="checkbox"> <input type="checkbox"> Ik heb de order gecontroleerd. ?> 
                                                <div class="pull-right">    
                                                    <div class="pull-right">    <a href="overzicht_reserveringen.php" class="btn btn-danger">Terug</a>                       
                                                    <input value="Bevestigen" name="opslaan" type="submit" class="btn btn-success"></div>
                                            </div> </div></div>
              
                                    </div></div>
               
                <?php
                
                /*

                 if (isset($_POST["opslaan"])) {

                $stmt = $pdo->prepare("UPDATE reservering SET van=?,tot=?,aantal_pistolen=?,status=? WHERE reserveringnr=?");
                $stmt->execute(array($_POST["van"], $_POST["tot"], $_POST["aantal_pistolen"], $_POST["status"], $_GET["reserveringnr"]));
                
                $stmt = $pdo->prepare("UPDATE klant SET naam=?,achternaam=?,telnummer=?,email=?,postcode=?,huisnummer=?,straat=?,woonplaats=? WHERE klantnr = (SELECT klantnr FROM reservering WHERE reserveringnr=?)");
                $stmt->execute(array($_POST["naam"], $_POST["achternaam"], $_POST["telnummer"], $_POST["email"], $_POST["postcode"], $_POST["huisnummer"], $_POST["straat"], $_POST["woonplaats"], $_GET["reserveringnr"]));
                print("<div class=\"alert alert-success\" id=\"success-alert\">
               <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
               <strong>Gelukt!</strong>
               Reservering bewerkt
               </div>");
                
                }

*/
                                                       
function wijzig_reservering() {
    
        if (
                wijzig_van() AND

                wijzig_tot() AND

                wijzig_aantal_pistolen() AND

                wijzig_status() AND

                wijzig_naam() AND

                wijzig_achternaam() AND

                wijzig_telnummer() AND

                wijzig_email() AND

                wijzig_postcode() AND

                wijzig_huisnummer() AND

                wijzig_straat() AND
                
                wijzig_woonplaats()) {
            
        } else {
            print("mislukt.");
        }
    }

        
    // RESERVERING
        function wijzig_van(){        
        global $pdo;
        if (!empty($_POST["van"])) {
        $datumvan = $_POST["van"];
        $vandatum = date("Y-m-d", strtotime($datumvan));
            $stmt = $pdo->prepare("UPDATE reservering SET van = ? WHERE reserveringnr = ?;");
            $stmt->execute(array ($vandatum, $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        function wijzig_tot(){
        global $pdo;
        if (!empty($_POST["tot"])) {
        $datumtot = $_POST["tot"];
        $totdatum = date("Y-m-d", strtotime($datumtot));
            $stmt = $pdo->prepare("UPDATE reservering SET tot = ? WHERE reserveringnr = ?;");
            $stmt->execute(array ($totdatum, $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
    
        function wijzig_aantal_pistolen(){
        global $pdo;
        if (!empty($_POST["aantal_pistolen"])) {
            $stmt = $pdo->prepare("UPDATE reservering SET aantal_pistolen = ? WHERE reserveringnr = ?;");
            $stmt->execute(array($_POST["aantal_pistolen"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
            ?><div class="alert alert-warning"> Ongeldig e-mailadres.</div><?php
        }
        }
        

        function wijzig_status() {                                              
            global $pdo;
            
            if (!empty($_POST["status"])) {
                $stmt = $pdo->prepare("UPDATE reservering SET status = ? WHERE reserveringnr = ?;");
                $stmt->execute(array($_POST["status"], $_GET["reserveringnr"]));
                return TRUE;
                //$pdo = NULL;
            } else {
                return TRUE;
            }
        }
        
        
        // KLANT

        function wijzig_naam(){
        global $pdo;
        if (!empty($_POST["naam"])) {
            $stmt = $pdo->prepare("UPDATE klant SET naam = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["naam"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        function wijzig_achternaam(){
        global $pdo;
        if (!empty($_POST["achternaam"])) {
            $stmt = $pdo->prepare("UPDATE klant SET achternaam = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["achternaam"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        
        function wijzig_telnummer() {
        global $pdo;
        if (!empty($_POST["telnummer"] && preg_match("/^[0-9\_]{10,10}/", $_POST["telnummer"]))){
            $stmt = $pdo->prepare("UPDATE klant SET telnummer = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["telnummer"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        function wijzig_email() {
        global $pdo;
        if (!empty($_POST["email"] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
            $stmt = $pdo->prepare("UPDATE klant SET email = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["email"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        function wijzig_postcode() {
        global $pdo;
        if (!empty($_POST["postcode"]&& preg_match("/^[a-zA-Z0-9\_]{6,6}/", $_POST["postcode"]))) {
            $stmt = $pdo->prepare("UPDATE klant SET postcode = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["postcode"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        function wijzig_huisnummer() {
        global $pdo;
        if (!empty($_POST["huisnummer"] && preg_match("/^[0-9\_]/", $_POST["huisnummer"]))) {
            $stmt = $pdo->prepare("UPDATE klant SET huisnummer = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["huisnummer"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        function wijzig_straat() {
        global $pdo;
        if (!empty($_POST["straat"] && preg_match("/^[a-zA-Z\_]/", $_POST["straat"]))) {
            $stmt = $pdo->prepare("UPDATE klant SET straat = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["straat"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
        function wijzig_woonplaats() {
        global $pdo;
        if (!empty($_POST["woonplaats"] && preg_match("/^[a-zA-Z\_]/", $_POST["woonplaats"]))) {
            $stmt = $pdo->prepare("UPDATE klant SET woonplaats = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
            $stmt->execute(array($_POST["woonplaats"], $_GET["reserveringnr"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
        }
        
    
                
                ?>
                
            </section>

            <!-- footer -->       
            <?php footer(); ?>

        </div> <!-- /container -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php if (!is_dir('admin')) { print '../'; } ?>core/js/bootstrap.js"></script>
	<script src="core/js/spinner.js"></script>




    </body>
</html>






