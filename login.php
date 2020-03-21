<?php
session_start();
include_once("includes/connect.php");
?>
<html>
<head>
  <title>Number Playground | Log in</title>
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
    <a href="index.php">Home</a>
    <a href="signup">Sign Up</a>
  </div>
  <form>
    <h1>Log In</h1>
    <b>Username</b><br><br>
    <input type="text" name="username" placeholder="Username..."><br><br>
    <b>Password</b><br><br>
    <input type="password" name="password" placeholder="Password..."><br><br>
  </form>
</body>
</html>
