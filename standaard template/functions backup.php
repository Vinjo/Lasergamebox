<?php
require("config.php");


/* Alle dingen die terug komen op pagina's, zoals headers, navigatie balken en footers */

function head() {
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php retrieveTitle(); ?></title>

    <!-- Bootstrap -->
    <link href="<?php
    if (!is_dir('admin')) {
        print '../';
    }
    ?>core/css/bootstrap.css" rel="stylesheet">
    <link href="<?php
    if (!is_dir('admin')) {
        print '../';
    }
    ?>core/css/style.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-1.6.3.min.js"></script>
    <script src="<?php
    if (!is_dir('admin')) {
        print '../';
    }
    ?>core/js/jquery.js"/></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#myTab a:first").tab('show');
        });

        $(function () {
            // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // save the latest tab; use cookies if you like 'em better:
                localStorage.setItem('lastTab', $(this).attr('href'));
            });

            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
            ;


            $(function () {
                $("#editor").wysibb();
            });
        });
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
}

function retrieveTitle() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM SiteGegevens;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $sitenaam = $row['sitenaam'];
        print ($sitenaam);
    }
}

function static_navbar() {
    ?>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand navbar-brand-centered">LaserGameBox</div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-brand-centered">
                <ul class="nav navbar-nav">
                    <li><a href="<?php
                        if (!is_dir('admin')) {
                            print '../';
                        }
                        ?>index.php">Home</a></li>
                    <li><a href="<?php
                        if (!is_dir('admin')) {
                            print '../';
                        }
                        ?>over-ons.php">Over ons</a></li>
                    <li><a href="<?php
                        if (!is_dir('admin')) {
                            print '../';
                        }
                        ?>pakketten.php">Pakketten</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php
                        if (!is_dir('admin')) {
                            print '../';
                        }
                        ?>contact.php">Contact</a></li>
                    <li><a href="<?php
                        if (!is_dir('admin')) {
                            print '../';
                        }
                        ?>reservering.php">Mijn reservering</a></li>
                    <li><a target="_blank" href="http://facebook.com"><i class="fa fa-facebook-square"></i></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <?php
}

function adminnav() {
    if ($_SESSION['login'] == TRUE) {
        ?>
        <div class="adminnav col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <li class="dropdown pull-right"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Hallo, <?php print $_SESSION['naam'] . " "; ?><b class="caret"></b></a>
                <ul class="dropdown-menu list-inline">
                    <li class="col-xs-12"><a href="<?php
                        if (is_dir('admin')) {
                            print 'admin/';
                        }
                        ?>index.php"><span class="glyphicon glyphicon-stats"></span>Dashboard</a></li>
                                             <?php if ($_SESSION['functie'] == "Administrator") { ?>
                        <li class="col-xs-12"><a href="<?php
                            if (is_dir('admin')) {
                                print 'admin/';
                            }
                            ?>overzicht_reserveringen.php"><span class="glyphicon glyphicon-tasks"></span>Reserveringen</a></li>
                        <li class="col-xs-12"><a href="<?php
                            if (is_dir('admin')) {
                                print 'admin/';
                            }
                            ?>overzicht_medewerkers.php"><span class="glyphicon glyphicon-user"></span>Accounts</a></li>
                                             <?php } ?>
                    <li class="col-xs-12"><a href="<?php
                        if (is_dir('admin')) {
                            print 'admin/';
                        }
                        ?>overzicht_paginas.php"><span class="glyphicon glyphicon-book"></span>Pages</a></li>
                    <li class="divider col-xs-12"></li>
                    <li class="col-xs-12"><a href="<?php
                        if (is_dir('admin')) {
                            print 'admin/';
                        }
                        ?>account.php"><span class="glyphicon glyphicon-user"></span>Mijn Account</a></li>
                    <li class="col-xs-12"><a href="<?php
                        if (is_dir('admin')) {
                            print 'admin/';
                        }
                        ?>instellingen.php"><span class="glyphicon glyphicon-cog"></span>Instellingen</a></li>
                    <li class="col-xs-12"><a href="<?php
                        if (is_dir('admin')) {
                            print 'admin/';
                        }
                        ?>logout.php"><span class="glyphicon glyphicon-off"></span>Uitloggen</a></li>
                </ul>
            </li>
        </div>
        <?php
    }
}

function headerwrap() {
    ?>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1>Lasergamebox</h1>
                <p>Lasergamen in je eigen omgeving!</p>
                <hr class="light">
                <a href="tel:0652654053" class="btn btn-primary hidden-lg hidden-md hidden"><span class="glyphicon glyphicon-phone-alt"></span> Bel ons.</a>
                <a href="/reserveren.php" class="btn btn-primary">Reserveer direct!</a>
            </div>
        </div>
    </header>

    <?php
}

function carousel() {
    ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img class="first-slide" src="core/img/slide1.jpg" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h2>Lasergamen in je eigen omgeving.</h2>
                            <p></p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Reserveer nu!</a></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img class="second-slide" src="core/img/slide1.jpg" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h2>Vrijgezellenfeest?</h2>
                            <p>Ga gezellig met zijn allen lasergamen in een leuke of spannende omgeving. Voor jong en oud!</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Reserveer nu!</a></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img class="third-slide" src="core/img/slide1.jpg" alt="Third slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h2>Geen inspiratie voor een kinderfeestje?</h2>
                            <p>Ga gezellig met zijn allen lasergamen in een leuke of spannende omgeving. Neem de kinderen mee naar het bos! Laat ze daar elkaar beschieten!</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Reserveer nu!</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div><!-- /.carousel -->
        <?php
    }

