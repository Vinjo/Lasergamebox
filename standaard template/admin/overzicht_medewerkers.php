<?php
require('../functions.php');
$access->admin();

if (isset($_GET['delete'])) {
        verwijderMedewerker();
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=overzicht_medewerkers.php\">";
}

if (isset($_POST['toevoegen'])) {
    account_toevoegen();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=overzicht_medewerkers.php\">";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php head(); ?>
    </head>
    <body>
      <!-- Static navbar -->
      <?php static_navbar(); ?>

        <!-- Admin Bar -->
        <?php adminnav(); ?>

        <div class="container"> 
            <!-- Layout  -->
            <section>
                <br><br>
                <?php 
                
                if ($_SESSION['AccountStatus'] == TRUE) {
                        print($_SESSION['AccountMessage']);
                        unset ($_SESSION['AccountStatus']);
                        unset ($_SESSION['AccountMessage']);

                    }
                
                overzicht_medewerkers(); ?>
            </section>

            <?php footer(); ?>

        </div> <!-- /container -->
          <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../core/js/bootstrap.js"></script>



    </body>
</html>
