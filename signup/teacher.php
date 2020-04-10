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
  $email = $_POST['email'];

  $time = time();

  $auth_key = md5(md5($uname));

  $user_exists = $data->userExists($uname);

  if (empty($fname) || empty($lname) || empty($uname) || empty($pwd) || empty($cpwd) || empty($email)) {
    $error = "All Fields Must Be Filled";
  } else if ($pwd != $cpwd) {
    $error = "Passwords Must Match";
  } else if ($user_exists) {
    $error = "This Username Already Exists, Please Create A New Username";
  } else {

    $password_hash = password_hash($pwd, PASSWORD_DEFAULT);

    $query = $pdo->prepare("INSERT INTO user (username, firstname, lastname, roleid, status, auth_key, password_hash, password_reset_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bindValue(1, $uname);
    $query->bindValue(2, $fname);
    $query->bindValue(3, $lname);
    $query->bindValue(4, 4);
    $query->bindValue(5, 0);
    $query->bindValue(6, $auth_key);
    $query->bindValue(7, $password_hash);
    $query->bindValue(8, "not set yet");
    $query->bindValue(9, $time);
    $query->bindValue(10, $time);
    $query->execute();

    $lastID = $pdo->lastInsertId();

    $query = $pdo->prepare("INSERT INTO email (user_id, email) VALUES (?, ?)");
    $query->bindValue(1, $lastID);
    $query->bindValue(2, $email);
    $query->execute();

  }
}

?>
<html>
<head>
  <title>Number Playground | Teacher Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/main.css">
  <style>
  * {
    font-family: Arial;
  }
  </style>
</head>
<body>
  <div class="grid-2-1 phone-grid-1-1 full-height overflow-auto">
    <div class="grid-column-1 grid-row-1 bg-dark text-light phone-grid-column-1 phone-grid-row-1">
      <form action="teacher.php" method="post" class="padding-30">
        <h1 class="subheading">Teacher Sign Up</h1>
        <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
        <label for="fname">First Name</label>
        <input type="text" name="fname" placeholder="First Name...">
        <label for="lname">Last Name</label>
        <input type="text" name="lname" placeholder="Last Name...">
        <label for="email">Email Address</label>
        <input type="text" name="email" placeholder="Email Address...">
        <br><br>
        <label for="uname">Username</label>
        <input type="text" name="uname" placeholder="Username...">
        <label for="pwd">Password</label>
        <input type="password" name="pwd" placeholder="Password...">
        <label for="cpwd">Confirm Password</label>
        <input type="password" name="cpwd" placeholder="Confirm Password...">
        <br><br>
        <input type="submit" name="signup" value="Sign Up" class="btn bg-blue hover:bg-green text-light text-12">
        <br><br>
        <a href="../login.php" class="text-blue no-text-decoration">Already Have An Account? Sign In!</a>
      </form>
    </div>
    <div class="grid-column-2 grid-row-1 text-center phone-grid-column-1 phone-grid-row-1 phone-hidden">
      <div class="grid-1-4">
        <div class="grid-row-2-3">
          <img src="../images/teacherprofile.svg" class="w-90 phone-hidden" style="align-self: center; justify-self: center;">
        </div>
      </div>
    </div>
  </div>
</body>
</html>
