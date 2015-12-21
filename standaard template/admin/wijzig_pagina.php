<?php
require('../functions.php');
$access->editor();
?>
<html>
<head>
<?php head();?>
<!-- Load jQuery  -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- Load WysiBB JS and Theme -->
<script src="../core/js/jquery.wysibb.min.js"></script>
<link rel="stylesheet" href="http://cdn.wysibb.com/css/default/wbbtheme.css" />

<!-- Init WysiBB BBCode editor -->
<script>
$(function() {
  $("#editor").wysibb();
})
</script>
</head>
<body>
  <!-- Static navbar -->
  <?php static_navbar(); ?>

    <!-- Admin Bar -->
    <?php adminnav(); ?>

    <div class="container">
<section>
<div class="col-md-10">
<?php pagina_wijzig(); ?>
</div>
</section>

            <?php footer(); ?>

        </div> <!-- /container -->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../core/js/bootstrap.js"></script>



    </body>
</html>
