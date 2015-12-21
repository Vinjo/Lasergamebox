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

      <!-- Static navbar -->
      <?php static_navbar(); ?>

        <!-- Admin Bar -->
        <?php adminnav(); ?>

        <div class="container">


            <!-- Layout  -->
            <section class="col-md-12">
      <table class="table table-striped text-center">
        <tr>
          <td>Reserveringsnummer:</td>
          <td>Klant:</td>
          <td>Aantal Pistolen:</td>
          <td>Van datum:</td>
          <td>Tot datum:</td>
          <td>Status</td>
          <td></td>
        </tr>
        <tr>
          <td>2510201501</td>
          <td>John Doe</td>
          <td>6</td>
          <td>30/10/2015</td>
          <td>01/01/2015</td>
          <td><span class="label label-primary">In beoorderling</span></td>
          <td>
              <div class="btn-group">
                <a class="btn btn-default" href="#"><i class="fa fa-file-pdf-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-pencil-square-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-times"></i></a>
              </div>
          </td>
        </tr>
        <tr>
          <td>2510201501</td>
          <td>John Doe</td>
          <td>6</td>
          <td>30/10/2015</td>
          <td>01/01/2015</td>
          <td><span class="label label-info">In behandeling</span></td>
          <td>
              <div class="btn-group">
                <a class="btn btn-default" href="#"><i class="fa fa-file-pdf-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-pencil-square-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-times"></i></a>
              </div>
          </td>
        </tr>
        <tr>
          <td>2510201501</td>
          <td>John Doe</td>
          <td>6</td>
          <td>30/10/2015</td>
          <td>01/01/2015</td>
          <td><span class="label label-success">Behandeld</span></td>
          <td>
              <div class="btn-group">
                <a class="btn btn-default" href="#"><i class="fa fa-file-pdf-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-pencil-square-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-times"></i></a>
              </div>
          </td>
        </tr>
        <tr>
          <td>2510201501</td>
          <td>John Doe</td>
          <td>6</td>
          <td>30/10/2015</td>
          <td>01/01/2015</td>
          <td><span class="label label-danger">Geannuleerd</span></td>
          <td>
              <div class="btn-group">
                <a class="btn btn-default" href="#"><i class="fa fa-file-pdf-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-pencil-square-o"></i></a>
                <a class="btn btn-default" href="#"><i class="fa fa-times"></i></a>
              </div>
          </td>
        </tr>
      </table>
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
