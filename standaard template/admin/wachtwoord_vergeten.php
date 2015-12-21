<?php
include '../functions.php';
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
//Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.

                global $pdo;

                try {

                    if ($_GET['restorecode'] != "") {

                        // als hij via de link in de email op de pagina ziet hij het wachtwoord herstel formulier

                        $stmt = $pdo->prepare("SELECT mnr FROM medewerker WHERE restorecode=?");
                        $stmt->execute(array($_GET['restorecode']));

                        $medewerker = $stmt->fetch();

                        $mnr = $medewerker['mnr'];

                        if ($mnr == "") {
                            ?><br><div class="alert alert-danger">Verkeerde code of de code is al gebruikt.</div><?php
                        }

                        if (isset($_POST["submitww"])) {

                            if ($_POST['ww_nieuw1'] != $_POST['ww_nieuw2']) {
                                print('<div class="alert alert-warning" role="alert"><strong>Let op!</strong>Het nieuwe wachtwoord komt niet met elkaar overeen</div>');
                            } else {

                                $ww_nieuw = $_POST['ww_nieuw1'];

                                $salt = hash('sha256', $ww_nieuw);

                                $stmt = $pdo->prepare("UPDATE medewerker SET wachtwoord=? WHERE=?");
                                $stmt->execute(array($salt, $mnr));

                                //als het goed is, is nu, als je het opvraagd uit de database... $_POST['wachtwoord'] gelijk aan het nieuwe wachtwoord van hierboven.

                                $stmt = $pdo->prepare("SELECT * FROM medewerker WHERE=?");
                                $stmt->execute($mnr);

                                $naam = $stmt["voornaam"];
                                $achternaam = $stmt["achternaam"];
                                $email = $stmt["email"];
                                $pass = $ww_nieuw;

                                print("<div class=\"alert alert-success\" id=\"success-alert\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                <strong>Uw wachtwoord is gewijzigd!</strong>U ontvangt binnenkort een e-mail met uw nieuwe wachtwoord.</div>");

                                print ('<a href="project.stomic.com/adminDashboard"/>' . 'Ga terug' . '</a>');

                                $to = $email;

                                $subject = 'Wachtwoord gewijzigd';
                                $headers = "From: info@stomic.com\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                                $message = '<html><body>';
                                $message .= '<img src="http://project.stomic.com/core/img/slide1.jpg" height="200" width="700" alt="lasergamebox.nl" />';
                                $message .= '<h1>Lasergamebox.nl</h1>';
                                $message .= '<h3>Inlog gegevens</h3>';
                                $message .= '<p>Beste ' . $naam . '</p>';
                                $message .= 'Uw wachtwoord is reeds gewijzigd.<br>';
                                $message .= 'U kunt nu inloggen met uw nieuwe wachtwoord: <br>';
                                $message .= "<p><strong>Wachtwoord:</strong> " . $pass . "</p>";
                                $message .= '<p><strong>Login: </strong><a href="http://project.stomic.com/admin">admin paneel</a><p>';
                                $message .= '<p></p>';
                                $message .= "</body></html>";

                                mail($to, $subject, $message, $headers);

                                $stmt = $pdo->prepare("DELETE restorecode FROM medewerker WHERE mnr=?");
                                $stmt->execute($_POST['mnr']);
                            }
                        }
                        ?>

                        <div class="col-md-12 text-center">
                            <h2><b>Wachtwoord herstel</b></h2> </div>
                        <div class="col-md-6 col-md-offset-2">

                          <br>

                                    <form method="post" action="wachtwoord_vergeten.php" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4" control-label for="textinput">Nieuw wachtwoord</label> <br><br>
                                            <div class="col-sm-8">
                                            <input type="text" name="ww_nieuw1" class="form-control invoer" id="mail" placeholder="Nieuw wachtwoord" maxlength="30">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nieuwww" class="col-sm-4" control-label>Opnieuw nieuw wachtwoord</label> <br><br>
                                              <div class="col-sm-8">
                                            <input type="text" name="ww_nieuw2" class="form-control invoer" id="mail" placeholder="Nieuw wachtwoord" maxlength="30">
                                        </div>
                                      </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <input class="btn btn-md btn-success btn-block" type="submit" name="submitww" value="Verstuur">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-10 col-lg-offset-1">
                                </div>
                            </div>

                        <?php
                    } else {

                        // wachtwoord_vergeten.php hieronder
                        // hier komt wachtwoord_vergeten() function
                        // met het email formulier
                        // om de herstel code te krijgen

                        $goedbericht = FALSE;

                        if (isset($_POST['submit'])) {

                            $emailerror1 = FALSE;

                            if (empty($_POST['email'])) {
                                ?><br><div class="alert alert-danger">Vul a.u.b. uw e-mail in.</div><?php
                            } elseif (!empty($_POST['email'])) {

                                $stmt = $pdo->prepare("SELECT mnr FROM medewerker WHERE email=?");
                                $stmt->execute(array($_POST['email']));

                                $medewerker = $stmt->fetch();

                                $mnr = $medewerker['mnr'];

                                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == FALSE) {
                                    ?><br><div class="alert alert-danger">Ongeldig e-mailadres.</div><?php
                                    $emailerror1 = TRUE;
                                } elseif ($mnr == "" AND $emailerror1 == FALSE) {
                                    ?><br><div class="alert alert-danger">Account niet gevonden.</div><?php
                                } else {

                                    function generateRandomString($length = 45) {
                                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                        $charactersLength = strlen($characters);
                                        $randomString = '';
                                        for ($i = 0; $i < $length; $i++) {
                                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                                        }
                                        return $randomString;
                                    }

                                    $restorecode = generateRandomString();

                                    $stmt1 = $pdo->prepare("UPDATE medewerker SET restorecode='$restorecode' WHERE email=?");
                                    $stmt1->execute(array($_POST['email']));

                                    // medewerker heeft nu een restorecode gelinked aan zijn account in de database

                                    $stmt = $pdo->prepare("SELECT * FROM medewerker WHERE email=?");
                                    $stmt->execute(array($_POST['email']));
                                    $medewerker = $stmt->fetch();

                                    $accountvnaam = $medewerker['naam'];
                                    $accountanaam = $medewerker['achternaam'];
                                    $email = $medewerker['email'];
                                    $restorecode = $medewerker['restorecode'];
                                    $restorecodelink = "<a href='http://project.stomic.com/admin/wachtwoord_vergeten.php/?restorecode=" . $restorecode . "'>Wachtwoord herstellen.</a>";

                                    $website_naam = 'Lasergamebox.nl';
                                    $site_emailadres = 'info@stomic.com';
                                    $eigen_emailadres = 'info@stomic.com';
                                    $onderwerp = 'Wachtwoord vergeten';

                                    $bericht = '<html><body>';
                                    // $bericht .= '<img src="newton.ac.uk/files/covers/968361.jpg" alt="Lasergamebox" />';
                                    $bericht .= "<p>Beste " . $accountvnaam . " " . $accountanaam . ",<br><br>Iemand heeft een Lasergamebox wachtwoord herstel aangevraagd voor het account op dit e-mailadres.<br>Als u dit niet was, negeer dan deze e-mail.<br></p>";
                                    $bericht .= "<p>Account: $email <br></p>";
                                    $bericht .= "<p>Klik de onderstaande link om uw wachtwoord te herstellen.</p>";
                                    $bericht .= "<p>" . $restorecodelink . "<br></p>";
                                    $bericht .= "<p>Of kopieer en plak de volgende link in uw browser:</p>";
                                    $bericht .= "<p>http://project.stomic.com/admin/wachtwoord_vergeten.php?restorecode=" . $restorecode . "</p>";
                                    $bericht .= "</body></html>";

                                    // HTML mail? True/False
                                    $html = true;

                                    // de headers
                                    $headers = 'From: ' . $website_naam . ' <' . $site_emailadres . '>' . "\r\n";
                                    $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
                                    $headers .= 'X-Priority: Normal' . "\r\n";
                                    $headers .= ($html) ? 'MIME-Version: 1.0' . "\r\n" : '';
                                    $headers .= ($html) ? 'Content-type: text/html; charset=iso-8859-1' . "\r\n" : '';

                                    mail($eigen_emailadres, $onderwerp, $bericht, $headers);
                                    ?>

                                    <br><div class="alert alert-success">Bekijk uw e-mail.</div>

                                    <?php
                                    $goedbericht = TRUE;
                                }
                            }
                        }
                        ?>

                        <!-- Text input-->
                        <div class="col-md-12 text-center">
                            <h2><b>Wachtwoord vergeten</b></h2> </div>
                        <div class="col-md-6 col-md-offset-2">

                            <br>

                            <form action="wachtwoord_vergeten.php" class="form-horizontal" method="POST">
                                <div class="form-group">
                                    <label class="col-sm-4" control-label for="textinput">Email</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" placeholder="E-mail" name="email" maxlength="200" value="<?php
                                        if ($goedbericht == FALSE && isset($_POST['email'])) {
                                            print ($_POST['email']);
                                        }
                                        ?>" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <input class="btn btn-md btn-success btn-block" type="submit" name="submit" value="Verstuur">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php
                    }
                } catch (PDOException $e) {
                    print "<div class=\"alert alert-danger\" role=\"alert\">Het wijzigen is mislukt. <a href=\"javascript: window.history.go(-1)\">Ga terug</a> </div>";
                }

                $pdo = NULL;
                ?>
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
</html>