<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 2/25/2019
 * Time: 23:39
 */
include ("../config.php");

if (isset($_POST["imageUrl"])) {
  $query = $con->prepare("
    UPDATE images
      SET clicks = clicks + 1
      WHERE image_url = :imageUrl
  ");
  $query->bindParam(":imageUrl", $_POST["imageUrl"]);
  $query->execute();
}
else {
  echo "No image URL passed to page";
}