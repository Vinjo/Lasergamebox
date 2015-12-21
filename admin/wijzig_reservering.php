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
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
   <script src="../core/js/jquery.js"/></script>
   <script src="../dist/sweetalert.min.js"></script> <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
        <!-- Header -->
            <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Lasergamebox.nl</title>

    <!-- Bootstrap -->
    <link href="../core/css/bootstrap.css" rel="stylesheet">
    <link href="../core/css/style.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/sweetalert.css">

        <!-- Header -->
        <?php head(); ?>
    </head>
    
    <body>
        <!-- Static navbar -->
            <?php static_navbar(); ?>
            
            
        
        <?php                 
        
        // OPVRAAG VAN INFORMATIE UIT DE DATABASE
        
                $stmt = $pdo->prepare("SELECT * FROM reservering JOIN klant ON reservering.klantnr = klant.klantnr WHERE reserveringnr=?");
                $stmt->execute(array($_GET['reserveringnr']));
                $reservering = $stmt->fetch();

                // WAARDE WORDT GEGEVEN AAN DE OPGEVRAAGDE INFORMATIE
                
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
				
                // DIT ZORGT ERVOOR DAT DE DATUMS VAN M-D-Y NAAR D-M-Y GEZET WORDEN.
                
		$datumvan = $reservering["van"];
                $vandatum = date("d-m-Y", strtotime($datumvan));

            	$datumtot = $reservering["tot"];
            	$totdatum = date("d-m-Y", strtotime($datumtot));
                
                // DIT REKENT DE PRIJZEN UIT
				
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
        
     <script>
	 
	 var dagen = {};
	 
	 $(document).ready(function(){
    var $datepicker1 =  $( "#datepicker1" );
    var $datepicker2 =  $( "#datepicker2" );
    $datepicker1.datepicker({
		onClose: function() {
			var fromDate = $datepicker1.datepicker('getDate');
            var toDate = $datepicker2.datepicker('getDate');
			document.getElementById('pistolen_input').value='0'; 
			document.getElementById('aanbetaling_output').value='€ NaN'; 
			document.getElementById('prijs_output').value='€ NaN'; 
			document.getElementById('borg_output').value='€ NaN'; 
			document.getElementById('totaal_output').value='€ NaN'; 
			document.getElementById('dagen').value='N.V'; 
			  // date difference in millisec
            var diff = new Date(toDate - fromDate);
            // date difference in days
			dagen.days = diff/1000/60/60/24;
	}
	
	
	});
    $datepicker2.datepicker({
         onClose: function() {
            var fromDate = $datepicker1.datepicker('getDate');
            var toDate = $datepicker2.datepicker('getDate');
			document.getElementById('pistolen_input').value='0'; 
			document.getElementById('aanbetaling_output').value='€ NaN'; 
			document.getElementById('prijs_output').value='€ NaN'; 
			document.getElementById('borg_output').value='€ NaN'; 
			document.getElementById('totaal_output').value='€ NaN'; 
			document.getElementById('dagen').value='N.V'; 
            // date difference in millisec
            var diff = new Date(toDate - fromDate);
            // date difference in days
			dagen.days = diff/1000/60/60/24;

					}
    });
});
           

function omRekenen() {
	
	if(dagen.days < 0){
		sweetAlert("Oeps...", "De begindatum is later dan einddatum!", "error");
		return false;
		
	}


   var pistolen_input = parseInt(document.getElementById('pistolen_input').value);
   
  if(pistolen_input <= 10) {
	   var aanbetaling_totaal =  10;
   }else{
	   var aanbetaling_totaal =  20;
   }
   
   
   if(dagen.days == 1){
	   var aantal_dagen = dagen.days;
	   var prijs_totaal = pistolen_input * <?php print $factor['pistoolPrijs'];?> + 10 ;
	   document.getElementById('dagen').value=aantal_dagen;
   }else if (dagen.days <= 2) {
	   var prijs_totaal = (pistolen_input * <?php print $factor['pistoolPrijs'];?> + 10) * <?php print $factor['weekend'];?>;
	   var aantal_dagen = dagen.days;
	   document.getElementById('dagen').value=aantal_dagen;
   }else if(dagen.days >= 3 ){
	   var prijs_totaal = (pistolen_input * <?php print $factor['pistoolPrijs'];?> + 10) * <?php print $factor['week'];?>;
	   var aantal_dagen = dagen.days;
	   document.getElementById('dagen').value=aantal_dagen;
   }
   
   

   var borg_totaal = pistolen_input * <?php print $factor['pistoolPrijs'];?> + 10;
   
   var totaal_totaal = aanbetaling_totaal + prijs_totaal + borg_totaal;

document.getElementById('prijs_output').value = prijs_totaal;
document.getElementById('aanbetaling_output').value = aanbetaling_totaal;
 document.getElementById('borg_output').value = borg_totaal;
 document.getElementById('totaal_output').value = totaal_totaal;
}