function reservation_bar() {
        ?>
        <div class="reservation hidden-xs">
            <div class="row">
                <div class="col-lg-12 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
                    <div class="input-group">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="input-group reserveerbar">
                                <span class="input-group-addon" id="sizing-addon2">Van: </span>
                                <input type="text" class="form-control" placeholder="" aria-describedby="sizing-addon2">
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="input-group reserveerbar">
                                <span class="input-group-addon" id="sizing-addon2">Tot:</span>
                                <input type="text" class="form-control" placeholder="" aria-describedby="sizing-addon2">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                            <div class="input-group spinner reserveerbar">
                                <span class="input-group-addon" id="sizing-addon2">Aantal Pistolen:</span>
                                <input type="text" class="form-control" value="6" min="6" max="<?php onzichtbareVoorraad(); ?>">
                                <div class="input-group-btn-vertical">
                                    <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                                    <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 reserveerbar">
                            <a class="btn btn-primary reserveerknop" href="#" role="button">Reserveer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

function footer() {
        ?>
        <footer>
            <div class="col-md-12">
                <p class="text-right">&copy; <?php echo date("Y"); ?> Lasergamebox.nl. Lasergamebox.nl is een onderdeel van GFretail.</p>
            </div>
        </footer>

        <?php
    }

    /* Account overzicht op de website */

function overzicht_medewerkers() {
        ?>
        <div class="col-md-10 col-md-offset-1">
                    <div class="bs-example">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a data-toggle="tab" href="#overzicht">Account overzicht</a></li>
                            <li><a data-toggle="tab" href="#toevoegen">Account toevoegen</a></li>
                            <!-- <li class="pull-right"><input type="text" class="form-control search-form" placeholder="Zoeken" ></li> -->
                        </ul>
                        <div class="tab-content">
                            <div id="overzicht" class="tab-pane fade in active ">
                                <p><table class = "table table-hover"><thead>
                                        <tr>
                                            <th>Naam</th>
                                            <th>Achternaam</th>
                                            <th>E-mail</th>
                                            <th>Rechten</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <?php account_overzicht(); ?>
                                </table></p>
                            </div>
                            <div id="toevoegen" class="tab-pane fade">
                                <div class="balk"><b>Gegevens account</b></div>
                                <script>
                                    $('#form-content').on('show.bs.modal', function (e) {
                                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                                    });
                                </script>

                                <form role="form" class="form-horizontal" method="post" action="overzicht_medewerkers.php">
                                    <fieldset>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="textinput">Voornaam</label>
                                            <div class="col-sm-4">
                                                <input type="text" placeholder="Voornaam" name="voornaam" class="form-control">
                                            </div>

                                            <label class="col-sm-2 control-label" for="textinput">Achternaam</label>
                                            <div class="col-sm-4">
                                                <input type="text" placeholder="Achternaam" name="achternaam" class="form-control">
                                            </div>
                                        </div>


                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="textinput">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Email" name="email" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="textinput">Wachtwoord</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Wachtwoord" name="pass" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="textinput">Functie</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="functie" name="functie">
                                                    <option>Administrator</option>
                                                    <option>Web-administrator</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="balk"><b>Na het aanmaken van een account word er een email verstuurd naar opgegeven emailadres met daarin de inlog gegevens.</b></div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="pull-right">
                                                    <input type="submit" class="btn btn-primary" name="toevoegen" value="Toevoegen">
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div> <!-- einde van tab-content -->
        <?php
    }

    function account_overzicht() {
//Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM medewerker");
        $stmt->execute();
        $medewerkers = $stmt->fetchAll();

        foreach ($medewerkers as $medewerker) {
            print("<tr class=\"active\">");
            print("<td>" . $medewerker["naam"] . "</td>");
            print("<td>" . $medewerker["achternaam"] . "</td>");
            print("<td>" . $medewerker["email"] . "</td>");
            print("<td>" . $medewerker["functie"] . "</td>");
            if ($medewerker["mnr"] != $_SESSION['mnr']) {
            print("<td>
                    <div class=\"btn-group\">
                        <a class=\"btn btn-default\" href=\"account_wijzig.php?mnr=" . $medewerker['mnr'] . "\">
                            <i class=\"fa fa-pencil-square-o\"></i>
                        </a>
                        <a class=\"btn btn-default\" onclick=\"return confirm('Weet u zeker dat u deze medewerker wilt verwijderen?')\" name=\"delete\" href=\"overzicht_medewerkers.php?delete=true&mnr=" . $medewerker['mnr'] . "\">
                            <i class=\"fa fa-times\"></i>
                        </a>
                    </div>
                </td>");
            } else {
                print("<td></td>");
            }
            print("</tr>");
        }
    }

    /* Aanmaken reservering voor de klant, door de admin */

    function aanmaak_reservering() {

        global $pdo;

        $reserveringnr = "";
        if (isset($_POST["reserveringnr"])) {
            $reserverinsnr = $_POST["reserverinsnr"];
        }

        $klantnr = "";
        if (isset($_POST["klantnr"])) {
            $klantnr = $_POST["klantnr"];
        }

        $status = "";
        if (isset($_POST["status"])) {
            $status = $_POST["status"];
        }

        $naam = "";
        if (isset($_POST["naam"])) {
            $naam = $_POST["naam"];
        }

        $achternaam = "";
        if (isset($_POST["achternaam"])) {
            $achternaam = $_POST["achternaam"];
        }

        $telnummer = "";
        if (isset($_POST["telnummer"])) {
            $telnummer = $_POST["telnummer"];
        }

        $email = "";
        if (isset($_POST["email"])) {
            $email = $_POST["email"];
        }

        $postcode = "";
        if (isset($_POST["postcode"])) {
            $postcode = $_POST["postcode"];
        }

        $huisnummer = "";
        if (isset($_POST["huisnummer"])) {
            $huisnummer = $_POST["huisnummer"];
        }

        $straat = "";
        if (isset($_POST["straat"])) {
            $straat = $_POST["straat"];
        }

        $woonplaats = "";
        if (isset($_POST["woonplaats"])) {
            $woonplaats = $_POST["woonplaats"];
        }
        //datum moet nog andersom!!

        $van = "";
        if (isset($_POST["van"])) {
            $van = $_POST["van"];
        }

        $tot = "";
        if (isset($_POST["tot"])) {
            $tot = $_POST["tot"];
        }

        $aantal_pistolen = "";
        if (isset($_POST["aantal_pistolen"])) {
            $aantal_pistolen = $_POST["aantal_pistolen"];
        }

        $aanbetaling = "";
        if (isset($_POST["aanbetaling"])) {
            $aanbetaling = $_POST["aanbetaling"];
        }

        $pakket_kosten = "";
        if (isset($_POST["pakket_kosten"])) {
            $pakket_kosten = $_POST["pakket_kosten"];
        }

        $borg = "";
        if (isset($_POST["borg"])) {
            $borg = $_POST["borg"];
        }

        $totaal = "";
        if (isset($_POST["totaal"])) {
            $totaal = $_POST["totaal"];
        }

        $array = array();

        try {
			print ('<br>');
            //hier is gekozen voor het controleren op empty en niet voor isset - op moment dat er een spatie is ingevuld is de string al niet meer empty dus wordt de isset functie TRUE
            if (isset($_POST["opslaan"]) && (empty($_POST["checkbox"])) && (empty($_POST["reserveringnr"]) || empty($_POST["klantnr"]) || empty($_POST["status"]) || empty($_POST["naam"]) || empty($_POST["achternaam"]) || empty($_POST["telnummer"]) || empty($_POST["postcode"]) || empty($_POST["huisnummer"]) || empty($_POST["straat"]) || empty($_POST["woonplaats"]) || empty($_POST["van"]) || empty($_POST["tot"]) || empty($_POST["aantal_pistolen"]) || empty($_POST["aanbetaling"]) || empty($_POST["pakket_kosten"]) || empty($_POST["borg"]) || empty($_POST["totaal"]) || empty($_POST["email"]) )) {

                $controler = array('Voornaam' => $_POST["naam"], 'Achternaam' => $_POST["achternaam"], 'Email' => $_POST["email"], 'Reserveringnr' => $_POST["reserveringnr"], 'Klantnr' => $_POST["status"], 'Telefoonnummer' => $_POST["telnummer"],
                    'Postcode' => $_POST["postcode"], 'Huisnummer' => $_POST["huisnummer"], 'Straat' => $_POST["straat"], 'Plaats' => $_POST["plaats"], 'Van welke datum?' => $_POST["van"],
                    'Tot welke datum?' => $_POST["tot"], 'Aantal pistolen' => $_POST["aantal_pistolen"], 'Aanbetaling' => $_POST["aanbetaling"], 'Pakket kosten' => $_POST["pakket_kosten"],
                    'Borg' => $_POST["borg"], 'Totaal' => $_POST["totaal"]);

                foreach ($controler as $key => $waarde) {
                    if (empty($waarde)) {
                        print('<div class="alert alert-danger" role="alert">' . $key . ' is leeg.</div>');
                    }
                }
            } else {

                $stmt = $pdo->prepare("INSERT INTO klant (klantnr, naam, achternaam, email, telnummer, straat, huisnummer, woonplaats, postcode) VALUES(?,?,?,?,?,?,?,?,?)");
                $stmt->execute(array($_POST["klantnr"], $_POST["naam"], $_POST["achternaam"], $_POST["email"], $_POST["telnummer"], $_POST["straat"], $_POST["huisnummer"], $_POST["woonplaats"], $_POST["postcode"]));

                $stmt = $pdo->prepare("INSERT INTO reservering (reserveringnr, klantnr, aantal_pistolen, van, tot, status) VALUES(?, ?, ?, ?, ?, ?)");
                $stmt->execute(array($_POST["reserveringnr"], $_POST["klantnr"], $_POST["aantal_pistolen"], $_POST["van"], $_POST["tot"], $_POST["status"]));

                if ($stmt->rowCount() == 1) {
                    // als de klant is toegevoegd worden de ingevoerde waarden niet opnieuw getoond
                    $naam = $_POST["naam"];
                    $achternaam = $_POST["achternaam"];
                    $email = $_POST["email"];
                    $klantnr = $_POST["klantnr"];
                    $telnummer = $_POST["telnummer"];
                    $straat = $_POST["straat"];
                    $huisnummer = $_POST["huisnummer"];
                    $woonplaats = $_POST["woonplaats"];
                    $postcode = $_POST["postcode"];
                    $reserveringnr = $_POST["reserveringnr"];
                    $aantal_pistolen = $_POST["aantal_pistolen"];
                    $van = $_POST["van"];
                    $tot = $_POST["tot"];
                    $status = $_POST["status"];
                    print("<div class=\"alert alert-success\" id=\"success-alert\">
                         <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                         <strong>Gelukt!</strong>
                         Reservering aangemaakt.
                         </div>");

                    $to = $email;
                    $subject = 'Reservering van lasergamepistolen';
                    $headers = "From: info@stomic.com\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $message = '<html><body>';
                    $message .= '<img src="http://project.stomic.com/core/img/slide1.jpg" height="200" width="700" alt="lasergamebox.nl" />';
                    $message .= '<h1>Lasergamebox.nl</h1>';
                    $message .= '<h3>Inlog gegevens</h3>';
                    $message .= '<p>Beste ' . $naam . '</p>';
                    $message .= 'Wij hebben succesvol een reservering voor u kunnen plaatsen.<br>';
                    $message .= 'Je kunt inloggen met de volgende gegevens:<br>';
                    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                    $message .= "<tr><td><strong>Email:</strong> </td><td>" . $email . "</td></tr>";
                    $message .= "<tr><td><strong>Reserveringsnummer:</strong> </td><td>" . $reserveringnr . "</td></tr>";
                    $message .= '<tr><td><strong>Login:</strong> </td><td><a href="http://project.stomic.com/reservering.php">Mijn reservering</a></td></tr>';
                    $message .= "</table>";
                    $message .= '<p></p>';
                    $message .= "</body></html>";

                    mail($to, $subject, $message, $headers);
                }
            }
        } catch (PDOException $e) {
            print "<div class=\"alert alert-danger\" role=\"alert\">Het aanmaken is mislukt. <a href=\"javascript: window.history.go(-1)\">Ga terug</a> </div>";
        }
        $pdo = NULL;
    }

    /* Account toevoegen op de website */

    function account_toevoegen() {
//Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
        global $pdo;
/*
        $naam = "";
        if (isset($_POST["voornaam"])) {
            $naam = $_POST["voornaam"];
        }

        $achternaam = "";
        if (isset($_POST["achternaam"])) {
            $achternaam = $_POST["achternaam"];
        }

        $email = "";
        if (isset($_POST["email"])) {
            $achternaam = $_POST["email"];
        }

        $functie = "";
        if (isset($_POST["functie"])) {
            $functie = $_POST["functie"];
        }
        $pass = "";

        if (isset($_POST["pass"])) {
            $pass = $_POST["pass"];
        }
        $medewerker = array();
*/
            //hier is gekozen voor het controleren op empty en niet voor isset - op moment dat er een spatie is ingevuld is de string al niet meer empty dus wordt de isset functie TRUE
            if (empty($_POST["voornaam"]) OR empty($_POST["achternaam"]) OR empty($_POST["email"]) OR empty($_POST["pass"])) {

                        $_SESSION['AccountStatus'] = TRUE;
                        $_SESSION['AccountMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                        <strong>Mislukt!</strong> Vul a.u.b alle gegevens in.
                        </div>";
            } else {

                $stmt = $pdo->prepare("SELECT * FROM medewerker WHERE email=?");
                $stmt->execute(array($_POST["email"]));

                if ($stmt->rowCount() == 1) {
                            $_SESSION['AccountStatus'] = TRUE;
                                $_SESSION['AccountMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> Een medewerker met dit e-mail adres staat al in het systeem geregistreerd.
                                    </div>";
                } else {
                            $salt = hash('sha256', $pass);

                            $stmt = $pdo->prepare("INSERT INTO medewerker (naam,achternaam,wachtwoord,email,functie) VALUES(?,?,?,?,?)");
                            $stmt->execute(array($_POST["voornaam"], $_POST["achternaam"], $salt, $_POST["email"], $_POST["functie"]));

                            if ($stmt->rowCount() == 1) {
                                $_SESSION['AccountStatus'] = TRUE;
                                $_SESSION['AccountMessage'] = "<div class=\"alert alert-success\" id=\"success-alert\">
                                   <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                   <strong>Gelukt!</strong>
                                   Medewerker toegevoegd.
                                   </div>";
                                // als de medewerker is toegevoegd worden de ingevoerde waarden niet opnieuw getoond
                                $naam = $_POST["voornaam"];
                                $achternaam = $_POST["achternaam"];
                                $email = $_POST["email"];
                                $pass = $_POST["pass"];


                                $to = $email;
                                $subject = 'Account registratie';
                                $headers = "From: info@stomic.com\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                                $message = '<html><body>';
                                $message .= '<img src="http://project.stomic.com/core/img/slide1.jpg" height="200" width="700" alt="lasergamebox.nl" />';
                                $message .= '<h1>Lasergamebox.nl</h1>';
                                $message .= '<h3>Inlog gegevens</h3>';
                                $message .= '<p>Beste ' . $naam . '</p>';
                                $message .= 'Je bent succesvol geregistreerd op de website.<br>';
                                $message .= 'Je kunt inloggen met de volgende gegevens:<br>';
                                $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                                $message .= "<tr><td><strong>Email:</strong> </td><td>" . $email . "</td></tr>";
                                $message .= "<tr><td><strong>Wachtwoord:</strong> </td><td>" . $pass . "</td></tr>";
                                $message .= '<tr><td><strong>Login:</strong> </td><td><a href="http://project.stomic.com/admin">admin paneel</a></td></tr>';
                                $message .= "</table>";
                                $message .= '<p></p>';
                                $message .= "</body></html>";

                                mail($to, $subject, $message, $headers);
                            }
                }
            }

        $pdo = NULL;
    }

    /* Account wijzigen op de website */

    function account_wijzig() {
//Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
        global $pdo;



        try {
            if (isset($_POST["opslaan"])) {



                if (!empty($_POST['pass'])) {
                    $pass = $_POST['pass'];
                    $salted = hash('sha256', $pass);


                    $stmt = $pdo->prepare("UPDATE medewerker SET naam=?,achternaam=?,email=?,functie=?,wachtwoord=? WHERE mnr=?");
                    $stmt->execute(array($_POST["voornaam"], $_POST["achternaam"], $_POST["email"], $_POST["functie"], $salted, $_GET["mnr"]));
                    print("<div class=\"alert alert-success\" id=\"success-alert\">
               <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
               <strong>Gelukt!</strong>
               Medewerker bewerkt
               </div>");
                } elseif (empty($_POST["voornaam"]) || empty($_POST["achternaam"]) || empty($_POST["email"])) {

                    $controler = array('Voornaam' => $_POST["voornaam"], 'Achternaam' => $_POST["achternaam"], 'Email' => $_POST["email"]);

                    foreach ($controler as $key => $waarde) {
                        if (empty($waarde)) {
                            print('<div class="alert alert-danger" role="alert">' . $key . ' mag niet leeg zijn</div>');
                        }
                    }
                } else {

                    $stmt = $pdo->prepare("UPDATE medewerker SET naam=?,achternaam=?,email=?,functie=? WHERE mnr=?");
                    $stmt->execute(array($_POST["voornaam"], $_POST["achternaam"], $_POST["email"], $_POST["functie"], $_GET["mnr"]));
                    print("<div class=\"alert alert-success\" id=\"success-alert\">
               <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
               <strong>Gelukt!</strong>
               Medewerker bewerkt
               </div>");
                }
            }
            if ($_GET["mnr"] != "") {
                $stmt = $pdo->prepare("SELECT * FROM medewerker WHERE mnr=?");
                $stmt->execute(array($_GET["mnr"]));
                $medewerker = $stmt->fetch();

                $mnr = $medewerker["mnr"];
                $naam = $medewerker["naam"];
                $achternaam = $medewerker["achternaam"];
                $email = $medewerker["email"];
                $functie = $medewerker["functie"];


                print "  <form role=\"form\" class=\"form-horizontal\" method=\"post\" action=\"account_wijzig.php?mnr=$mnr\">";
                print "<fieldset>";
                print "<!-- Text input-->";
                print "<div class=\"form-group\">";
                print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Voornaam</label>";
                print "<div class=\"col-sm-4\">";
                print "<input type=\"text\" placeholder=\"Voornaam\" name=\"voornaam\" class=\"form-control\" value=\"$naam\">";
                print "</div>";
                print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Achternaam</label>";
                print "<div class=\"col-sm-4\">";
                print "<input type=\"text\" placeholder=\"Achternaam\" name=\"achternaam\" class=\"form-control\" value=\"$achternaam\">";
                print "</div>";
                print "</div>";
                print "<!-- Text input-->";
                print "<div class=\"form-group\">";
                print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Email</label>";
                print "<div class=\"col-sm-10\">";
                print "<input type=\"text\" placeholder=\"Email\" name=\"email\" class=\"form-control\" value=\"$email\">";
                print "</div>";
                print "</div>";
                print "<!-- Text input-->";
                print "<div class=\"form-group\">";
                print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Wachtwoord</label>";
                print "<div class=\"col-sm-10\">";
                print "<input type=\"text\" placeholder=\"Wachtwoord\" name=\"pass\" class=\"form-control\">";
                print "</div>";
                print "</div>";
                print "<!-- Text input-->";
                print "<div class=\"form-group\">";
                print "<label class=\"col-sm-2 control-label\" for=\"textinput\">Functie</label>";
                print "<div class=\"col-sm-10\">";
                print "<select class=\"form-control\" id=\"functie\" name=\"functie\">";
                print '<option value="Administrator" ' . (($functie == 'Administrator') ? 'selected="selected"' : "") . '>Administrator</option>';
                print '<option value="Web-administrator" ' . (($functie == 'Web-administrator') ? 'selected="selected"' : "") . '>Web-administrator</option>';
                print "</select>";
                print "</div>";
                print "</div>";

                print "<div class=\"form-group\">";
                print "<div class=\"col-sm-offset-2 col-sm-10\">";
                print "<div class=\"pull-right\">";
                print "<input type=\"submit\" class=\"btn btn-danger\" name=\"terug\" value=\"Ga Terug\">";
                print "<span> &nbsp&nbsp&nbsp </span>";
                print "<input type=\"submit\" class=\"btn btn-success\" name=\"opslaan\" value=\"Opslaan\">";
                print "</div>";

                print "</div>";
                print "</div>";
                print "</fieldset>";
                print "</form> ";
            } else {
                print "<div class=\"alert alert-danger\" role=\"alert\">Het medewerker nummer mist. <a href=\"javascript: window.history.go(-1)\">Ga terug</a> </div>";
            }
        } catch (PDOException $e) {
            print "<div class=\"alert alert-danger\" role=\"alert\">Het bewerken is mislukt, probeer het opnieuw. <a href=\"javascript: window.history.go(-1)\">Ga terug</a> </div>";
        }
        $pdo = NULL;
    }

    /* Account verwijderen op de website */

    function verwijderMedewerker() {
//Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
        global $pdo;

        if ($_GET['mnr'] != $_SESSION['mnr']) {

            if (isset($_GET['mnr'])) {
                try {
                    $stmt = $pdo->prepare("DELETE FROM medewerker WHERE mnr=?");
                    $stmt->execute(array($_GET['mnr']));
                    if ($stmt->rowCount() == 1) {
                        $_SESSION['AccountStatus'] = TRUE;
                        $_SESSION['AccountMessage'] = "<div class=\"alert alert-success\" id=\"success-alert\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                <strong>Gelukt!</strong>
                                Medewerker verwijderd.
                                </div>";
                    } else {
                        $_SESSION['AccountStatus'] = TRUE;
                        $_SESSION['AccountMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                <strong>Mislukt!</strong>
                                Het verwijderen van de mederwerker is mislukt. Probeer het later opnieuw.
                                </div>";
                    }
                } catch (PDOException $e) {
                    $_SESSION['AccountStatus'] = TRUE;
                    $_SESSION['AccountMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                <strong>Mislukt!</strong>
                                Er ging iets mis met de prepare statement. Neem contact met een IT boy.
                                </div>";
                }
                $pdo = NULL;
            }
        } else {
            $_SESSION['AccountStatus'] = TRUE;
            $_SESSION['AccountMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                <strong>Mislukt!</strong>
                                U kunt uw eigen account niet verwijderen. Duh!
                                </div>";
        }
    }


/* Login systeem voor het CMS */

function login_form() {
        ?>
        <div class="col-md-6 col-md-offset-5"><h2><b>Admin Paneel</b></h2> </div>
        <div class="col-md-5 col-md-offset-3"
             <div class="panel panel-default">
                <div class="panel-body">

                    <form action="index.php" class="form-horizontal" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">Email</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="textinput">Wachtwoord</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Wachtwoord" name="wachtwoord" type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <a href="wachtwoord_vergeten.php">Wachtwoord vergeten?</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="submit" value="Inloggen">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
    <?php
}

function login_check() {

    if (isset($_POST['submit'])) {

        global $pdo;

        $email = $_POST['email'];
        $pass = $_POST['wachtwoord'];
        $sha256 = hash('sha256', $pass);



        if (isset($_POST) && $email != '' && $pass != '') {
            $stmt = $pdo->prepare("SELECT mnr, naam, email, wachtwoord,functie FROM medewerker WHERE email =?");
            $stmt->execute(array($email));
            while ($result = $stmt->fetch()) {
                $p = $result['wachtwoord'];
                $naam = $result['naam'];
                $rechten = $result['functie'];
                $mnr = $result['mnr'];
            }

            if ($p == $sha256) {
                $_SESSION['naam'] = $naam;
                $_SESSION['mnr'] = $mnr;
                $_SESSION['login'] = TRUE;
                $_SESSION['functie'] = $rechten;
                print '<script>window.location.assign("index.php")</script>';
            } else {
                print "<br><div class=\"alert alert-danger\" role=\"alert\">De combinatie van e-mail en wachtwoord is onjuist. </div>";
            }
        } else {
            print "<br><div class=\"alert alert-danger\" role=\"alert\">Vul een e-mail en wachtwoord in. </div>";
        }
    }
}

function adminDashboard() {

    if ($_SESSION['functie'] == "Administrator") {
        ?>
                <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-0 col-sm-offset-0">
                    <h2>Admin Dashboard</h2>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="<?php
        if (is_dir('admin')) {
            print 'admin/';
        }
        ?>overzicht_reserveringen.php"><span class="glyphicon glyphicon-tasks"></span>Reserveringen</a></li>
                        <li class="list-group-item"><a href="<?php
                            if (is_dir('admin')) {
                                print 'admin/';
                            }
                            ?>overzicht_medewerkers.php"><span class="glyphicon glyphicon-user"></span>Accounts</a></li>
                        <li class="list-group-item"><a href="<?php
                            if (is_dir('admin')) {
                                print 'admin/';
                            }
                            ?>overzicht_paginas.php"><span class="glyphicon glyphicon-book"></span>Pages</a></li>
                        <li></li>
                        <li class="list-group-item"><a href="<?php
                                                       if (is_dir('admin')) {
                                                           print 'admin/';
                                                       }
                                                       ?>account.php"><span class="glyphicon glyphicon-user"></span>Mijn Account</a></li>
                        <li class="list-group-item"><a href="instellingen.php"><span class="glyphicon glyphicon-cog"></span>Instellingen</a></li>
                        <li class="list-group-item"><a href="<?php
                                                       if (is_dir('admin')) {
                                                           print 'admin/';
                                                       }
                                                       ?>logout.php"><span class="glyphicon glyphicon-off"></span>Uitloggen</a></li>
                    </ul>

                </div> <?php
                } else {
                    ?>
                <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-0 col-sm-offset-0">
                    <h2>ADMIN DASHBOARD</h2>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="<?php
                    if (is_dir('admin')) {
                        print 'admin/';
                    }
                                                       ?>overzicht_paginas.php"><span class="glyphicon glyphicon-book"></span>Pages</a></li>
                        <li class="divider"></li>
                        <li class="list-group-item"><a href="<?php
                                                       if (is_dir('admin')) {
                                                           print 'admin/';
                                                       }
                                                       ?>account.php"><span class="glyphicon glyphicon-user"></span>Mijn Account</a></li>
                        <li class="list-group-item"><a href="<?php
                            if (is_dir('admin')) {
                                print 'admin/';
                            }
                            ?>instellingen.php"><span class="glyphicon glyphicon-cog"></span>Instellingen</a></li>
                        <li class="list-group-item"><a href="<?php
                            if (is_dir('admin')) {
                                print 'admin/';
                            }
                            ?>logout.php"><span class="glyphicon glyphicon-off"></span>Uitloggen</a></li>
                    </ul>

                </div>
        <?php
    }
}

/* functie voor de error pagina (de pagina waarop iemand beland als ze geen rechten hebben voor de pagina) */

function error_pagina() {
    ?>

            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Oeps</h1>
                    <h2>
                        Pagina niet gevonden</h2>
                    <div class="error-details">
                        Sorry, er is een fout opgetreden, de opgevraagde pagina kan niet worden gevonden!
                    </div>
                    <div class="error-actions">
                        <a href="../index.php" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                            Terug naar het begin </a><a href="../contact.php" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact opnemen </a>
                    </div>
                </div>
            </div>
    <?php
}

/* Class systeem om rechten te regelen */

class toegang {

    public function admin() {

        if ($_SESSION['functie'] == "Administrator") {
            //de juiste rechten
            return true;
        } else {
            //niet de juiste rechten
            print head();
            print error_pagina();
            die;
        }
    }

    public function editor() {

        if ($_SESSION['functie'] == "Administrator" || $_SESSION['functie'] == "Web-administrator") {
            //de juiste rechten
            return true;
        } else {
            //niet de juiste rechten
            print head();
            print error_pagina();
            die;
        }
    }

}

/* Alle functies die te maken hebben met de pagina overzicht */

function pagina_overzicht() {
    //Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
    global $pdo;

    $stmt = $pdo->prepare("SELECT id, titel, content, gewijzigd, bewerkt, naam FROM pagina JOIN medewerker WHERE pagina.bewerkt=medewerker.mnr;");
    $stmt->execute();
    $paginas = $stmt->fetchAll();

    foreach ($paginas as $pagina) {

        $datum = date("d-m-Y", strtotime($pagina["gewijzigd"]));

        print("<tr class=\"active\">");
        print("<td>" . $pagina["titel"] . "</td>");
        print("<td>" . mb_strimwidth($pagina["content"], 0, 20, '...') . "</td>");
        print("<td>" . $datum . "</td>");
        print("<td>" . $pagina["naam"] . "</td>");
        print("<td>
                    <div class=\"btn-group\">
                        <a class=\"btn btn-default\" href=\"wijzig_pagina.php?id=" . $pagina["id"] . "\">
                            <i class=\"fa fa-pencil-square-o\"></i>
                        </a>
                    </div>
                </td>");
        print("</tr>");
    }
}

function pagina_wijzig() {
    //Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
    global $pdo;



    try {
        if (isset($_POST["opslaan"])) {
            $date =date('Y-m-d');
            $stmt = $pdo->prepare("UPDATE pagina SET titel=?,content=?,bewerkt=?, gewijzigd=? WHERE id=?");
            $stmt->execute(array($_POST["titel"], $_POST["content"], $_SESSION["mnr"], $date, $_GET["id"]));
            if ($stmt) {
                print("<div class=\"alert alert-success\" id=\"success-alert\">
                   <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                   <strong>Gelukt!</strong>
                   De pagina is bewerkt.
                   </div>");
            } else {
                print("<div class=\"alert alert-danger\" id=\"success-alert\">
                   <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                   <strong>Mislukt!</strong>
                   Het is niet gelukt om de pagina te bewerken. Probeer het later opnieuw.
                   </div>");
            }
        }
        if ($_GET["id"] != "") {
            $stmt = $pdo->prepare("SELECT * FROM pagina WHERE id=?");
            $stmt->execute(array($_GET["id"]));
            $pagina = $stmt->fetch();

            $id = $pagina["id"];
            $titel = $pagina["titel"];
            $content = $pagina["content"];
            ?>
                    <form role="form" class="form-horizontal" method="post" action="wijzig_pagina.php?id=<?php print $id; ?>"/>
                    <fieldset>


                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Titel</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="Titel" name="titel" value="<?php print $titel; ?>" class="form-control">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Content</label>
                            <div class="col-sm-10">
                                <textarea id="editor" class="form-control" rows="20" name="content"><?php print $content; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="pull-right">
                                    <input type="button" class="btn btn-danger" onclick="location.href = 'overzicht_paginas.php';" value="Ga terug">
                                    <input type="submit" class="btn btn-success" name="opslaan" value="Opslaan">
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    </form>
                ☺</div>
            </div>
            <?php
        } else {
            print "<div class=\"alert alert-danger\" role=\"alert\">Er is geen pagina nummer opgegeven.<a href=\"javascript: window.history.go(-1)\">Ga terug</a> </div>";
        }
    } catch (PDOException $e) {
        print "<div class=\"alert alert-danger\" role=\"alert\"> Het bewerken is mislukt, probeer het opnieuw.<a href=\"javascript: window.history.go(-1)\">Ga terug</a> </div>";
    }
    $pdo = NULL;
}

//BBCode Parser function

function showBBcodes($text) {
// BBcode array

    $find = array(
        '~\[b\](.*?)\[/b\]~s',
        '~\[i\](.*?)\[/i\]~s',
        '~\[u\](.*?)\[/u\]~s',
        '~\[quote\](.*?)\[/quote\]~s',
        '~\[size=(.*?)\](.*?)\[/size\]~s',
        '~\[color=(.*?)\](.*?)\[/color\]~s',
        '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
        '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
        '~\[list\](.*?)\[/list\]~s',
        '~\[\*\](.*?)\[/\*\]~s',
        '~\[list=1\](.*?)\[/list\]~s',
    );



// HTML tags to replace BBcode

    $replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
        '<span style="text-decoration:underline;">$1</span>',
        '<pre>$1</' . 'pre>',
        '<span style="font-size:$1px;">$2</span>',
        '<span style="color:$1;">$2</span>',
        '<a href="$1">$1</a>',
        '<img src="$1" alt="" />',
        '<ul>$1</ul>',
        '<li>$1</li>',
        '<ol>$1</ol>',
    );


// Replacing the BBcodes with corresponding HTML tags
    return preg_replace($find, $replace, $text);
}

/* Class systeem voor het CMS. Hierin een public functie voor elke pagina; elke pagina kan opgeroepen worden */

class cms {

    public function home() {

        global $pdo;
        //statement maken voor index - Index is ID 1
        $stmt = $pdo->prepare("SELECT titel,content FROM pagina WHERE id=1");
        $stmt->execute();
        $row = $stmt->fetch();

        $titel = $row["titel"];
        $content = $row["content"];

        print "<h2>" . $titel . "</h2>";
        print "<p class=\"bodyTekst\">" . nl2br(showBBcodes($content)) . "</p>";
    }

    public function overons() {

        global $pdo;
        //statement maken voor over ons - Over ons is ID 2
        $stmt = $pdo->prepare("SELECT titel,content FROM pagina WHERE id=2");
        $stmt->execute();
        $row = $stmt->fetch();

        $titel = $row["titel"];
        $content = $row["content"];

        print "<h2>" . $titel . "</h2>";
        print "<p class=\"bodyTekst\">" . nl2br(showBBcodes($content)) . "</p>";
    }

    public function pakketten() {

        global $pdo;
        //statement maken voor pakketten - Pakketten is ID 3
        $stmt = $pdo->prepare("SELECT titel,content FROM pagina WHERE id=3");
        $stmt->execute();
        $row = $stmt->fetch();

        $titel = $row["titel"];
        $content = $row["content"];

        print "<h2>" . $titel . "</h2>";
        print "<p class=\"bodyTekst\">" . nl2br(showBBcodes($content)) . "</p>";
    }

    public function contact() {

        global $pdo;
        //statement maken voor contact - Contact is ID 4
        $stmt = $pdo->prepare("SELECT titel,content FROM pagina WHERE id=4");
        $stmt->execute();
        $row = $stmt->fetch();

        $titel = $row["titel"];
        $content = $row["content"];

        print "<h2>" . $titel . "</h2>";
        print "<p class=\"bodyTekst\">" . nl2br(showBBcodes($content)) . "</p>";
    }

}

/* Alle functies te maken hebben met de reserveringen */

function reserveringen() {
    global $pdo;
    ?> <table class = "table table-hover"><thead>
            <tr>
                <th>Reservering</th>
                <th>Naam</th>
                <th>Achternaam</th>
                <th>Datum Van</th>
                <th>Datum Tot</th>
                <th>Aantal Pistolen</th>
                <th>Status</th>
                <th> </th>
            </tr>
        </thead> <?php
    $stmt = $pdo->prepare("SELECT R.reserveringnr, naam, achternaam, aantal_pistolen, van, tot, status FROM reservering R JOIN klant K WHERE R.klantnr = K.klantnr;");
    $stmt->execute();
    $reserveringen = $stmt->fetchAll();

    foreach ($reserveringen as $reservering) {
        print("<tr class=\"active\">");
        print("<td>" . $reservering["reserveringnr"] . "</td>");
        print("<td>" . $reservering["naam"] . "</td>");
        print("<td>" . $reservering["achternaam"] . "</td>");

        // WISSEL DATUM OM VAN YYYY-MM-DD NAAR DD-MM-YYYY
        $datumvan = $reservering["van"];
        $vandatum = date("d-m-Y", strtotime($datumvan));

        $datumtot = $reservering["tot"];
        $totdatum = date("d-m-Y", strtotime($datumtot));

        print("<td>" . $vandatum . "</td>");
        print("<td>" . $totdatum . "</td>");
        print("<td>" . $reservering["aantal_pistolen"] . "</td>");
        print("<td>" . $reservering["status"] . "</td>");
        print("<td>
                    <div class=\"btn-group\">
                        <a class=\"btn btn-default\" target=\"_blank\" href=\"download_reservering.php?reserveringnr=" . $reservering["reserveringnr"] . "\">
                            <i class=\"fa fa-file-pdf-o\"></i>
                        </a>
                        <a class=\"btn btn-default\" href=\"wijzig_reservering.php?reserveringnr=" . $reservering["reserveringnr"] . "\">
                            <i class=\"fa fa-pencil-square-o\"></i>
                        </a>
                        <a class=\"btn btn-default\" onclick=\"return confirm('Weet u zeker dat u deze reservering wilt verwijderen?')\" name=\"delete\" href=\"verwijder_reservering.php?reserveringnr=" . $reservering["reserveringnr"] . "\">
                            <i class=\"fa fa-times\"></i>
                        </a>
                    </div>
                </td>");

        print("</tr>");
    }
    print("</table>");
    $pdo = NULL;
}

function verwijderReservering() {
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM reservering WHERE reserveringnr=?");
    $stmt->execute(array($_GET['reserveringnr']));

    if ($stmt) {
        $_SESSION['verwijder'] = TRUE;
    } else {
        die();
    }
    $pdo = NULL;
    header("location: overzicht_reserveringen.php");
    die();
}

function delResMelding() {
    if ($_SESSION['verwijder'] == TRUE) {
        print("<div class=\"alert alert-success\" id=\"success-alert\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                            <strong>Gelukt!</strong>
                            Reservering verwijderd.
                            </div>");
        $_SESSION['verwijder'] = FALSE;
    } else {
        print("<div class=\"alert alert-danger\" id=\"danger-alert\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                            <strong>Mislukt!</strong>
                            Er is iets misgegaan bij het verwijderen. Probeer het later opnieuw.</div>");
    }
}

/* EXPERIMENTELE CODE VOOR INSTELLINGEN PAGINA, STAAT VOORLOPIG NOG UIT IVM PRESENTATIE

function instellingen() {
    algemeneInstellingen();
    voorraadBeheer();
    prijsBeheer();
    googleBeheer();
    saveDeleteKnop();
}

function algemeneInstellingen() {
    ?>
        <div class="balk"><b>Algemene instellingen</b></div>

        <form role="form" class="form-horizontal" method="post" action="instellingen.php">
            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Website titel</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php websiteTitel(); ?>" name="titel" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>

                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Email adres</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php websiteEmail(); ?>" name="email" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>
            </fieldset>
    <?php
}

function websiteTitel() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM SiteGegevens;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $websiteTitle = $row['sitenaam'];
        print($websiteTitle);
    }
}

function websiteEmail() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM SiteGegevens;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $email = $row['email'];
        print($email);
    }
}

function voorraadBeheer() {
    ?>
            <div class="balk"><b>Voorraad Beheer</b></div>

            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Default</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php defaultVoorraad(); ?>" name="default" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="tooltip title"></span>
                    </div>

                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">On Hold</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php onHold(); ?>" name="onHold" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="tooltip title"></span>
                    </div>
                </div>
            </fieldset>
    <?php
}

function defaultVoorraad() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $voorraad = $row['voorraad'];
        print($voorraad);
    }
}

function defaultVoorraadReturn() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $voorraad = $row['voorraad'];
        return $voorraad;
    }
}

function onHold() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $onhold = $row['onHold'];
        print ($onhold);
    }
}

function onHoldReturn() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $onhold = $row['onHold'];
        return $onhold;
    }
}

function onzichtbareVoorraad() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $voorraad = $row['voorraad'];
        $onhold = $row['onHold'];

        $onzichtbareVoorraad = $voorraad - $onhold;
        print($onzichtbareVoorraad);
    }
}

function prijsBeheer() {
    ?>
            <div class="balk"><b>Prijs instellingen</b></div>
            <p class="instellingenUitleg"> De prijs van een bestelling wordt aan de hand van de volgende formule berekend: dagprijs = aantal pistolen x prijs per pistool + startprijs.
                <br>Indien er sprake is van een weekend/week tarief, wordt daar nog een factor overheen berekend: weekendprijs = dagprijs x weekend factor OF weekprijs = dagprijs x week factor.</p>

            <fieldset>
                <!--
               <div class="form-group">
                   <label class="col-sm-2 control-label" for="textinput">Borg tot 10 pistolen</label>
                   <div class="col-sm-8">
                       <input type="text" placeholder="<?php // borgTotTien();  ?>" name="borgtottien" class="form-control">

                   </div>
                   <div class="col-sm-1">
                       <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                   </div>
               </div>


               <div class="form-group">
                   <label class="col-sm-2 control-label" for="textinput"> Borg vanaf 11 pistolen</label>
                   <div class="col-sm-8">
                       <input type="text" placeholder="<?php //borgVanTien();  ?>" name="borgvantien" class="form-control">

                   </div>
                   <div class="col-sm-1">
                       <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                   </div>

               </div> -->


                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Prijs per pistool</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php pistoolPrijs(); ?>" name="pistoolprijs" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>

                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Weekend Factor</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php weekendFactor(); ?>" name="weekendfactor" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Week Factor</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php weekFactor(); ?>" name="weekfactor" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>
            </fieldset> <?php
    }

//        function borgTotTien() {
//            global $pdo;
//
//            $stmt = $pdo->prepare("SELECT * FROM pistool;");
//            $stmt->execute();
//            while ($row = $stmt->fetch()) {
//                $totborg = $row['borgTotTien'];
//                print($totborg);
//            }
//        }
//
//        function borgVanTien() {
//            global $pdo;
//
//            $stmt = $pdo->prepare("SELECT * FROM pistool;");
//            $stmt->execute();
//            while ($row = $stmt->fetch()) {
//                $vanborg = $row['borgVanTien'];
//                print($vanborg);
//            }
//        }

    function startPrijs() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $startPrijs = $row['startPrijs'];
            print($startPrijs);
        }
    }

    function pistoolPrijs() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $weekendFactor = $row['prijs'];
            print($weekendFactor);
        }
    }

    function weekendFactor() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $prijs = $row['weekendFactor'];
            print($prijs);
        }
    }

    function weekendFactorReturn() {
            global $pdo;

            $stmt = $pdo->prepare("SELECT * FROM pistool;");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $prijs = $row['weekendFactor'];
                print($prijs);
            }
        }

    function weekFactor() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $weekFactor = $row['weekFactor'];
            print($weekFactor);
        }
    }

    function weekFactorReturn() {
            global $pdo;

            $stmt = $pdo->prepare("SELECT * FROM pistool;");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $prijs = $row['weekFactor'];
                print($prijs);
            }
        }

    function Factoren() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $weekendFactor = $row['weekendFactor'];
            $weekFactor = $row['weekFactor'];
            $pistoolPrijs = $row['prijs'];
        }
        return array('weekend' => $weekendFactor, 'week' => $weekFactor, 'pistoolPrijs' => $pistoolPrijs);
    }

    function googleBeheer() {
    ?>
            <div class="balk"><b>Beheer Google</b></div>

            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Tracking code</label>
                    <div class="col-sm-8">
                        <textarea name="trackingcode" placeholder="<?php trackingCode(); ?>" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>
            </fieldset>

    <?php
}

function trackingCode() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM SiteGegevens;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $trackingcode = $row['trackingcode'];
        print($trackingcode);
    } $pdo = NULL;
}

function saveDeleteKnop() {
    ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="pull-right">
                        <input type="submit" class="btn btn-success" name="opslaan" value="Opslaan">
                    </div>
                </div>
            </div>
        </form> <?php
    }

    function checkAllFields() {
        if ($_POST['titel'] == "" AND
                $_POST['email'] == "" AND
                $_POST['default'] == "" AND
                $_POST['onHold'] == "" AND
                $_POST['trackingcode'] == "" AND
                $_POST['borgtottien'] == "" AND
                $_POST['borgvantien'] == "" AND
                $_POST['startprijs'] == "" AND
                $_POST['pistoolprijs'] == "" AND
                $_POST['weekendfactor'] == "" AND
                $_POST['weekfactor'] == "") {

        $_SESSION['insOpslaan'] = TRUE;
        $_SESSION['insMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                        <strong>Mislukt!</strong> Vul minimaal één van de gegevens in.
                        </div>";
            return FALSE;
        } elseif (!empty($_POST['onHold']) AND !empty($_POST['default']) AND ($_POST['onHold'] < 0 OR $_POST['default'] < 0 OR $_POST['default'] <= onHoldReturn() OR $_POST['onHold'] >= defaultVoorraadReturn())) {
                $_SESSION['insOpslaan'] = TRUE;
                $_SESSION['insMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                            <strong>Mislukt!</strong> De voorraden kunnen niet negatief zijn en de default voorraad moet groter zijn dan de on hold voorraad.
                            </div>";
                } elseif (!empty($_POST['pistoolPrijs']) AND !empty($_POST['weekFactor']) AND !empty($_POST['weekendFactor']) AND ($_POST['pistoolprijs'] <= 0 OR $_POST['weekendfactor'] <= 0 OR $_POST['weekfactor'] <= 0 )) {
                    $_SESSION['insOpslaan'] = TRUE;
                    $_SESSION['insMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                <strong>Mislukt!</strong> Alle prijzen en factoren moeten groter zijn dan 0.
                                </div>";
                    } elseif ($_POST['weekendfactor'] > weekFactorReturn() OR $_POST['weekfactor'] < weekendFactorReturn()) {
                        $_SESSION['insOpslaan'] = TRUE;
                        $_SESSION['insMessage'] = "<div class=\"alert alert-danger\" id=\"success-alert\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                    <strong>Mislukt!</strong> De weekend factor kan niet kleiner zijn dan de weekfactor.
                                    </div>";
                } else {
            return TRUE;
        }
    }

    function insOpslaan() {
        if (
                insTitel() AND

                insEmail() AND

                insDefault() AND

                insOnHold() AND

                insBorgTTien() AND

                insBorgVTien() AND

                insStartPrijs() AND

                insPistoolPrijs() AND

                insWeekendFactor() AND

                insWeekFactor() AND

                insGoogle()) {
            $_SESSION['insOpslaan'] = TRUE;
            $_SESSION['insMessage'] = "<div class=\"alert alert-success\" id=\"success-alert\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                        <strong>Gelukt!</strong> De gegevens zijn succesvol opgeslagen!
                        </div>";
        }
    }

    function insTitel() {
        global $pdo;
        if (!empty($_POST["titel"])) {
            $stmt = $pdo->prepare("UPDATE SiteGegevens SET sitenaam =?;");
            $stmt->execute(array($_POST["titel"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insEmail() {
        global $pdo;
        if (!empty($_POST['email'])) {
            $stmt = $pdo->prepare("UPDATE SiteGegevens SET email =?;");
            $stmt->execute(array($_POST["email"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insDefault() {
        global $pdo;

        if (!empty($_POST['default'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET voorraad =?;");
            $stmt->execute(array($_POST["default"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insOnHold() {
        global $pdo;
        if (!empty($_POST['onHold'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET onHold =?;");
            $stmt->execute(array($_POST["onHold"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insBorgTTien() {
        global $pdo;
        if (!empty($_POST['borgtottien'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET borgTotTien =?;");
            $stmt->execute(array($_POST["borgtottien"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insBorgVTien() {
        global $pdo;
        if (!empty($_POST['borgvantien'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET borgVanTien =?;");
            $stmt->execute(array($_POST["borgvantien"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insStartPrijs() {
        if (!empty($_POST['startprijs'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET startPrijs =?;");
            $stmt->execute(array($_POST["startprijs"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insPistoolPrijs() {
        if (!empty($_POST['pistoolprijs'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET prijs =?;");
            $stmt->execute(array($_POST["pistoolprijs"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insWeekendFactor() {
        if (!empty($_POST['weekendfactor'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET weekendFactor =?;");
            $stmt->execute(array($_POST["weekendfactor"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insWeekFactor() {
        if (!empty($_POST['weekfactor'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET weekFactor =?;");
            $stmt->execute(array($_POST["weekfactor"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insGoogle() {
        if (!empty($_POST['trackingcode'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE SiteGegevens SET trackingcode =?;");
            $stmt->execute(array($_POST["trackingcode"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    } */


/* FUNCTIES INSTELLINGEN PAGINA: Alle functies die te maken hebben met de instellingen pagina als onderdeel van het CMS st=ysteem */

function instellingen() {
    algemeneInstellingen();
    voorraadBeheer();
    prijsBeheer();
    googleBeheer();
    saveDeleteKnop();
}

function algemeneInstellingen() {
    ?>
        <div class="balk"><b>Algemene instellingen</b></div>

        <form role="form" class="form-horizontal" method="post" action="instellingen.php">
            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Website titel</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php websiteTitel(); ?>" name="titel" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>

                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Email adres</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php websiteEmail(); ?>" name="email" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>
            </fieldset>
    <?php
}

function websiteTitel() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM SiteGegevens;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $websiteTitle = $row['sitenaam'];
        print($websiteTitle);
    }
}

function websiteEmail() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM SiteGegevens;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $email = $row['email'];
        print($email);
    }
}

function voorraadBeheer() {
    ?>
            <div class="balk"><b>Voorraad Beheer</b></div>

            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Default</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php defaultVoorraad(); ?>" name="default" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="tooltip title"></span>
                    </div>

                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">On Hold</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php onHold(); ?>" name="onHold" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="tooltip title"></span>
                    </div>
                </div>
            </fieldset>
    <?php
}

function defaultVoorraad() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $voorraad = $row['voorraad'];
        print($voorraad);
    }
}

function onHold() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $onhold = $row['onHold'];
        print ($onhold);
    }
}

function onzichtbareVoorraad() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM pistool;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $voorraad = $row['voorraad'];
        $onhold = $row['onHold'];

        $onzichtbareVoorraad = $voorraad - $onhold;
        print($onzichtbareVoorraad);
    }
}

function prijsBeheer() {
    ?>
            <div class="balk"><b>Prijs instellingen</b></div>
            <p class="instellingenUitleg"> De prijs van een bestelling wordt aan de hand van de volgende formule berekend: dagprijs = aantal pistolen x prijs per pistool + startprijs.
                <br>Indien er sprake is van een weekend/week tarief, wordt daar nog een factor overheen berekend: weekendprijs = dagprijs x weekend factor OF weekprijs = dagprijs x week factor.</p>

            <fieldset>
                <!--
               <div class="form-group">
                   <label class="col-sm-2 control-label" for="textinput">Borg tot 10 pistolen</label>
                   <div class="col-sm-8">
                       <input type="text" placeholder="<?php // borgTotTien();  ?>" name="borgtottien" class="form-control">

                   </div>
                   <div class="col-sm-1">
                       <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                   </div>
               </div>


               <div class="form-group">
                   <label class="col-sm-2 control-label" for="textinput"> Borg vanaf 11 pistolen</label>
                   <div class="col-sm-8">
                       <input type="text" placeholder="<?php //borgVanTien();  ?>" name="borgvantien" class="form-control">

                   </div>
                   <div class="col-sm-1">
                       <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                   </div>

               </div> -->


                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Prijs per pistool</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php pistoolPrijs(); ?>" name="pistoolprijs" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>

                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Weekend Factor</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php weekendFactor(); ?>" name="weekendfactor" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Week Factor</label>
                    <div class="col-sm-8">
                        <input type="text" placeholder="<?php weekFactor(); ?>" name="weekfactor" class="form-control">

                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>
            </fieldset> <?php
    }

//        function borgTotTien() {
//            global $pdo;
//
//            $stmt = $pdo->prepare("SELECT * FROM pistool;");
//            $stmt->execute();
//            while ($row = $stmt->fetch()) {
//                $totborg = $row['borgTotTien'];
//                print($totborg);
//            }
//        }
//
//        function borgVanTien() {
//            global $pdo;
//
//            $stmt = $pdo->prepare("SELECT * FROM pistool;");
//            $stmt->execute();
//            while ($row = $stmt->fetch()) {
//                $vanborg = $row['borgVanTien'];
//                print($vanborg);
//            }
//        }

    function startPrijs() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $startPrijs = $row['startPrijs'];
            print($startPrijs);
        }
    }

    function pistoolPrijs() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $weekendFactor = $row['prijs'];
            print($weekendFactor);
        }
    }

    function weekendFactor() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $prijs = $row['weekendFactor'];
            print($prijs);
        }
    }

    function weekFactor() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $weekFactor = $row['weekFactor'];
            print($weekFactor);
        }
    }

    function Factoren() {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM pistool;");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $weekendFactor = $row['weekendFactor'];
            $weekFactor = $row['weekFactor'];
            $pistoolPrijs = $row['prijs'];
        }
        return array('weekend' => $weekendFactor, 'week' => $weekFactor, 'pistoolPrijs' => $pistoolPrijs);
    }

    function googleBeheer() {
    ?>
            <div class="balk"><b>Beheer Google</b></div>

            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Tracking code</label>
                    <div class="col-sm-8">
                        <textarea name="trackingcode" placeholder="<?php trackingCode(); ?>" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-question-sign" id="tooltip" title="Tooltip here"></span>
                    </div>
                </div>
            </fieldset>

    <?php
}

