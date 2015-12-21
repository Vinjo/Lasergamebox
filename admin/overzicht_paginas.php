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
            <section>
                <div class="col-md-10 col-md-offset-1">
                    <div class="bs-example">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a data-toggle="tab">Pagina overzicht</a></li>
                        </ul>
                        <div class="tab-content">
                                <p><table class = "table table-hover"><thead>
                                        <tr>
                                            <th>Titel</th>
                                            <th>Content</th>
                                            <th>Laatst gewijzigd</th>
                                            <th>Bewerkt Door</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <?php pagina_overzicht(); ?>
                                </table></p>
                    </div> <!-- einde van tab-content -->
            </section>

            <!-- footer -->
            <?php footer(); ?>

        </div> <!-- /container -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php if (!is_dir('admin')) {
                print '../';
            } ?>core/js/bootstrap.js"></script>
    </body>
</html>
