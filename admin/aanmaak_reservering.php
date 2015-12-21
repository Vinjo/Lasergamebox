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
                        <div class="row">
                                        <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-md-6 text-left">Persoonlijke gegevens:</div>
                                                <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Voornaam</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" name="naam" class="form-control">
                                                </div>
                                        
                                                <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Achternaam</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="datepicker1" name="achternaam" class="form-control">
                                                </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Telefoonnummer</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="datepicker1" name="achternaam" class="form-control">
                                                </div>
                                            
                                            <label class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">E-mail</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="datepicker1" name="achternaam" class="form-control">
                                                </div>
                                        </fieldset>
                                        <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="col-md-6 text-left">Bestelling:</div>
                                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Van</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input readonly type="text" name="naam" class="form-control">
                                                            </div>

                                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Tot</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input readonly type="text" id="datepicker1" name="achternaam" class="form-control">
                                                            </div>

                                                        <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Pistolen</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input type="text" id="datepicker1" name="achternaam" class="form-control">
                                                            </div>
                                        </fieldset>
                        </div><br>
                        <div class="row">
                                       <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-md-6 text-left">Adres gegevens:</div>
                                                <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Postcode</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" name="naam" class="form-control">
                                                </div>
                                        
                                                <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Huisnummer</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="datepicker1" name="achternaam" class="form-control">
                                                </div>
                                            
                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Straat</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="datepicker1" name="achternaam" class="form-control">
                                                </div>
                                            
                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Plaats</label>
                                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="datepicker1" name="achternaam" class="form-control">
                                                </div>
                                        </fieldset>
                                        <fieldset class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 control-label">Prijs Opgave:</div>
                                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Aanbetaling</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input type="text" placeholder="&#8364 NaN" id="aanbetaling_output" onBlur="omRekenen();" onkeyup="omRekenen();" readonly name="aanbetaling" class="form-control">
                                                            </div>
                                            
                                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Pakket kosten</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input type="text" placeholder="&#8364 NaN" id="prijs_output" onBlur="omRekenen();" onkeyup="omRekenen();" readonly name="pakket_kosten" class="form-control">
                                                            </div>
                                            
                                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Dagen</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input type="text" placeholder="N.V" id="dagen" readonly name="dagen" class="form-control">
                                                            </div>
                                            
                                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Borg</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input type="text" placeholder="&#8364 NaN" name="borg" readonly id="borg_output" onBlur="omRekenen();" onkeyup="omRekenen();" class="form-control">
                                                            </div>
                                            
                                                            <label class="col-lg-5 col-md-6 col-sm-6 col-xs-12 control-label pull-left">Totaal</label>
                                                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                                                                <input type="text" placeholder="&#8364 NaN" name="totaal" id="totaal_output" onBlur="omRekenen();" onkeyup="omRekenen();" readonly class="form-control">
                                                             </div>
                                        </fieldset> 
                        </div><br>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">       
                            <div class="pull-right">    
                                <div class="pull-right"><a href="overzicht_reserveringen.php" class="btn btn-danger">Terug</a> 
                                    <input value="Bevestigen" name="opslaan" type="submit" class="btn btn-success">
                                </div>
                            </div>
                        </div>     
            
                </form>
            </section>
            <!-- footer -->       
            <?php footer(); ?>

        </div> <!-- /container -->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php if (!is_dir('admin')) { print '../'; } ?>core/js/bootstrap.js"></script>

    </body>
</html>






