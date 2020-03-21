<?php
session_start();
include_once("../includes/connect.php");
include_once("../includes/data.php");

if (isset($_SESSION['user_id'])) {
  ?>

  <?php
} else {
  header("Location: ../login.php");
  exit();
}
?>
