<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__ . '/functions.php');
$access->editor();

if (isset($_POST['opslaan'])) {
    if(checkAllFields()) {
        insOpslaan();
        }
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
                <div class="col-md-10 col-md-offset-1">
                    <?php
                    if ($_SESSION['insOpslaan'] == TRUE) {
                        print($_SESSION['insMessage']);
                        unset ($_SESSION['insOpslaan']);
                        unset ($_SESSION['insMessage']);

                    } 
                    instellingen();

                    ?>

                    <script>
                        $(document).ready(function () {
                            $('#tooltip').tooltip();
                        });
                    </script>
                </div>
            </section>

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
