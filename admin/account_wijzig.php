<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__.'/functions.php');
$access->admin();

if(isset($_POST['terug'])) {
    header('location: overzicht_medewerkers.php');
}

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
            <br>
            <h2>Account wijzigen</h2>
            <?php account_wijzig();

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
