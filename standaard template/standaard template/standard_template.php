<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__ . '/functions.php');
$access->editor();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Header -->
        <?php head(); ?>
    </head>
    
    <body>
        
        <!-- Admin Bar -->
        <?php adminnav(); ?>
        
        <div class="container">

            <!-- Static navbar -->
            <?php static_navbar(); ?>
            
              <!-- Carousel
      ================================================== -->
            <?php carousel(); ?>
              

            <!-- Layout  -->
            <section>
                
                
                
                <!-- content hier -->
                
                
                
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







