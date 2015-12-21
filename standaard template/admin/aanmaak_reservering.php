<?php
require('../functions.php');
$access->admin();

$factor = Factoren();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script></script>
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
    





    </head>
    
    <body>
        <!-- Static navbar -->
            <?php static_navbar(); ?>
            
            
        
       
        <!-- Admin Bar -->
        <?php adminnav(); ?>
        
        <div class="container">
              
            <!-- Layout  -->
            <section>
                <?php aanmaak_reservering () ?>
              <div class="col-md-10 col-md-offset-1">
                <div id="aanmaak" class="tab-pane fade in active">
                    <div class="balk"><b>Aanmaken reservering</b></div> 
                    

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
                    
                    <form role="form" class="form-horizontal" method="POST" action="aanmaak_reservering.php">
                    <fieldset> 
                        
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Reserveringnr</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="<?php print $reserveringnr ?>" name="reserveringnr" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label" for="textinput">Klantnr</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="<?php print $klantnr ?>" name="klantnr" class="form-control">
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
                                                <input type="text" id="datepicker1" name="van" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Achternaam</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $achternaam ?>" name="achternaam" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Tot</label>
                                            <div class="col-md-4">
                                                <input type="text" id="datepicker2" name="tot" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Telefoonnummer</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $telefoonnummer ?>" name="telnummer" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Pistolen</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="<?php print $pistolen ?>" name="aantal_pistolen" id="pistolen_input" onBlur="omRekenen();" onkeyup="omRekenen();" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Email</label>
                                            <div class="col-md-4">
                                                <input  type="text" placeholder="<?php print $email ?>" name="email" class="form-control">
                                            
                                            </div>
                                            <label class="col-md-2 control-label">Status</label>
                                            <div class="col-md-4">
                                                <select class="form-control" id="status" name="status"> 
                                                    <option value="1">In beoordeling</option>
                                                    <option value="2">In behandeling</option>
                                                    <option value="3">Behandeld</option>
                                                </select>
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
                                                <input  type="text" name="postcode" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Aanbetaling</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="&#8364 NaN" id="aanbetaling_output" onBlur="omRekenen();" onkeyup="omRekenen();" readonly name="aanbetaling" class="form-control">
                                            </div>
                                        </div>                                        
                                        
                                         <div class="form-group">
                                            <label class="col-md-2 control-label">Huisnummer</label>
                                            <div class="col-md-4">
                                                <input  type="text" name="huisnummer" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Pakket kosten</label>
                                            <div class="col-md-2">
                                                <input type="text" placeholder="&#8364 NaN" id="prijs_output" onBlur="omRekenen();" onkeyup="omRekenen();" readonly name="pakket_kosten" class="form-control">
                                            </div>
                                         
                                        
                                        <label class="col-md-1 control-label">Dagen</label>
                                            <div class="col-md-1">
                                                <input type="text" placeholder="N.V" id="dagen" readonly name="dagen" class="form-control">
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Straat</label>
                                            <div class="col-md-4">
                                                <input  type="text" name="straat" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Borg</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="&#8364 NaN" name="borg" readonly id="borg_output" onBlur="omRekenen();" onkeyup="omRekenen();" class="form-control">
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Plaats</label>
                                            <div class="col-md-4">
                                                <input  type="text" name="woonplaats" class="form-control">
                                            </div>

                                            <label class="col-md-2 control-label">Totaal</label>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="&#8364 NaN" name="totaal" id="totaal_output" onBlur="omRekenen();" onkeyup="omRekenen();" readonly class="form-control">
                                            </div>
                                        </div>  
                                        <div class="form-group">       
                      <div class="col-sm-12">   <div class="balk"> <b>Na het aanmaken van een order wordt er direct een e-mail verstuurd naar het opgegeven emailadres met daarin de order.</b></div>
                                                
                                                    <div class="pull-right">    <a href="overzicht_reserveringen.php" class="btn btn-danger">Ga terug</a>
                                                                                                                        
                                                       <input type="submit" class="btn btn-success" name="opslaan" value="Opslaan"></div>
                            
                                            </div> </div>
                                </form>
                        
                  <div class="form-group">       
            
                
            </section>
            <!-- footer -->       
            <?php footer(); ?>

        </div> <!-- /container -->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php if (!is_dir('admin')) { print '../'; } ?>core/js/bootstrap.js"></script>

    </body>
</html>






