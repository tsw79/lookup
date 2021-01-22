<?php
/**
 * Author: Tharwat
 */
?>
          <div class="sidenav-btn">
            <i class="material-icons">menu</i>
          </div>
          <div id="simple-sidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn">&times;</a>
            <ul>
              <li class="title">SETTINGS</li>
              <li><a href="#home">Theme</a></li>
              <li><a href="#news">Other</a></li>
              <li class="title">PRIVACY ESSENTIALS</li>
              <li><a href="#contact">Private Search</a></li>
              <li><a href="#about">App & Extensions</a></li>
              <li class="title">WHY PRIVACY</li>
              <li><a href="#contact">Privacy Blog</a></li>
              <li><a href="#about">Privacy Crash Course</a></li>
              <li><a href="#about">Help Spread Privacy</a></li>
              <li class="title">WHO WE ARE</li>
              <li><a href="#contact">About Us</a></li>
              <li><a href="#about">Privacy Policy</a></li>
              <li><a href="#about">Press Kit</a></li>
              <li class="title">KEEP IN TOUCH</li>
              <li><a href="#contact">Twitter</a></li>
              <li><a href="#about">Reddit</a></li>
              <li><a href="#about">Help</a></li>
            </ul>
          </div>
            <script>
              doc.addEventListener('DOMContentLoaded', function() {

                // Listener to open sidenav
                _$(".sidenav-btn").addEventListener('click', function(event) {
                    _$id("simple-sidenav").style.width = "200px";
                }, false);

                // Listener to close sidenav
                _$(".sidenav .closebtn").addEventListener('click', function(event) {
                    _$id("simple-sidenav").style.width = 0;
                }, false);
              });
            </script>