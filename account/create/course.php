<?php
session_start();
include_once("../../includes/connect.php");
include_once("../../includes/data.php");
$data = new Data;

if (isset($_SESSION['user_id'])) {

if (isset($_POST['create'])) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $startdate = strtotime($_POST['startdate']);
  $enddate = strtotime($_POST['enddate']);
  $joincode = substr(uniqid(), -5);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $pdo->prepare("INSERT INTO course (fullname, summary, startdate, enddate, creator_id, join_code) VALUES (?, ?, ?, ?, ?, ?)");
  $query->bindValue(1, $name);
  $query->bindValue(2, $description);
  $query->bindValue(3, $startdate);
  $query->bindValue(4, $enddate);
  $query->bindValue(5, $_SESSION['user_id']);
  $query->bindValue(6, $joincode);
  $query->execute();

  $course_id = $pdo->lastInsertId();

  $query = $pdo->prepare("INSERT INTO user_course (user_id, course_id) VALUES (?, ?)");
  $query->bindValue(1, $_SESSION['user_id']);
  $query->bindValue(2, $course_id);
  $query->execute();

  header("Location: ../index.php");
  exit();

}

?>
<html>
<head>
  <title>Number Playground | Create A Course</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/main.css">
  <style>
  * {
    font-family: Arial;
  }
  </style>
</head>
<body>
  <div class="navbar bg-dark text-light">
    <a href="../../index.php">Home</a>
    <div class="right-links">
      <a href="../index.php">Account</a>
    </div>
  </div>
  <div class="grid-2-1 phone-grid-1-1">
    <div class="grid-column-1 grid-row-1 phone-grid-column-1 phone-grid-row-1">
      <form action="course.php" method="post" class="padding-30">
        <h1 class="subheading">Create A Course</h1>
        <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
        <label for="name">Course Name</label>
        <input type="text" name="name" placeholder="First Name...">
        <label for="description">Course Description</label>
        <textarea name="description" placeholder="5th Grade Class.."></textarea>
        <label for="startdate">Start Date</label>
        <input type="date" name="startdate">
        <label for="enddate">End Date</label>
        <input type="date" name="enddate">
        <br><br>
        <input type="submit" name="create" value="Create Course" class="btn bg-blue hover:bg-green text-light text-12">
      </form>
    </div>
    <div class="grid-column-2 grid-row-1 text-center phone-grid-column-1 phone-grid-row-1 phone-hidden">
      <br><br>
      <img src="../../images/studentprofile.svg" class="w-90 phone-hidden">
    </div>
  </div>
</body>
</html>
<?php } else {
  header("Location: ../index.php");
  exit();
} ?>
