<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php head(); ?>
    </head>
    <body>


            <!-- Static navbar -->
              <?php static_navbar(); ?>
            <!-- /Static navbar -->

            <!-- admin navbar -->
              <?php adminnav(); ?>
            <!-- /admin navbar -->
        <div class="container">

            <!-- Carousel
          ================================================== -->
            <?php headerwrap(); ?>
            <?php reservation_bar(); ?>

            <section>
                <?php $pagina->overons(); ?>
            </section>

            <!-- Footer
            ================================================== -->
            <?php footer(); ?>


        </div> <!-- /container -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="core/js/bootstrap.min.js"></script>
        <script src="core/js/spinner.js"></script>
        <script src="core/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {

                var date = new Date();
                date.setDate(date.getDate() + 1);

                $('#van').datepicker({
                    startDate: date,
                    format: "dd/mm/yyyy",
                    language: "nl"
                });


                $('#tot').datepicker({
                    startDate: date,
                    format: "dd/mm/yyyy",
                    language: "nl"
                });


            });
            function handleChange(input) {
                if (input.value < 6)
                    input.value = 6;
                if (input.value > 20)
                    input.value = 20;
                var charCode = (evt.which) ? evt.which : event.keyCode

            }
        </script>
    </body>
</html>