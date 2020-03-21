<?php
session_start();
include_once("includes/connect.php");
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $query = $pdo->prepare("SELECT * FROM user WHERE username = ? AND password_hash = ?");
  $query->bindValue(1, $username);
  $query->bindValue(2, $password);
  $query->execute();

  $num = $query->rowCount();

  if ($num != 1) {
    $error = "Username or Password Incorrect";
  } else {
    $user = $query->fetch(PDO::FETCH_ASSOC);
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user['id'];
    header("Location: index.php");
    exit();
  }

}
?>
<html>
<head>
  <title>Number Playground | Log in</title>
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
    <a href="index.php">Home</a>
    <a href="signup">Sign Up</a>
  </div>
  <div class="grid-2-1 grid-gap-20 padding-30">
    <div class="grid-column-1 grid-row-1">
      <form action="login.php" method="post">
        <h1>Log In</h1>
        <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
        <label for="username">Username</label>
        <input name="username" type="text" placeholder="Username...">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password...">
        <br><br>
        <input type="submit" name="login" value="Log In" class="btn bg-blue text-light hover:bg-green">
      </form>
</body>
</html>
