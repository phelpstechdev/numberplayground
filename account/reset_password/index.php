<?php
session_start();
include_once("../../includes/connect.php");
include_once("../../includes/data.php");
$data = new Data;

if (isset($_POST['forgot'])) {
  $email = $_POST['email'];

  $query = $pdo->prepare("SELECT * FROM email WHERE email = ?");
  $query->bindValue(1, $email);
  $query->execute();

  $num = $query->rowCount();

  if ($num != 1) {
    $error = "This email address is not found. Check spelling and try again.";
  } else {

    $results = $query->fetch(PDO::FETCH_ASSOC);

    $user = $data->getUserInfo($results['user_id']);

    $reset_link = md5(md5(md5($email))) . uniqid();

    $query = $pdo->prepare("UPDATE user SET password_reset_token = ? WHERE id = ?");
    $query->bindValue(1, $reset_link);
    $query->bindValue(2, $results['user_id']);
    $query->execute();

    $mail_send = $data->sendResetPasswordEmail($reset_link, $email, $user['firstname'], $user['lastname']);

    if ($mail_send == "Message successfully sent!") {
      header("Location: email_sent.php");
      exit();
    } else {
      echo $mail_send;
    }
  }
}
  ?>
  <html>
  <head>
    <title>Number Playground | Forgot Password</title>
    <link rel="stylesheet" href="../../assets/main.css">
    <style>
    * {
      font-family: Arial;
    }
    </style>
  </head>
  <body>
    <div class="grid-9-9 bg-dark text-light full-height overflow-auto">
      <div class="grid-column-3-7 grid-row-3-7 phone-grid-column-2-8 phone-grid-row-2-8">
        <div class="card full-width bg-light text-dark">
          <div class="grid-2-1 phone-grid-2-2">
            <div class="grid-column-1 grid-row-1 phone-grid-column-1-2">
              <h2>Forgot Your Password?</h2>
              <p>Don't worry, everyone forgets their password. Just enter your email address and you will be emailed with a link that will help you reset your password.</p>
              <form action="index.php" method="post">
                <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
                <label for="email">Email Address</label>
                <input type="email" name="email" placeholder="Email Address...">
                <input type="submit" name="forgot" value="Reset Password" class="btn bg-blue hover:bg-green text-light">
              </form>
            </div>
            <div class="grid-column-2 grid-row-1 phone-grid-row-2 phone-grid-column-1-2 text-center">
              <a href="teacher.php"><img src="../../images/forgotpassword.svg" class="w-80"></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
