<?php
session_start();
include_once("includes/connect.php");
include_once("includes/data.php");
$data = new Data;

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
      <a href="signup">Sign Up</a>
      <a href="login.php">Log In</a>
    </div>
  </div>
  <div class="heroImage h-50 full-width padding-30 bg-dark text-light">
    <h1 class="title text-center">Welcome, <?php echo $user['firstname']; ?>!</h1>
  </div>
  <div class="grid-5-1 padding-30 grid-gap-20">
    <div class="grid-column-1 grid-row-1">
      <div class="card bg-blue text-light padding-30">
        <p>No games.</p>
      </div>
    </div>
  </div>
</body>
</html>
