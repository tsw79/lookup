<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/31/2019
 * Time: 13:50
 */
use phpchassis\lib\traits\Url;
?>
            <div class="results-count f-row"><?= $numResults ?> results found.</div>
            <?= $results->asHtml() ?>
            <div class="pagination-container">
              <div class="page-buttons">
                <div class="pagenum-container">
                  <img src="../../../img/page_start.png" alt="" />
                </div>
                <?php
                  $pagesToShow = 10;
                  $numPages = ceil($numResults / $pageLimit); // Use ceil to round numbers off
                  $pagesLeft = min($pagesToShow, $numPages);
                  $currentPage = $pageNum - floor($pagesToShow / 2);

                  if ($currentPage < 1) {
                    $currentPage = 1;
                  }
                  if ($currentPage + $pagesLeft > $numPages + 1) {
                    $currentPage = $numPages + 1- $pagesLeft;
                  }

                  while ($pagesLeft != 0 && $currentPage <= $numPages) {
                    if ($currentPage == $pageNum) {
                      echo "<div class='pagenum-container'>
                              <img src='../../../web/images/page_selected.png' alt=''>
                              <span class='page-number'>$currentPage</span>
                            </div>";
                    }
                    else {
                      echo "<div class='pagenum-container'>
                            <a href=" . Url::to('/search/results', ['q'=>$q, 'type'=>$type, 'pg'=>$currentPage])  . ">
                                <img src='../../../img/page.png' alt=''>
                                <span class='page-number'>{$currentPage}</span>
                            </a>
                          </div>";
                    }
                    $currentPage++;
                    $pagesLeft--;
                  }
                ?>
                <div class="pagenum-container">
                  <img src="../../../img/page_end.png" alt="" />
                </div>
              </div>
            </div>