function trackingCode() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM SiteGegevens;");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $trackingcode = $row['trackingcode'];
        print($trackingcode);
    } $pdo = NULL;
}

function saveDeleteKnop() {
    ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="pull-right">
                        <input type="submit" class="btn btn-success" name="opslaan" value="Opslaan">
                    </div>
                </div>
            </div>
        </form> <?php
    }

    function checkAllFields() {
        if ($_POST['titel'] == "" AND
                $_POST['email'] == "" AND
                $_POST['default'] == "" AND
                $_POST['onHold'] == "" AND
                $_POST['trackingcode'] == "" AND
                $_POST['borgtottien'] == "" AND
                $_POST['borgvantien'] == "" AND
                $_POST['startprijs'] == "" AND
                $_POST['pistoolprijs'] == "" AND
                $_POST['weekendfactor'] == "" AND
                $_POST['weekfactor'] == "") {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function insOpslaan() {
        if (
                insTitel() AND

                insEmail() AND

                insDefault() AND

                insOnHold() AND

                insBorgTTien() AND

                insBorgVTien() AND

                insStartPrijs() AND

                insPistoolPrijs() AND

                insWeekendFactor() AND

                insWeekFactor() AND

                insGoogle()) {
            return TRUE;
        }
    }

    function insTitel() {
        global $pdo;
        if (!empty($_POST["titel"])) {
            $stmt = $pdo->prepare("UPDATE SiteGegevens SET sitenaam =?;");
            $stmt->execute(array($_POST["titel"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insEmail() {
        global $pdo;
        if (!empty($_POST['email'])) {
            $stmt = $pdo->prepare("UPDATE SiteGegevens SET email =?;");
            $stmt->execute(array($_POST["email"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insDefault() {
        global $pdo;

        if (!empty($_POST['default'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET voorraad =?;");
            $stmt->execute(array($_POST["default"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insOnHold() {
        global $pdo;
        if (!empty($_POST['onHold'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET onHold =?;");
            $stmt->execute(array($_POST["onHold"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insBorgTTien() {
        global $pdo;
        if (!empty($_POST['borgtottien'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET borgTotTien =?;");
            $stmt->execute(array($_POST["borgtottien"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insBorgVTien() {
        global $pdo;
        if (!empty($_POST['borgvantien'])) {
            $stmt = $pdo->prepare("UPDATE pistool SET borgVanTien =?;");
            $stmt->execute(array($_POST["borgvantien"]));
            return TRUE;
            //$pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insStartPrijs() {
        if (!empty($_POST['startprijs'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET startPrijs =?;");
            $stmt->execute(array($_POST["startprijs"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insPistoolPrijs() {
        if (!empty($_POST['pistoolprijs'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET prijs =?;");
            $stmt->execute(array($_POST["pistoolprijs"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insWeekendFactor() {
        if (!empty($_POST['weekendfactor'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET weekendFactor =?;");
            $stmt->execute(array($_POST["weekendfactor"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insWeekFactor() {
        if (!empty($_POST['weekfactor'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE pistool SET weekFactor =?;");
            $stmt->execute(array($_POST["weekfactor"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    function insGoogle() {
        if (!empty($_POST['trackingcode'])) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE SiteGegevens SET trackingcode =?;");
            $stmt->execute(array($_POST["trackingcode"]));
            return TRUE;
            $pdo = NULL;
        } else {
            return TRUE;
        }
    }

    /* zelf account wijzigen functies */

    function viewAccount() {
    ?>
        <form role="form" class="form-horizontal" method="post" action="wijzig_account.php">
            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Voornaam</label>
                    <div class="col-sm-4">
                        <input readonly type="text" placeholder="<?php retrieveName(); ?>" name="voornaam" class="form-control">
                    </div>

                    <label class="col-sm-2 control-label" for="textinput">Achternaam</label>
                    <div class="col-sm-4">
                        <input readonly type="text" placeholder="<?php retrieveSurname(); ?>" name="achternaam" class="form-control">
                    </div>
                </div>


                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Email</label>
                    <div class="col-sm-10">
                        <input readonly type="text" placeholder="<?php retrieveEmail(); ?>" name="email" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <p>Om uw wachtwoord of andere gegevens te wijzigen klikt u op gegevens wijzigen.</p>
                    </div>
                </div>

                <!-- Wijzig knop -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="pull-right">
                            <input type="submit" class="btn btn-primary" name="gegevenswijzigen" value="Gegevens Wijzigen">
                        </div>
                    </div>
                </div>
        </form>
    <?php
}

function retrieveName() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT naam FROM medewerker WHERE mnr=?");
    $stmt->execute(array($_SESSION['mnr']));

    while ($row = $stmt->fetch()) {
        $data = $row['naam'];
    }
    print($data);
}

function retrieveSurname() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT achternaam FROM medewerker WHERE mnr=?");
    $stmt->execute(array($_SESSION['mnr']));

    while ($row = $stmt->fetch()) {
        $data = $row['achternaam'];
    }
    print($data);
}

function retrieveEmail() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT email FROM medewerker WHERE mnr=?");
    $stmt->execute(array($_SESSION['mnr']));

    while ($row = $stmt->fetch()) {
        $data = $row['email'];
    }
    print($data);
}

function returnEmail() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT email FROM medewerker WHERE mnr=?");
    $stmt->execute(array($_SESSION['mnr']));

    while ($row = $stmt->fetch()) {
        $data = $row['email'];
    }
    return $data;
}

function retrievePass() {
    global $pdo;

    $stmt = $pdo->prepare("SELECT wachtwoord FROM medewerker WHERE mnr=?");
    $stmt->execute(array($_SESSION['mnr']));

    while ($row = $stmt->fetch()) {
        $data = $row['wachtwoord'];
    }
    return $data;
}

function wijzig_account() {
    ?>
        <br><br><br><br>
        <form role="form" class="form-horizontal" method="post" action="wijzig_account.php">
            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Voornaam</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="<?php retrieveName(); ?>" name="voornaam" class="form-control">
                    </div>

                    <label class="col-sm-2 control-label" for="textinput">Achternaam</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="<?php retrieveSurname(); ?>" name="achternaam" class="form-control">
                    </div>
                </div>


                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Email</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="<?php retrieveEmail(); ?>" name="email" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Nieuw Wachtwoord</label>
                    <div class="col-sm-10">
                        <input type="password" placeholder="Nieuw Wachtwoord" name="ww_nieuw1" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Herhaal Nieuw Wachtwoord</label>
                    <div class="col-sm-10">
                        <input type="password" placeholder="Nieuw Wachtwoord" name="ww_nieuw2" class="form-control">
                    </div>
                </div>

                <br><br>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Huidig Wachtwoord*</label>
                    <div class="col-sm-10">
                        <input type="password" placeholder="Oud Wachtwoord" name="ww_oud" class="form-control">
                    </div>
                </div>

                <!-- Opslaan knop -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="pull-right">
                            <input type="submit" class="btn btn-primary" name="wijzigen" value="Wijzigen">
                        </div>
                    </div>
                </div>


        </form>
    <?php
}

function updateAccountData() {
    if (checkEmpty()) {
        checkPassword();
        }
    }

function checkEmpty() {
    if (empty($_POST['voornaam']) AND empty($_POST['achternaam']) AND empty($_POST['email']) AND empty($_POST['ww_oud']) AND empty($_POST['ww_nieuw1']) AND empty($_POST['ww_nieuw2'])) {
        $_SESSION['error'] = '<br><br> <div class="alert alert-danger" role="alert"> U moet eerst iets invullen voor dat u iets op kunt slaan.</div>';
        $_SESSION['fail'] = TRUE;
    } else {
        return TRUE;
    }
}

function checkPassword() {


    if (empty($_POST["ww_oud"])) {
        $_SESSION['error'] = '<br><br> <div class="alert alert-danger" role="alert"> Vul uw wachtwoord in om nieuwe gegevens op te kunnen slaan.</div>';
        $_SESSION['fail'] = TRUE;
    } elseif (hashOldPassword() != retrievePass()) {
        $_SESSION['error'] = ' <br><br> <div class="alert alert-danger" role="alert"> Huidig wachtwoord is niet correct!</div>';
        $_SESSION['fail'] = TRUE;
    } elseif ($_POST['ww_nieuw1'] != $_POST['ww_nieuw2']) {
        $_SESSION['error'] = ' <br><br> <div class="alert alert-danger" role="alert"><strong>Let op!</strong> Het nieuwe wachtwoord komt niet met elkaar overeen</div>';
        $_SESSION['fail'] = TRUE;
    } else {

        dataOpslaan();
    }
}

function dataOpslaan() {
    NaamOpslaan();

    AchternaamOpslaan();

    EmailOpslaan();

    WachtwoordOpslaan();

    mailWijzigingen();

    $_SESSION['accountAanpassen'] = TRUE;
    $pdo = NULL;
    header("location: account.php");
}

function NaamOpslaan() {
    global $pdo;
    if (!empty($_POST['voornaam'])) {
        $stmt = $pdo->prepare("UPDATE medewerker SET naam=? WHERE mnr=?;");
        $stmt->execute(array($_POST["voornaam"], $_SESSION['mnr']));
        $_SESSION['naam'] = $_POST['voornaam'];
    }
}

function EmailOpslaan() {
    global $pdo;
    if (!empty($_POST['email'])) {
        $stmt = $pdo->prepare("UPDATE medewerker SET email =? WHERE mnr=?;");
        $stmt->execute(array($_POST["email"], $_SESSION['mnr']));
    }
}

function AchternaamOpslaan() {
    global $pdo;
    if (!empty($_POST['achternaam'])) {
        $stmt = $pdo->prepare("UPDATE medewerker SET achternaam=? WHERE mnr=?;");
        $stmt->execute(array($_POST["achternaam"], $_SESSION['mnr']));
    }
}

function WachtwoordOpslaan() {
    global $pdo;

    if (!empty($_POST['ww_nieuw2'])) {
        $hashedpw = hash('sha256', $_POST['ww_nieuw2']);
        $stmt = $pdo->prepare("UPDATE medewerker SET wachtwoord=? WHERE mnr=?;");
        $stmt->execute(array($hashedpw, $_SESSION['mnr']));
    }
}

function hashOldPassword() {
    $hashedpw = hash('sha256', $_POST['ww_oud']);
    return $hashedpw;
}

function mailWijzigingen() {
//Global gebruiken anders vindt die de gegevens(PDO string) niet en moet je keer op keer de connectie opnieuw invullen.
    global $pdo;



    try {
        $ww_nieuw = $_POST['ww_nieuw1'];
        $naam = $_POST["voornaam"];
        $achternaam = $_POST["achternaam"];

        if (!empty($_POST["email"])) {
            $email = $_POST["email"];
        } else {
            $email = returnEmail();
        }

        $pass = $_POST["ww_nieuw1"];

        $to = $email;

        $subject = 'Gegevens wijziging';
        $headers = "From: info@lasergamebox,nl\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html><body>';
        $message .= '<img src="http://project.stomic.com/core/img/slide1.jpg" height="200" width="700" alt="lasergamebox.nl" />';
        $message .= '<h1>Lasergamebox.nl</h1>';
        $message .= '<h3>Inlog gegevens</h3>';
        $message .= '<p>Beste ' . $naam . '</p>';
        $message .= 'Uw gegevens zijn reeds gewijzigd. Hieronder uw gewijzigde gegevens:<br>';

        if (!empty($_POST["voornaam"])) {
            $message .= "<p><strong>Naam:</strong> " . $naam . "</p>";
        }

        if (!empty($_POST["achternaam"])) {
            $message .= "<p><strong>Achternaam:</strong> " . $achternaam . "</p>";
        }

        if (!empty($_POST["email"])) {
            $message .= "<p><strong>Email Adres:</strong> " . $email . "</p>";
        }

        if (!empty($_POST["ww_nieuw1"])) {
            $message .= "<p><strong>Wachtwoord:</strong> " . $pass . "</p>";
        }
        $message .= '<p><strong>Login: </strong><a href="http://www.lasergamebox.nl/admin">Admin Paneel</a><p>';
        $message .= '<p></p>';
        $message .= "</body></html>";

        mail($to, $subject, $message, $headers);
    } catch (PDOException $e) {
        print "<div class=\"alert alert-danger\" role=\"alert\">Het wijzigen is mislukt. Probeer het opnieuw.";
    }

    $pdo = NULL;
}

/* FUNCTIES VOOR DE CONTACT PAGINA */

function count_down_live($x) {

    print '<body onload="countDown()">';
    print '<br><div class="well well-sm">Wachttijd: <span id="cntdwn"></span> seconden</div>';
    $s = 60 - $x;
    ?>
        <script>



            var intCountDown = <?php print $s ?>;

            function countDown()
            {
                if (intCountDown < 0)
                {
                    cntdwn.innerText = '0';
                    return;
                }

                cntdwn.innerText = intCountDown--;

                setTimeout("countDown()", 1000);
            }
        </script>
    <?php
    if ($s <= 0) {
        $_SESSION['bericht_check'] = FALSE;
    }
}

function flood_message($x) {
    ?>
        <style>
            body {
                background: #fbfbfb;
                font-family: 'Source Sans Pro', sans-serif;
            }
            .well {
                margin: 50px auto;
                text-align: center;
                padding: 25px;
                max-width: 600px;
            }
            h1, h2, h3, p {
                margin: 0;
            }
            p {
                font-size: 17px;
                margin-top: 25px;
            }
            p a.btn {
                margin: 0 5px;
            }
            h1 .glyphicon {
                vertical-align: -5%;
                margin-right: 5px;
            }
        </style>
        <body onload="countDown()">
            <div class="container">
                <div class="well">
                    <h1><div class="glyphicon glyphicon-alert"></div> Wacht even</h1>
                    <p>Je moet nog <span id="cntdwn"></span> seconden wachten met een e-mail te versturen.</p>
                    <p>
                        <a class="btn btn-default btn-lg" href="#" onclick="history.back();
                                    return false;">Keer terug</a>
                        <a class="btn btn-default btn-lg" href="index.php">Naar homepage</a>
                    </p>
                </div>
            </div>

    <?php $s = 60 - $x; ?>
            <script>



                var intCountDown = <?php echo $s ?>;

                function countDown()
                {
                    if (intCountDown < 0)
                    {
                        cntdwn.innerText = '0';
                        return;
                    }

                    cntdwn.innerText = intCountDown--;

                    setTimeout("countDown()", 1000);


                }
            </script>

    <?php
}

function antiflood() {

    $mails = 1; //aantal emails ontvangen van de zelfde persoon.
    $tijd = 60; //tijd in seconden
    // Je zult er uiteindelijk maximaal 2 per 30seconds kunnen ontvangen.

    if (isset($_SESSION['flood'])) {
        if ((time() - $_SESSION['flood']['TijD']) >= $tijd) {
            unset($_SESSION['flood']);

            $_SESSION['flood']['TijD'] = time();
            $_SESSION['flood']['Views'] = 0;
        } else {
            $_SESSION['flood']['Views'] ++;

            if ($_SESSION['flood']['Views'] >= $mails) {
                $_SESSION['bericht_check'] = TRUE;
                //Getoonde bericht
                print head();
                print flood_message(time() - $_SESSION['flood']['TijD']);
                exit();
            }
        }
    } else {
        $_SESSION['bericht_check'] = FALSE;
        $_SESSION['flood']['TijD'] = time();
        $_SESSION['flood']['Views'] = 0;
    }
}

/* reservering inlog klant */

function login_reservering() {
    ?>
            <div class="col-md-10 col-md-offset-1">
                <h1 style="padding-left:11px;">Mijn reservering</h1>
                <div class="col-md-6">

                    <p>Wij bieden u het gemaak aan om met uw reserverinsnummer en e-mailadres in te loggen.<br>
                        Hier kunt u alle informatie vinden over uw reservering maar ook de status bekijken van uw reservering.</p>

                </div>
                <div class="col-md-6">

                    <form action="reservering.php" class="form-horizontal" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-6 control-label" for="textinput">E-mail</label>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="E-mail" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>"  name="email" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label" for="textinput">Reservering nummer</label>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Reservering nummer" value="<?= isset($_POST['reserveringnr']) ? $_POST['reserveringnr'] : '' ?>" name="reserveringnr" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 pull-right">
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="submit" value="Inloggen">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div> <!-- einde col-12 -->

    <?php
}

function login_check_reservering() {

    if (isset($_POST['submit'])) {

        global $pdo;

        $email = $_POST['email'];
        $reservernr = $_POST['reserveringnr'];



        if (isset($_POST) && $email != '' && $reservernr != '') {

            $stmt = $pdo->prepare("SELECT *
                                    FROM klant K JOIN reservering R on K.klantnr = R.klantnr
                                    WHERE email=? && R.reserveringnr=?");
            $stmt->execute(array($email, $reservernr));
            while ($result = $stmt->fetch()) {
                $email_address = $result['email'];
                $klantnr = $result['klantnr'];
                $rnr = $result['reserveringnr'];
                $_SESSION['naam'] = $result['naam'];
                $_SESSION['achternaam'] = $result['achternaam'];
                $_SESSION['reservering'] = $result['reserveringnr'];
            }

            if ($email && $reservernr = $email_address && $rnr) {
                $_SESSION['start'] = time(); // Taking now logged in time.
                $_SESSION['expire'] = $_SESSION['start'] + (1 * 30);
                $_SESSION['login_reservering'] = TRUE;
                print '<script>window.location.assign("reservering.php")</script>';
            } else {
                print "<br><div class=\"alert alert-danger\" role=\"alert\">De combinatie van e-mail en reserveringsnummer is onjuist. </div>";
            }
        } else {
            print "<br><div class=\"alert alert-danger\" role=\"alert\">Vul een e-mail en reserveringsnummer in. </div>";
        }
    }
}

function reserveringoverzicht() {
    ?>

            <div id="myreservation" class="col-md-12">
                <h3>Reservering - <?php print $_SESSION['reservering']; ?></h3>

                <div class="col-md-6">
                    <h4>Persoonlijke gegevens:</h4>
                    <div class="col-md-6 col-sm-3">
                        <ul>
                            <li>Naam:</li>
                            <li>Achternaam:</li>
                            <li>Telefoonnummer:</li>
                            <li>E-mailadres:</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-3">
                        <ul>
                            <li><?php print $_SESSION['naam']; ?></li>
                            <li><?php print $_SESSION['achternaam']; ?></li>
                            <li><?php print $_SESSION['telefoonnummer']; ?></li>
                            <li><?php print $_SESSION['email']; ?></li>
                        </ul>
                    </div>

                    <h4>Adresgegevens:</h4>
                    <div class="col-md-6  col-sm-3">
                        <ul>
                            <li>Adres:</li>
                            <li>Postcode:</li>
                            <li>Woonplaats:</li>
                        </ul>
                    </div>
                    <div class="col-md-6  col-sm-3">
                        <ul>
                            <li><?php print $_SESSION['straatnaam']; ?></li>
                            <li><?php print $_SESSION['postcode']; ?></li>
                            <li><?php print $_SESSION['plaats']; ?></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <h4>Status:</h4>
                </div>
                <div class="col-md-2 text-right">
    <?php print $SESSION['status']; ?>
                </div>

                <div class="col-md-6">
                    <h4>Wat betekent dit?</h4>
                    <p>
                        Lasergamebox bekijkt en controleert de reservering.
                        Wanneer Lasergamebox de reservering accepteerd zult u een bevestigingsmail ontvangen.
                    </p>

                    <h4>Uw bestelling:</h4>
                    <table class="table table-striped">
                        <tr>
                            <td>#</td>
                            <td>Pakket</td>
                            <td>Prijs</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Weekpakket (6 pistolen)</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Borg</td>
                            <td></td>
                            <td><i class="fa fa-question-circle "></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Aanbetaling</td>
                            <td></td>
                            <td><i class="fa fa-question-circle "></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Totaal</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <p>
                        Wilt u de reservering wijzigen? Bel ons dan op:
                    </p>

                </div>
            </div>

    <?php
}