<?php
require('functions.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
     <?php print head();?>
    </head>
    <body>
        <?php print static_navbar(); ?>
        <?php print adminnav(); ?>

        <div class="container">

            <section>
                <?php 
                
                login_check_reservering();
                
                
                  if ($_SESSION['login_reservering'] != TRUE) { login_reservering(); }
    else {
        $now = time(); // Checking the time now when home page starts.

        if ($now > $_SESSION['expire']) {
            session_destroy();
           login_reservering();
        }
        else { reserveringoverzicht();
        }
    }
               ?>
            </section>

            <?php footer(); ?>

        </div> <!-- /container -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../core/js/bootstrap.min.js"></script>
    </body>
</html>