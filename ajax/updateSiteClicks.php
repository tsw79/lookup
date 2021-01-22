<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 2/25/2019
 * Time: 23:39
 */
include ("../config.php");

if (isset($_POST["linkId"])) {
  $query = $con->prepare("
    UPDATE sites
      SET clicks = clicks + 1
      WHERE id = :id
  ");
  $query->bindParam(":id", $_POST["linkId"]);
  $query->execute();
}
else {
  echo "No link passed to page";
}