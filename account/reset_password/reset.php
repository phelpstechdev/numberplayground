<?php
session_start();
include_once("../../includes/connect.php");
include_once("../../includes/data.php");
$data = new Data;

if (isset($_GET['token'])) {
  $query = $pdo->prepare("SELECT * FROM user WHERE password_reset_token = ?");
  $query->bindValue(1, $_GET['token']);
  $query->execute();
  $num = $query->rowCount();

  if ($num != 1) {
    $error = "Invalid Token";
  } else {
    $user = $query->fetch(PDO::FETCH_ASSOC);
  }


}

if (isset($_POST['resetpassword'])) {
  $id = $_POST['id'];
  $newpassword = $_POST['newpassword'];
  $confirmpassword = $_POST['confirmpassword'];

  $time = time();

  if ($newpassword == $confirmpassword) {

    $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);

    $query = $pdo->prepare("UPDATE user set password_hash = ?, updated_at = ? WHERE id = ?");
    $query->bindValue(1, $password_hash);
    $query->bindValue(2, $time);
    $query->bindValue(3, $id);
    $query->execute();

    header("Location: ../../login.php");
    exit();

  } else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
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
             <h2>Reset Your Password</h2>
             <?php if (isset($error)) {
               ?>
               <p class="text-red"><?php echo $error; ?></p>
               <?php
             } else { ?>
             <form action="reset.php" method="post">
               <input type="text" name="id" value="<?php echo $user['id']; ?>" style="display: none;" readonly>
               <label for="newpassword">New Password</label>
               <input type="password" name="newpassword" placeholder="New Password...">
               <label for="confirmpassword">Confirm Password</label>
               <input type="password" name="confirmpassword" placeholder="Confirm Password...">
               <input type="submit" name="resetpassword" value="Reset Password" class="btn bg-blue text-light hover:bg-green">
             </form>
           <?php } ?>
           </div>
           <div class="grid-column-2 grid-row-1 phone-grid-row-2 phone-grid-column-1-2 text-center">
             <img src="../../images/authentication.svg" class="w-80">
           </div>
         </div>
       </div>
     </div>
   </div>
 </body>
 </html>
