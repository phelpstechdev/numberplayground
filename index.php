<?php
session_start();
include_once("includes/connect.php");
include_once("includes/data.php");
$data = new Data;

$games = $data->getGames();

if (isset($_SESSION['logged_in'])) {
  $user = $data->getUserInfo($_SESSION['user_id']);
} else {
  $user = array("user_id" => 0, "firstname" => "guest", "lastname" => "user", "username" => "guest", "roleid" => 6, "status" => 0);
}
?>
<html>
<head>
  <title>Number Playground</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/main.css">
  <style>
  * {
    font-family: Arial;
  }
  </style>
</head>
<body>
  <div class="navbar bg-dark text-light">
    <a href="#">Home</a>
    <div class="right-links">
      <?php if (isset($_SESSION['user_id'])) { ?>
        <a href="account">Account</a>
      <?php } else { ?>
        <a href="signup">Sign Up</a>
        <a href="login.php">Log In</a>
      <?php } ?>
    </div>
  </div>
  <div class="heroImage h-50 full-width padding-30 bg-dark text-light">
    <h1 class="title text-center">Welcome, <?php echo $user['firstname']; ?>!</h1>
  </div>
  <div class="grid-5-auto padding-30 grid-gap-20">

    <?php

    foreach($games as $game) {

      ?>
      <div class="bg-dark text-light">
        <img src="images/<?php echo $game['image']; ?>" class="full-width" style="height: 150px; object-fit: cover;">
        <div class="padding-30">
          <h3><?php echo $game['name']; ?>
        </div>
      </div>
      <?php

    }

     ?>

  </div>
</body>
</html>
