<?php
session_start();
include_once("../includes/connect.php");
include_once("../includes/data.php");
$data = new Data;

if (isset($_POST['signup'])) {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $uname = $_POST['uname'];
  $pwd = $_POST['pwd'];
  $cpwd = $_POST['cpwd'];

  $time = time();

  $auth_key = md5(md5($uname));

  $user_exists = $data->userExists($uname);

  if (empty($fname) || empty($lname) || empty($uname) || empty($pwd) || empty($cpwd)) {
    $error = "All Fields Must Be Filled";
  } else if ($pwd != $cpwd) {
    $error = "Passwords Must Match";
  } else if ($user_exists) {
    $error = "This Username Already Exists, Please Create A New Username";
  } else {
    $query = $pdo->prepare("INSERT INTO user (username, firstname, lastname, roleid, status, auth_key, password_hash, password_reset_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bindValue(1, $uname);
    $query->bindValue(2, $fname);
    $query->bindValue(3, $lname);
    $query->bindValue(4, 5);
    $query->bindValue(5, 0);
    $query->bindValue(6, $auth_key);
    $query->bindValue(7, md5($pwd));
    $query->bindValue(8, "not set yet");
    $query->bindValue(9, $time);
    $query->bindValue(10, $time);

    $query->execute();
  }
}

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
  <div class="grid-2-1">
    <div class="grid-column-1 grid-row-1">
      <form action="student.php" method="post" class="padding-30">
        <h1 class="subheading">Student Sign Up</h1>
        <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
        <label for="fname">First Name</label>
        <input type="text" name="fname" placeholder="First Name...">
        <label for="lname">Last Name</label>
        <input type="text" name="lname" placeholder="Last Name...">
        <br><br>
        <label for="uname">Username</label>
        <input type="text" name="uname" placeholder="Username...">
        <label for="pwd">Password</label>
        <input type="password" name="pwd" placeholder="Password...">
        <label for="cpwd">Confirm Password</label>
        <input type="password" name="cpwd" placeholder="Confirm Password...">
        <br><br>
        <input type="submit" name="signup" value="Sign Up" class="btn bg-blue hover:bg-green text-light text-12">
      </form>
    </div>
  </div>
</body>
</html>
