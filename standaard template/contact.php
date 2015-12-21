<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php head(); ?>
    </head>
    <body>


            <!-- Static navbar -->
              <?php static_navbar(); ?>
            <!-- /Static navbar -->

            <!-- admin navbar -->
              <?php adminnav(); ?>
            <!-- /admin navbar -->
        <div class="container">

            <!-- Layout  -->
            <section>

                <?php
				// print live cooldown
				 if($_SESSION['bericht_check'] == TRUE)
            {
				count_down_live(time()-$_SESSION['flood']['TijD']);
			}



                $goedbericht = FALSE;
                $errors = FALSE;
                $pattern = "/^[a-zA-Z0-9\_]{2,20}/";
                $telchecker = "/^[0-9\_]{10,10}/";

                if (isset($_POST['verstuur'])) {

                  // als er op de verstuurknop is gedrukt voert hij het volgende uit:

                  print ('<br>');

                  if (empty($_POST['naam']) || empty($_POST['email']) || empty($_POST['tel']) || empty($_POST['onderwerp']) || empty($_POST['bericht'])) {

                        $controler = array('Naam' => $_POST["naam"], 'E-mailadres' => $_POST["email"], 'Telefoonnummer' => $_POST['tel'], 'Onderwerp' => $_POST["onderwerp"], 'Bericht' => $_POST["bericht"]);

                        // als er iets niet is ingevuld, geeft hij een melding voor elk nog in te vullen veld:

                              foreach ($controler as $key => $waarde) {
                                if (empty($waarde)) {
                                  print('<div class="alert alert-danger" role="alert">' . $key . ' moet ingevuld zijn.</div>');
                                }
                              }

                              // dan geeft hij een melding of er iets mis is met de WEL ingevulde velden

                              if (!empty($_POST['naam']) && !preg_match($pattern,$_POST['naam'])) {
                                  ?><div class="alert alert-warning"> Naam mag geen speciale tekens bevatten.</div><?php
                                }
                              if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                                  ?><div class="alert alert-warning"> Ongeldig e-mailadres.</div><?php
                                }
                              if (!empty($_POST['tel']) && !preg_match($telchecker, $_POST['tel'])){
                                ?><div class="alert alert-warning"> Ongeldig telefoonnummer.</div><?php
                              }
                              if (!empty($_POST['onderwerp']) && !preg_match($pattern,$_POST['onderwerp'])) {
                                  ?><div class="alert alert-warning"> Onderwerp mag geen speciale tekens bevatten.</div><?php
                                }
                              if (!empty($_POST['bericht']) && strlen($_POST['bericht']) < 10){
                                  ?><div class="alert alert-warning"> Bericht is te kort.</div><?php
                              }
                            }

                    // als alles is ingevuld kijkt hij of alles klopt:

                    elseif (!empty($_POST['naam']) || !empty($_POST['email']) || !empty($_POST['tel']) || !empty($_POST['onderwerp']) || !empty($_POST['bericht'])) {

                      if (!empty($_POST['naam']) && !preg_match($pattern,$_POST['naam'])) {
                          ?><div class="alert alert-warning"> Naam mag geen speciale tekens bevatten.</div><?php
                          $errors = TRUE;
                        }
                      if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                          ?><div class="alert alert-warning"> Ongeldig e-mailadres.</div><?php
                          $errors = TRUE;
                        }
                        if (!empty($_POST['tel']) && !preg_match($telchecker, $_POST['tel'])){
                          ?><div class="alert alert-warning"> Ongeldig telefoonnummer.</div><?php
                          $errors = TRUE;
                        }
                      if (!empty($_POST['onderwerp']) && !preg_match($pattern,$_POST['onderwerp'])) {
                          ?><div class="alert alert-warning"> Onderwerp mag geen speciale tekens bevatten.</div><?php
                          $errors = TRUE;
                        }
                      if (!empty($_POST['bericht']) && strlen($_POST['bericht']) < 10){
                          ?><div class="alert alert-warning"> Bericht is te kort.</div><?php
                          $errors = TRUE;
                      }
                      if ($errors == FALSE) {

                         // als alles klopt stuurd hij de e-mail

                          $website_naam = 'Lazergamebox contact';

                          $site_emailadres = 'info@stomic.com';

                          $eigen_emailadres = 'mbutterhof@gmail.com';

                          $onderwerp = ucfirst($_POST['onderwerp']);

                          $naam_verzender = ucfirst($_POST['naam']);

                          $email_verzender = $_POST['email'];

                          $bericht = '<html><body>';
                          // $bericht .= '<img src="newton.ac.uk/files/covers/968361.jpg" alt="Lasergamebox" />';
                          $bericht .= "<h1>Nieuw bericht van de Lasergamebox contactpagina: </h1>";
                          $bericht .= "<p><strong>Bericht gestuurd door: </strong></p>";
                          $bericht .= "<p>Naam: " . ucfirst($_POST['naam']) . "</p>";
                          $bericht .= "<p>E-mailadres: " . $_POST['email'] . "</p>";
                          $bericht .= "<p>Telefoonnummer: " . $_POST['tel'] . "</p>";
                          $bericht .= "<p>Onderwerp: " . ucfirst($_POST['onderwerp']) . "</p>";
                          $bericht .= "<p><strong>Bericht: </strong></p>";
                          $bericht .= "<p>" . ucfirst($_POST['bericht']) . "</p>";
                          $bericht .= "<br>";
                          $bericht .= "<p><strong>Einde bericht. </strong> </p><p>Met vriendelijke groet,</p>";
                          $bericht .= "<p>Lasergamebox.nl</p>";
                          $bericht .= "</body></html>";

                          // HTML mail? True/False
                          $html = true;

                          // de headers
                          $headers	= 'From: ' . $website_naam . ' <' . $email_verzender . '>' . "\r\n";
                          $headers	.= 'Reply-To: ' . $naam_verzender . ' <' . $email_verzender . '>' . "\r\n";
                          $headers	.= 'X-Mailer: PHP/' . phpversion() . "\r\n";
                          $headers	.= 'X-Priority: Normal' . "\r\n";
                          $headers	.= ($html) ? 'MIME-Version: 1.0' . "\r\n" : '';
                          $headers	.= ($html) ? 'Content-type: text/html; charset=iso-8859-1' . "\r\n" : '';
						  antiflood();

                          mail($site_emailadres, $onderwerp, $bericht, $headers);
                          ?>

                          <div class="alert alert-success">
                              <strong>Uw bericht is verzonden!</strong> U ontvangt zo snel mogelijk een antwoord.
                          </div>

                          <?php
                          $goedbericht = TRUE;
                      }
                    }
                  }


                ?>

                <!-- het formulier -->

                <div class="row">
                    <div class="col-md-10 col-sm-10 col-md-offset-1 col-sm-offset-1">
                        <h1>Contact</h1>
                        <div class="col-md-5 col-sm-5">

                            <form name="contactform" method="post" action="contact.php" class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class=" control-label">Naam *</label> <br><br>

                                        <input type="text" name="naam" class="form-control invoer" id="inputName" placeholder="Naam" maxlength="20" value="<?php
                                        if ($goedbericht == FALSE && isset($_POST['naam'])){
                                          print ($_POST['naam']);
                                        }
                                        ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email" class=" control-label">E-mailadres *</label> <br><br>

                                        <input type="text" name="email" class="form-control invoer" id="mail" placeholder="E-mailadres" maxlength="30" value="<?php
                                        if ($goedbericht == FALSE && isset($_POST['email'])){
                                          print ($_POST['email']);
                                        }
                                        ?>">
                                </div>

                                <div class="form-group">
                                    <label for="tel" class=" control-label">Telefoonnummer *</label> <br><br>

                                        <input type="text" name="tel" class="form-control invoer" id="tel" placeholder="1234567890" maxlength="10" value="<?php
                                        if ($goedbericht == FALSE && isset($_POST['tel'])){
                                          print ($_POST['tel']);
                                        }
                                        ?>">
                                </div>

                                <div class="form-group">
                                    <label for="onderwerp" class="control-label">Onderwerp *</label> <br><br>

                                        <input type="text" name="onderwerp" class="form-control invoer" id="onderwerp" placeholder="Onderwerp" maxlength="20" value="<?php
                                        if ($goedbericht == FALSE && isset($_POST['onderwerp'])){
                                          print ($_POST['onderwerp']);
                                        }
                                        ?>">

                                </div>
                                <div class="form-group">
                                    <label for="bericht" class=" control-label">Bericht *</label> <br><br>

                                        <textarea type="text" name="bericht"  class="form-control bericht-contact invoer" rows="5" maxlength="300" id="bericht"
                                                  placeholder="Typ hier uw bericht."><?php if ($goedbericht == FALSE && isset($_POST['bericht'])){
                                                    print ($_POST['bericht']);
                                                  } ?></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="pull-right">
                                        <button type="submit" name="verstuur" class="btn btn-contact btn-success">Verstuur</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="bedrijfsinfo col-md-4 col-md-offset-1 col-sm-5 col-sm-offset-1 hidden-xs">
                            <p>Nachtegaal 6 <br>
                               3893 JT   Zeewolde <br>
                               06-52654053 of 06-48150411 <br>
                               Kvk nummer: 58237356 <br>
                            </p>
                            <br>
                            <p> Stuur ons gerust een bericht.<br>Wij proberen hier zo spoedig mogelijk op terug te komen. </p>
                        </div>

                    </div>
                </div>

            </section>

            <!-- footer -->
            <?php footer(); ?>

        </div> <!-- /container -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php
            if (!is_dir('admin')) {
                print '../';
            }
            ?>core/js/bootstrap.js"></script>
    </body>