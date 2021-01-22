<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/25/2019
 * Time: 10:27
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PhpChassis-MVC</title>
  <link rel="stylesheet" type="text/css" href="../../../css/app_index_style.css">
  <?php require_once "partials/head.inc.php" ?>
</head>
<body>
  <article>
    <header id="header">
      <nav>
        <div class="item">
          <?php require_once "partials/sidenav.inc.php" ?>          
        </div>
        <div class="item">
          <?php require_once "partials/dd_socials.inc.php" ?>
        </div>
      </nav>
    </header>
    <main>
      <?php include $contentFile; ?>
    </main>
    <?php require_once "partials/footer.inc.php"; ?>
  </article>
</body>
</html>
