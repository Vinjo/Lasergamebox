<?php

include('../functions.php');

$reserveringnr = $_GET['reserveringnr'];

$factor = Factoren();

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
				
				$date1 = date_create(''.$van.'');
				$date2 = date_create(''.$tot.'');
				$dagen = date_diff($date1, $date2);
				
				if($dagen->days >= 0 && $dagen->days <= 1){
					//prijs perdag
					$pakketkosten = ($pistolen * $factor['pistoolPrijs']) + 10;
					$borg = $pakketkosten;
					$assortiment = "dag";
					
				}elseif($dagen->days >= 2 && $dagen->days <= 3){
					//prijs per weekend
					$pakketkosten = ($pistolen * $factor['pistoolPrijs'] + 10) * $factor['weekend'];
					$borg = $pakketkosten;
					$assortiment = "weekend";
					
				}else {
					//prijs per week
					$pakketkosten = ($pistolen * $factor['pistoolPrijs'] + 10) * $factor['week'];
					$borg = $pakketkosten;
					$assortiment = "week";
				}
				
				if($pistolen <= 10){
					$aanbetaling = 10;
				}else{
					$aanbetaling = 20;
				}
				$totaal = $aanbetaling + $pakketkosten + $borg;
                

require_once "pdf/dompdf_config.inc.php";
$dompdf = new DOMPDF();
$dompdf->set_paper("A4");
$html ='
<html>
<head>
<title>Reservering van '. $naam .' '.$achternaam.'</title>
<link type="text/css" href="../core/css/pdf.css" rel="stylesheet" />
</head>
<div class="bluebar"></div>
<div class="content">
		<table class="invoice">
		
			<tr>
				<td class="logo">
					<p class="h2">
						3893 JT Zeewolde, Nachtegaal 6 <br/> 
						06-52 65 40 53 of 06-48 15 04 11
						Kvk nummer: 58237356 
					</p>
				</td>
				<td>
					<div class="attentionto">
						<div class="client">	
							<p class="clientname">'.$naam.' '.$achternaam.'</p>
							<div class="bordertop"></div>
							<p>'.$woonplaats.', '.$postcode.'<br/>
							'.$straat.' '.$huisnummer.'</p>
						</div>
					</div>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<p>Reservering nummer: #'.$reserveringnr.'</p>
					<table class="invoicedetail">
						<thead>
						
						<td class="pistolen">Aantal pistolen</td>
						<td class="aanbetaling">Aanbetaling</td>
						<td class="assortiment">Assortiment</td>
						<td class="borg">Borg</td>
						<td class="subtotaal">Subtotaal</td>		
						
						</thead>
						<tbody>
						<tr>
							<td class="naam">'.$pistolen.'</td>
							<td class="aanbetaling">&#8364 '.$aanbetaling.',-</td>
							<td class="assortiment">(&#8364 '.$pakketkosten.',-) '.$assortiment.'</td>
							<td class="borg">&#8364 '.$borg.',-</td>	
							<td class="subtotal">&#8364 '.$totaal.',-</td>	
						</tr>
					</table>
				</td>
			</tr>
			
			<tr class="footer">
				<td style="padding-right: 20px">
					<p class="note">
					* Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sodales dapibus fermentum. Nunc adipiscing, magna sed scelerisque cursus, erat lectus dapibus urna, sed facilisis leo dui et ipsum.
					</p>
				</td>
				<td>
					<div class="totalall">
						<table>
							<tr>
								<td class="heading">
								Subtotaal
								</td>
								<td class="body">
								&#8364 '.$totaal.',-
								</td>
							</tr>
							<tr>
								<td class="heading">
								BTW (0%)
								</td>
								<td class="body">
								&#8364 0,0-
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="bordertop" style="margin-bottom: 10px;"></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
								Totaal
								</td>
								<td class="body">
								&#8364 '.$totaal.',-
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			
		</table>
	</div>	
<div class="bluebar footer"></div>
</body>
</html>
';

$dompdf->load_html($html);
$dompdf->render();
$dompdf->set_base_path('../core/css/pdf.css');
$dompdf->stream($reserveringnr, array("Attachment" => 0));

?>