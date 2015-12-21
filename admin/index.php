<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__ . '/functions.php');

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

                login_check();

                if ($_SESSION['login'] != TRUE) { login_form(); }
                elseif ($_SESSION['login'] == TRUE) { adminDashboard(); } ?>
            </section>

        </div> <!-- /container -->

        <?php footer(); ?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../core/js/bootstrap.min.js"></script>
    </body>
</html>
