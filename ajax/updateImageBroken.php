<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 2/25/2019
 * Time: 23:39
 */
include ("../config.php");

if (isset($_POST["srcUrl"])) {
  $query = $con->prepare("
    UPDATE images
      SET broken = 1
      WHERE image_url = :srcUrl
  ");
  $query->bindParam(":srcUrl", $_POST["srcUrl"]);
  $query->execute();
}
else {
  echo "No link passed to page";
}