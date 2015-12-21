<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__.'/functions.php');
$access->admin();
if (isset($_POST['wijzigen'])) {
    updateAccountData();
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
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                <?php 
                
                if ($_SESSION['fail'] == TRUE) {
                    print($_SESSION['error']);
                    unset($_SESSION['error']);
                    unset($_SESSION['fail']);
                }
                
                wijzig_account();?>
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
