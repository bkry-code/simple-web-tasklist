<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: login.php - login page
// version: 1.0 (2014-09-07)
// -------------------------------------------

include 'config.php';
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <title><?php echo constant("SITETITLE") ?> - login</title>
    <meta charset="utf-8" >
    <meta name="description" content="<?php echo constant("SITEDESC") ?>" >
    <meta name="keywords" content="<?php echo constant("SITEKEYS") ?>" >
    <meta name="author" content="<?php echo constant("SITEAUTHOR") ?>" >
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="robots" content="<?php echo constant("SITEROBOTS") ?>" >

    <link rel="stylesheet" href="http://tasks.beyerstedt.de/assets/bootstrap/css/bootstrap.min.css" />

    <link rel="stylesheet" href="http://tasks.beyerstedt.de/assets/login.css" />
  </head>

  <body>
    <div class="container">

      <form class="form-signin" role="form" method="POST" action="index.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="username" class="form-control" placeholder="User Name" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
