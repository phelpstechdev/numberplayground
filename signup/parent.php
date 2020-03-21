
<?php
session_start();
include_once("includes/connect.php");
?>
<html>
<head>
  <title>Number Playground | parent Sign Up</title>
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
    <h1>Parent Sign Up</h1>
        <div class="form-group field-signupform-firstname required">
        <label class="control-label" for="signupform-firstname">First Name</label>
        <input type="text" id="signupform-firstname" placeholder="First Name..."class="form-control"
        name="ParentSignupForm[firstname]" autofocus aria-required="true">

        <p class="help-block help-block-error"></p>
        </div>
        <div class="form-group field-signupform-lastname required">
        <label class="control-label" for="signupform-lastname">Last Name</label>
        <input type="text" id="signupform-lastname" placeholder="Last Name..." class="form-control"
        name="ParentSignupForm[lastname]" aria-required="true">

        <p class="help-block help-block-error"></p>
        </div>
        <div class="form-group field-signupform-username required">
    <label class="control-label" for="signupform-username">Username</label>
    <input type="text" id="signupform-username" placeholder="Username..." class="form-control"
    name="ParentSignupForm[username]" aria-required="true">

    <p class="help-block help-block-error"></p>
    </div>
                <div class="form-group field-signupform-password required">
    <label class="control-label" for="signupform-password">Password</label>
    <input type="password" id="signupform-password" placeholder="Password..." class="form-control"
    name="ParentSignupForm[password]" aria-required="true">

    <p class="help-block help-block-error"></p>
    </div>
                <div class="form-group field-signupform-password required">
    <label class="control-label" for="signupform-password">Confirm Password</label>
    <input type="password" id="signupform-password-Confirm" placeholder="Password..." class="form-control"
    name="SignupForm[passwordConfirm]" aria-required="true">

    <p class="help-block help-block-error"></p>
    </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="signup-button">Signup</button>            </div>
  </form>
</body>
</html>
