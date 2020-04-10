<?php
session_start();
include_once("../../includes/connect.php");
include_once("../../includes/data.php");
$data = new Data;
if (isset($_GET['token'])) {

}

 ?>
<html>
<head>
  <title>Number Playground | Email Confirmed!</title>
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
            <h2>Email Confirmed!</h2>
            <p>You can now <a href="../../login.php" class="no-text-decoration text-blue">log in to your account!</a></p>
          </div>
          <div class="grid-column-2 grid-row-1 phone-grid-row-2 phone-grid-column-1-2 text-center">
            <img src="../../images/mailsent.svg" class="w-80">
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