</script>
			
        <!-- Admin Bar -->
        <?php adminnav(); ?>
        
        <div class="container">
              
            <!-- Layout  -->
            <section>
            <br><br>
                <?php 
                    if($_SESSION['status'] == TRUE) {
                        print($_SESSION['message']);
                        unset($_SESSION['status']);
                        unset($_SESSION['message']);
                    }
                ?>
              <div class="col-md-10 col-md-offset-1">
                <div class="tab-pane fade in active">
                    <div class="balk"><b>&nbsp; Aanpassen reservering</b></div>              
                <form role="form" class="form-horizontal" method="post" action="wijzig_reservering.php?reserveringnr=<?php print $reserveringnr?>">
                                <!-- Text input-->
                    <div class="row">
                                    <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        
                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Reserveringsnummer</label>
                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                <input readonly type="text" placeholder="<?php print $reserveringnr ?>" name="reserveringnr" class="form-control">
                                            </div>
                                    </fieldset>
                                    <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Status</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <select name="status" class="form-control">
                                                    <option value="1" <?php if ($status == "1" ) print 'selected'; ?>>In beoordeling</option>
                                                    <option value="2" <?php if ($status == "2" ) print 'selected'; ?>>In behandeling</option>
                                                    <option value="3" <?php if ($status == "3" ) print 'selected'; ?>>Afgehandeld</option>
                                                    <option value="4" <?php if ($status == "4" ) print 'selected'; ?>> Geannuleerd</option>
                                                </select>
                                        </div>
                                    </fieldset>
                    </div><br>

                                        <!-- Text input-->
                    <div class="row">
                    <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">Persoonlijke gegevens:</div>
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Voornaam</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input  type="text" placeholder="<?php print $naam ?>" name="naam" class="form-control">
                                                <br>
                                            </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Achternaam</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input  type="text" placeholder="<?php print $achternaam ?>" name="achternaam" class="form-control">
                                                <br>
                                            </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Telefoonnummer</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input  type="text" placeholder="<?php print $telefoonnummer ?>" name="telnummer" class="form-control">
                                                <br>
                                            </div>
                                                                                       
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Email</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input  type="text" placeholder="<?php print $email ?>" name="email" class="form-control">
                                                <br> 
                                            </div>
                    </fieldset>
                    <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">Bestelling:</div>
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Van</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input readonly type="text" id="datepicker1" name="van" placeholder="<?php print $vandatum; ?> " class="form-control"> 
                                                <br>
                                            </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Tot</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input type="text" id="datepicker2" placeholder="<?php print $totdatum ?>" name="tot" class="form-control">
                                                <br>
                                            </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Pistolen</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input type="text" placeholder="<?php print $pistolen ?>" name="aantal_pistolen" class="form-control">
                                                <br>
                                            </div>
                                        
                    </fieldset>
                    </div><br>
                    
                    
                    <div class="row">
                    <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">Adres gegevens:</div>
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Postcode</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 text-left">
                                                <input  type="text" placeholder="<?php print $postcode ?>" name="postcode" class="form-control">
                                                <br>
                                            </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label text-left">Huisnummer</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input  type="text" placeholder="<?php print $huisnummer ?>" name="huisnummer" class="form-control">
                                                <br>
                                            </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label text-left">Straat</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input  type="text" placeholder="<?php print $straat ?>" name="straat" class="form-control">
                                                <br>
                                            </div>
                                                                                       
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label text-left">Plaats</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                                                <input  type="text" placeholder="<?php print $woonplaats ?>" name="woonplaats" class="form-control">
                                                <br> 
                                            </div>
                    </fieldset>
                    
                        <fieldset>
                            
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">Prijsopgave:</div>
                    
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label text-left">Aanbetaling</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 text-left">
                                                <input readonly type="text" placeholder="&#8364 <?php print $aanbetaling?>" name="aanbetaling" class="form-control">
                                                <br>
                                            </div>   

                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label text-left">Pakket kosten</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 text-left">
                                                <input readonly type="text" placeholder="&#8364 <?php print $pakketkosten?>" name="pakket_kosten" class="form-control">
                                                <br>
                                            </div>                                    

                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label text-left">Borg</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 text-left">
                                                <input readonly type="text" placeholder="&#8364 <?php print $borg?>" name="borg" class="form-control">
                                                <br>
                                            </div>
                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label text-left">Totaal</label>
                                            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 text-left">
                                                <input readonly type="text" placeholder="&#8364 <?php print $totaal?>" name="totaal" class="form-control">
                                                <br>
                                            </div>
                            
                        </fieldset>
                        </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                                            <div class="pull-right">    
                                                    <div class="pull-right"><a href="overzicht_reserveringen.php" class="btn btn-danger">Terug</a>                       
                                                    <input value="Bevestigen" name="opslaan" type="submit" class="btn btn-success"></div>
                                                    </div> 
                  </div>
                                </form>               
                <?php
