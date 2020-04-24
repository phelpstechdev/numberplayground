<?php
session_start();
include_once("includes/connect.php");
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = $pdo->prepare("SELECT * FROM user WHERE username = ?");
  $query->bindValue(1, $username);
  $query->execute();

  $result = $query->fetch(PDO::FETCH_ASSOC);

  if (!password_verify($password, $result['password_hash'])) {
    $error = "Username or Password Incorrect";
  } else if ($result['auth_key'] != "verified") {
    $error = "You must first verify your email.";
  } else {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $result['id'];
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
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-client_id" content="811519910005-mgi1lgkvpjfr7mk2gbqmh7i10e49sckj.apps.googleusercontent.com">
  <style>
  * {
    font-family: Arial;
  }
  </style>
</head>
<body>
  <div class="grid-9-9 bg-dark text-light full-height">
    <div class="grid-column-3-7 grid-row-3-7 phone-grid-column-2-8 phone-grid-row-2-8">
      <div class="card full-width bg-light text-dark">
        <div class="grid-2-1">
          <div class="grid-column-1 grid-row-1 phone-grid-column-1-2">
            <form action="login.php" method="post">
              <h1>Log In</h1>
              <div class="g-signin2" data-theme="dark" data-longtitle="true" data-onsuccess="onSignIn"></div>
              <p class="text-red" id="error"><?php if (isset($error)) { echo $error; } ?></p>
              <label for="username">Username</label>
              <input type="text" name="username" placeholder="Username...">
              <label for="password">Password</label>
              <input type="password" name="password" placeholder="Password...">
              <input type="submit" name="login" value="Log In" class="btn bg-blue text-light hover:bg-green">
              <br><br>
              <a href="signup" class="no-text-decoration">Don't Have An Account? Sign Up!</a>
              <br><br>
              <a href="account/reset_password" class="no-text-decoration">Forgot Password?</a>
            </form>
          </div>
          <div class="grid-column-2 grid-row-1 text-center phone-hidden">
            <img src="images/studentprofile.svg" class="w-80">
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function onSignIn(googleUser) {
        var id_token = googleUser.getAuthResponse().id_token;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'googleSignIn.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.responseText == "success") {
              window.location.href = "https://www.phelpstechdev.com/apps/numberplayground";
          } else {
              document.getElementById("error").innerText = xhr.responseText;
          }
        };
        xhr.send('idtoken=' + id_token);
    }
    </script>
</body>
</html>
