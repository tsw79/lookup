<?php
/**
 * Author: tsw
 * 
 * Dropdown socials
 */
?>
              <div class="ddmenu-ul l2">
                <a href="#">
                  <i class="material-icons">campaign</i><i class='material-icons'>arrow_drop_down</i>
                </a>
                  <ul id="ddSocial">
                    <li><a href="#"><i class='material-icons md-18'>rate_review</i> Blog</a></li>
                    <li><a href="#"><i class='material-icons md-18'>article</i> Newsletter</a></li>
                  </ul>
              </div>
                <script>
                  doc.addEventListener('DOMContentLoaded', function() {
                    /* Listener for Social-links menu */
                    _$(".ddmenu-ul.l2").addEventListener('click', function(event) {
                      _$('#ddSocial').classList.toggle('show');
                      event.preventDefault();
                    }, false);
                  });
                </script>