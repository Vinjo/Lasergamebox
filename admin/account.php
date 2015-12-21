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
            <br><br><br><br><br><br>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                <?php if ($_SESSION['accountAanpassen'] == TRUE) {
                            print("<br><br><div class=\"alert alert-success\" id=\"success-alert\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>
                        <strong>Uw gegevens zijn gewijzigd.</strong>U ontvangt binnenkort een e-mail met uw nieuwe gegevens.</div>");
                            unset($_SESSION['accountAanpassen']);
                        }
                viewAccount();?>
            </div>
        </section>
        <?php print footer();?>

        </div> <!-- /container -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php if(!is_dir('admin')) { print '../'; }?>core/js/bootstrap.js"></script>
    </body>
</html>
