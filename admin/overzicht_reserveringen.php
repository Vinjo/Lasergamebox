<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__ . '/functions.php');
$access->admin();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Header -->
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
              <div class="col-md-10 col-md-offset-1">
                <div id="overzicht" class="tab-pane fade in active">
                <?php
                    if ($_SESSION['verwijder'] == TRUE) {
                       print("<div class=\"alert alert-success\" id=\"success-alert\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                                <strong>Gelukt!</strong> Reservering verwijderd.
                                </div>");
                        unset ($_SESSION['verwijder']);
                    }
                    
                    reserveringen();
                    
                    
                ?>
                </div>
                  <div class="col-md-2 pull-right"><a href="aanmaak_reservering.php"><button type="button" class="btn btn-success">Nieuwe reservering</button></a></div>
              </div>
            </section>

            <!-- footer -->
            <?php footer(); ?>

        </div> <!-- /container -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php if (!is_dir('admin')) { print '../'; } ?>core/js/bootstrap.js"></script>
    </body>
</html>
