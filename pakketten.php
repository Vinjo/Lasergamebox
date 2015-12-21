<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Lasergamebox.nl</title>

        <!-- Bootstrap -->
        <link href="core/css/bootstrap.css" rel="stylesheet">
        <link href="core/css/style.css" rel="stylesheet">
        <link href="core/css/datepicker.css" rel="stylesheet">
        <link href="core/css/font-awesome.min.css" rel="stylesheet" >

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
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
            <section>
                <?php $pagina->pakketten(); ?>
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