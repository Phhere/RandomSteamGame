<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Random Steam Game</title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="style/jumbotron-narrow.css" rel="stylesheet">
  <link href="style/page.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://raw.github.com/aFarkas/html5shiv/master/dist/html5shiv.js"></script>
      <script src="https://raw.github.com/scottjehl/Respond/master/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <div class="container">
        <div class="header">
          <ul class="nav nav-pills pull-right">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
          <h3 class="text-muted">Random Steam Game</h3>
        </div>

        <?php
        if(isset($_REQUEST['cache']) || empty($_REQUEST)){
          $cache = " checked='checked'";
          $caching = true;
        }
        else{
          $cache = "";
          $caching = false;
        }
        ?>

        <div class="row">
          <div class='col-md-12'>
             <form method="get">
               <div class="input-group">
                <input type="text" name="username" value="<?php echo htmlentities(@$_REQUEST['username']);?>" class="form-control">
                <span class="input-group-addon">
                  <input type="checkbox" name="cache" value="on" <?php echo $cache;?>> Cache
                </span>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit">Go!</button>
                </span>
              </div>
            </form>
          </div>
        </div>
        <br/>
        <?php
        if(isset($_REQUEST['username'])){
          $username = trim($_REQUEST['username']);
        }
        else{
          $username = null;
        }
        if(!empty($username)){
          include("query.php");
        }
        else {
        ?>
        <div class="jumbotron">
          <h1>Random Steam Game</h1>
          <p class="lead">Enter your Steam-Name or SteamID to find a game to play. You can enter multiple names (seperated by comma) to find a game you could play together with your friends</p>
        </div>
        <div class="row marketing">
          <div class="col-lg-12">
            <h4>Datasource</h4>
            <p>This Page only parses the public community profiles, so it is limited to public profiles. No Login needed</p>
          </div>

          <div class="col-lg-5">
            <h4>Opensource</h4>
            <p>Fork me on <a href="https://github.com/Phhere/RandomSteamGame">Github</a></p>
          </div>
          <div class="col-lg-7">
            <h4>SteamAPI</h4>
            <p>Thanks to <a href="https://github.com/Neoseeker/SteamAPI">Neoseeker</a> for the Steam Community API.</p>
          </div>
        </div>
        <?php
      }
      ?>

        <div class="footer">
          <p>&copy; Philipp Rehs 2013</p>
        </div>

      </div> <!-- /container -->
  </body>
  </html>