function getDateVan() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM reservering WHERE reserveringnr=?");
    $stmt->execute(array($_GET['reserveringnr']));
    while ($row = $stmt->fetch()) {
                $date = $row['van'];
                $date = date("d-m-Y", strtotime($date));
                return($date);
            }
    
} 
                                                       
function getDateTot() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM reservering WHERE reserveringnr=?");
    $stmt->execute(array($_GET['reserveringnr']));
    while ($row = $stmt->fetch()) {
                $date = $row['tot'];
                $date = date("d-m-Y", strtotime($date));
                return($date);
            }
    
} 

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
            
            $_SESSION['status'] = TRUE;
            $_SESSION['message'] = "<div class=\"alert alert-success\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Gelukt!</strong> &nbsp; Het wijzigen van de gegevens is gelukt!
                                    </div>";
            
        } else {
            $_SESSION['status'] = TRUE;
        }
    }
    
    // RESERVERING
        function wijzig_van(){
            /* CHECK VAN INGEVULDE VAN/TOT WERKT WEL, CHECKEN MET DE DATABASE WERKT NIET, ALLEEN INVOEREN WERKT WEL. */
            global $pdo;
            if (!empty($_POST["van"])) {
                
                if (strlen($_POST["van"]) == 10) {
                
                    if (!empty($_POST["tot"])) {
                        if ($_POST["van"] >= $_POST["tot"]) {
                           $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                        <strong>Mislukt!</strong> &nbsp; De van datum ligt na de tot datum.
                                        </div>";
                            return FALSE; 
                            }
                        } elseif (empty($_POST["tot"])) {

                            if ($_POST["van"] >= getDateTot()) {
                            $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                        <strong>Mislukt!</strong> &nbsp; De van datum ligt na de tot datum.
                                        </div>";
                            return FALSE;   
                            } else {
                                $datumvan = $_POST["van"];
                                $vandatum = date("Y-m-d", strtotime($datumvan));
                                $stmt = $pdo->prepare("UPDATE reservering SET van = ? WHERE reserveringnr = ?;");
                                $stmt->execute(array ($vandatum, $_GET["reserveringnr"]));
                                return TRUE;
                            }    
                    }
                } else {
                    $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                        <strong>Mislukt!</strong> &nbsp; De format van de datum klopt niet.
                                        </div>";
                            return FALSE; 
                }
            }
        }
                                                       
     function wijzig_tot(){
            /* CHECK VAN INGEVULDE VAN/TOT WERKT WEL, CHECKEN MET DE DATABASE WERKT NIET, ALLEEN INVOEREN WERKT WEL. */
            global $pdo;
            if (!empty($_POST["tot"])) {
                
                if (strlen($_POST["tot"]) == 10) {
                
                    if (!empty($_POST["van"])) {
                        if ($_POST["tot"] >= $_POST["van"]) {
                           $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                        <strong>Mislukt!</strong> &nbsp; De van datum ligt na de tot datum.
                                        </div>";
                            return FALSE; 
                            }
                        } elseif (empty($_POST["van"])) {

                            if ($_POST["tot"] >= getDateVan()) {
                            $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                        <strong>Mislukt!</strong> &nbsp; De van datum ligt na de tot datum.
                                        </div>";
                            return FALSE;   
                            } else {
                                $datumtot = $_POST["van"];
                                $totdatum = date("Y-m-d", strtotime($datumtot));
                                $stmt = $pdo->prepare("UPDATE reservering SET tot = ? WHERE reserveringnr = ?;");
                                $stmt->execute(array ($totdatum, $_GET["reserveringnr"]));
                                return TRUE;
                            }    
                    }
                } else {
                    $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                        <strong>Mislukt!</strong> &nbsp; De format van de datum klopt niet.
                                        </div>";
                            return FALSE; 
                }
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
                $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het aantal pistolen is niet gelukt!
                                    </div>";
                return FALSE;
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
                $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van de reserverig status is niet gelukt!
                                    </div>";
                return FALSE;
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
                $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van de klant naam is niet gelukt!
                                    </div>";
                return FALSE;
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
                $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van de achternaam is niet gelukt!
                                    </div>";
                return FALSE;
            }
        }
        
        
        function wijzig_telnummer() {
            global $pdo;
            if (!empty($_POST["telnummer"]) && preg_match("/^[0-9\_]{10,10}/", $_POST["telnummer"])) {
                $stmt = $pdo->prepare("UPDATE klant SET telnummer = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
                $stmt->execute(array($_POST["telnummer"], $_GET["reserveringnr"]));
                return TRUE;
                //$pdo = NULL;
                } else {
                $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van het telefoonnummer is niet gelukt!
                                    </div>";
                return FALSE;
            }
        }
        
        function wijzig_email() {
            global $pdo;
            if (!empty($_POST["email"]) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $stmt = $pdo->prepare("UPDATE klant SET email = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
                $stmt->execute(array($_POST["email"], $_GET["reserveringnr"]));
                return TRUE;
                //$pdo = NULL;
            } $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van het e-mail adres is niet gelukt!
                                    </div>";
                return FALSE;
            }
        
        function wijzig_postcode() {
            global $pdo;
            if (!empty($_POST["postcode"]) && preg_match("/^[a-zA-Z0-9\_]{6,6}/", $_POST["postcode"])) {
                $stmt = $pdo->prepare("UPDATE klant SET postcode = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
                $stmt->execute(array($_POST["postcode"], $_GET["reserveringnr"]));
                return TRUE;
                //$pdo = NULL;
            } $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van de postcode is niet gelukt!
                                    </div>";
                return FALSE;
            }
        
        
        function wijzig_huisnummer() {
            global $pdo;
            if (!empty($_POST["huisnummer"]) && preg_match("/^[0-9\_]/", $_POST["huisnummer"])) {
                $stmt = $pdo->prepare("UPDATE klant SET huisnummer = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
                $stmt->execute(array($_POST["huisnummer"], $_GET["reserveringnr"]));
                return TRUE;
                //$pdo = NULL;
            } $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van het huisnummer is niet gelukt!
                                    </div>";
                return FALSE;
            }
        
        
        function wijzig_straat() {
            global $pdo;
            if (!empty($_POST["straat"]) && preg_match("/^[a-zA-Z\_]/", $_POST["straat"])) {
                $stmt = $pdo->prepare("UPDATE klant SET straat = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
                $stmt->execute(array($_POST["straat"], $_GET["reserveringnr"]));
                return TRUE;
                //$pdo = NULL;
            } else {
                $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van de straatnaam is niet gelukt!
                                    </div>";
                return FALSE;
            }
        }
        
        function wijzig_woonplaats() {
            global $pdo;
            if (!empty($_POST["woonplaats"]) && preg_match("/^[a-zA-Z\_]/", $_POST["woonplaats"])) {
                $stmt = $pdo->prepare("UPDATE klant SET woonplaats = ? WHERE klantnr IN (SELECT klantnr FROM reservering WHERE reserveringnr = ?);");
                $stmt->execute(array($_POST["woonplaats"], $_GET["reserveringnr"]));
                return TRUE;
                //$pdo = NULL;
            } else {
                $_SESSION['message'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> &nbsp; Het wijzigen van het wijzigen van de woonplaats is niet gelukt!
                                    </div>";
                return FALSE;
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






