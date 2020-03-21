<?php
session_start();
include_once("../includes/connect.php");
?>
<html>
<head>
  <title>Number Playground | Student Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/main.css">
  <style>
  * {
    font-family: Arial;
  }
  </style>
</head>
<body>
  <div class="navbar bg-dark text-light">
    <a href="index.php">Sign Up</a>
    <a href="../login.php">Log In</a>
  </div>
  <form>
    <h1>Student Sign Up</h1>
    <b>Username</b><br><br>
    <input type="text" name="username" placeholder="Username..."><br><br>
    <b>Password</b><br><br>
    <input type="password" name="password" placeholder="Password..."><br><br>
    <b>Confirm Password</b><br><br>
    <input type="cpassword" name="password" placeholder="Password..."><br><br>
  </form>
</body>
</html>
