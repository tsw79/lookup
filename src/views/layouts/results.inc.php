<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/31/2019
 * Time: 13:51
 */
use phpchassis\lib\traits\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PhpChassis-MVC</title>
  <link rel="stylesheet" type="text/css" href="../../../css/jquery.fancybox.min.css">
  <?php require_once "partials/head.inc.php" ?>
  <link rel="stylesheet" type="text/css" href="../../../css/app_style.css">
  <script type="text/javascript" src="../../../js/jquery-3.3.1.min.js"></script>
</head>
<body>
  <article>
    <header id="header">
      <div class="f-row">
        <div class="f-column">
          <section class="search">
            <div class="logo-container">
              <a href="<?= Url::to('/search/index') ?>">
                <img src="../../../web/img/lookup.logo.png" alt="" />
              </a>
            </div>
            <div class="searchbar-container">
              <form id="searchbar" action="results.php" method="GET">
                <input type="hidden" name="type" value="<?= $type ?>" />
                <div class="search">
                  <input type="text" class="searchTerm" name="q" placeholder="Search.." value="<?= $q ?>">
                  <button type="submit" class="searchButton">
                    <i class="material-icons">search</i>
                  </button>
                </div>
              </form>
            </div>
          </section>
        </div>
        <div class="f-column">
          <nav>
            <div class="item">
            <?php require_once "partials/dd_socials.inc.php" ?>
            </div>
            <div class="item">
              <?php require_once "partials/sidenav.inc.php" ?>
            </div>
          </nav>
        </div>
      </div>
      <div class="tabs-container f-row">
        <ul class="tab-list">
          <li class="<?= $type == 'sites' ? 'active' : '' ?>">
            <a href='<?= Url::to('/search/results', ['q'=>$q, 'type'=>'sites']) ?>'>Sites</a>
          </li>
          <li class="<?= $type == 'images' ? 'active' : '' ?>">
            <a href='<?= Url::to('/search/results', ['q'=>$q, 'type'=>'images']) ?>'>Images</a>
          </li>
          <li class="settings ddmenu">
            <a href="#">
              <span class="label">Settings</span><i class='material-icons'>arrow_drop_down</i>
            </a>
              <div id="ddSettings" class="content">
                <div class="wrap">
                  <div>Appearance</div>
                  <div>
                    <a href="#">Light</a>
                    <a href="#">Dark</a>
                  </div>
                </div>
              </div>
          </li>
        </ul>
      </div>
    </header>
    <main> 
      <?php include $contentFile; ?>
    </main>
    
  </article>
  <?php require_once "partials/footer.inc.php"; ?>

    <script>
      doc.addEventListener('DOMContentLoaded', function() {

        // Listener for Settings menu
        _$(".settings a").addEventListener('click', function(event) {
          _$('#ddSettings').classList.toggle('show');
          event.preventDefault();
        }, false);

        // Listener for toggling results-info details
        _$("#toggleResultDetails").addEventListener('click', function(event) {
          var list = _$$('.site-results-info .more');
          for (i=0; i<list.length; i++) {
              list[i].classList.toggle("show");
          }
          // toggle the up/down arrow
          _$('.rotate').classList.toggle('up');
          event.preventDefault();
        }, false);

        // Listener for scrolling
        window.addEventListener('scroll', function() {
          var divTabs = document.getElementsByClassName("tabs-container")[0];
          if (document.documentElement.scrollTop > 65) {
              _$("#header").classList.add("sticky");
              divTabs.style.display = "none";
          }
          else{
              _$("#header").classList.remove("sticky");
              divTabs.style.display = "block";
          }
        });
      });
    </script>
</body>
</html>