<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__.'/functions.php');
$access->admin();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php print head();?>
</head>
<body>
  <!-- Static navbar -->
  <?php static_navbar(); ?>

    <!-- Admin Bar -->
    <?php adminnav(); ?>

    <div class="container">

        <section>
            <h2>Wachtwoord wijzigen</h2>
            <?php wachtwoord_wijzig();

            ?>


        </section>

        <?php print footer();?>

        </div> <!-- /container -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php if(!is_dir('admin')) { print '../'; }?>core/js/bootstrap.js"></script>
    </body>
</html>
