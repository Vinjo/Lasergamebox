<?php


//Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
    global $pdo;



    try {
        if (isset($_POST["opslaan"])) {

            if (empty($_POST["ww_oud"]) || empty($_POST["ww_nieuw1"]) || empty($_POST["ww_nieuw2"])) {
                print ('<div class="alert alert-warning" role="alert">Vul a.u.b. alle velden in.</div>');
            } elseif ($_POST['ww_oud'] != $_POST['wachtwoord']) {
                print('<div class="alert alert-warning" role="alert">Oud wachtwoord is niet correct!</div>');
            } elseif ($_POST['ww_nieuw1'] != $_POST['ww_nieuw2']) {
                print('<div class="alert alert-warning" role="alert"><strong>Let op!</strong>Het nieuwe wachtwoord komt niet met elkaar overeen</div>');
            } else {

                $ww_nieuw = $_POST['ww_nieuw1'];

                $salt = hash('sha256', $ww_nieuw);

                $stmt = $pdo->prepare("UPDATE medewerker SET wachtwoord=? WHERE=?");
                $stmt->execute(array($salt, $_POST["mnr"]));

                //als het goed is, is nu, als je het opvraagd uit de database... $_POST['wachtwoord'] gelijk aan het nieuwe wachtwoord van hierboven.

                $stmt = $pdo->prepare("SELECT * FROM medewerker WHERE=?");
                $stmt->execute($_POST['mnr']);

                $naam = $_POST["voornaam"];
                $achternaam = $_POST["achternaam"];
                $email = $_POST["email"];
                $pass = $_POST["pass"];

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
            }
        } else {

            print "<form role=\"form\" class=\"form-horizontal\" method=\"post\" action=\"wachtwoord_wijzig.php?mnr=$mnr\">";
            print "<fieldset>";
            print "<!-- Text input-->";
            print "<div class=\"form-group\">";
            print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Oud wachtwoord: </label>";
            print "<div class=\"col-sm-4\">";
            print "<input type=\"text\" placeholder=\"Oude wachtwoord\" name=\"ww_oud\" class=\"form-control\">";
            print "</div>";
            print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Nieuw wachtwoord: </label>";
            print "<div class=\"col-sm-4\">";
            print "<input type=\"password\" placeholder=\"Typ uw nieuwe wachtwoord\" name=\"ww_nieuw1\" class=\"form-control\">";
            print "</div>";
            print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Nieuw wachtwoord: </label>";
            print "<div class=\"col-sm-4\">";
            print "<input type=\"password\" placeholder=\"Typ uw nieuwe wachtwoord opnieuw\" name=\"ww_nieuw2\" class=\"form-control\">";
            print "</div>";
            print "</div>";
            print "<div class=\"form-group\">";
            print "<div class=\"col-sm-offset-2 col-sm-10\">";
            print "<div class=\"pull-right\">";
            print "<button type=\"submit\" class=\"btn btn-danger\">Annuleren</button>";
            print "<input type=\"submit\" class=\"btn btn-success\" name=\"opslaan\" value=\"Opslaan\">";
            print "</div>";
            print "</div>";
            print "</div>";
            print "</fieldset>";
            print "</form> ";
        }
    } catch (PDOException $e) {
        print "<div class=\"alert alert-danger\" role=\"alert\">Het wijzigen is mislukt. <a href=\"javascript: window.history.go(-1)\">Ga terug</a> </div>";
    }

    $pdo = NULL;

?>
