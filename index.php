<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="bootstrap/assets/ico/favicon.png">

  <title>Random Steam Game</title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="style/jumbotron-narrow.css" rel="stylesheet">
  <link href="style/page.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <div class="container">
        <div class="header">
          <ul class="nav nav-pills pull-right">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
          <h3 class="text-muted">Random Steam Game</h3>
        </div>


        <div class="row">
           <div class="col-lg-12">
             <form method="post">
               <div class="input-group">
                <input type="text" name="username" value="<?php echo htmlentities(@$_REQUEST['username']);?>" class="form-control">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Go!</button>
                </span>
              </div>
            </form>
          </div>
        </div>
        <br/>
        <?php
        $var = trim($_REQUEST['username']);
        if(isset($_REQUEST['username']) && !empty($var)){
          include("query.php");
        }
        else {
        ?>
        <div class="jumbotron">
          <h1>Random Steam Game</h1>
          <p class="lead">Enter your Steam-Name or SteamID to find a game to play. You can enter multiple names (seperated by comma) to find a game you could play together with your friends</p>
        </div>
        <div class="row marketing">
          <div class="col-lg-6">
            <h4>Subheading</h4>
            <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

            <h4>Subheading</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

            <h4>Subheading</h4>
            <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
          </div>

          <div class="col-lg-6">
            <h4>Subheading</h4>
            <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

            <h4>Subheading</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

            <h4>Subheading</h4>
            <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
          </div>
        </div>
        <?php
      }
      ?>

        <div class="footer">
          <p>&copy; Company 2013</p>
        </div>

      </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
  </html>
