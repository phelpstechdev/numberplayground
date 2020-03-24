<?php
session_start();
include_once("../includes/connect.php");
include_once("../includes/data.php");

$data = new Data;

if (isset($_SESSION['user_id'])) {
  $user = $data->getUserInfo($_SESSION['user_id']);
  $role = $data->getRole($user['roleid']);
  $courses = $data->getCourses($user['id']);
  ?>
<html>
<head>
  <title>Number Playground | Account</title>
  <link rel="stylesheet" href="../assets/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
  * {
    font-family: Arial;
  }
  </style>
</head>
<body>
  <div class="grid-5-1 full-height overflow-auto">
    <div class="grid-column-1 grid-row-1 full-height overflow-auto bg-dark text-light padding-20">
      <h1 class="text-center"><?php echo $user['firstname']; ?> <?php echo $user['lastname']; ?></h1>
      <p class="text-center">You are a <?php echo $role; ?>.</p>
      <br><br>
      <p class="text-12 text-gray">Courses</p>
      <br>
      <?php if ($role == "teacher") {
        ?>
        <a href="create/course.php" class="text-light no-text-decoration">+ Create A New Course</a>
        <br><br><br>
        <?php
      }
      ?>
      <?php foreach ($courses as $course) {
        $courseInfo = $data->getCoursebyId($course['course_id']);
         ?>
          <a href="#" class="text-light no-text-decoration"><?php echo $courseInfo['fullname']; ?></a><br><br>
      <?php } ?>
    </div>
    <div class="grid-column-2-5 grid-row-1 full-height overflow-auto">
      <div class="navbar bg-dark">
        <a href="../index.php">Home</a>
        <div class="right-links">
          <a href="logout.php">Logout</a>
        </div>
      </div>
      <div class="padding-30">
        <h1>Courses</h1>
        <div class="padding-10"></div>
      <?php
      foreach ($courses as $course) {
        $courseInfo = $data->getCoursebyId($course['course_id']);
         ?>
          <div class="card bg-blue text-light w-30 margin-right-10">
          <h1><?php echo $courseInfo['fullname']; ?></h1>
          <p><b>Start Date: </b><?php echo date("F jS, Y", $courseInfo['startdate']); ?></p>
          <p><b>End Date: </b><?php echo date("F jS, Y", $courseInfo['enddate']); ?></p>
          <p><b>Join Code: </b><?php echo $courseInfo['join_code']; ?></p>
          <a href="#"><button class="btn bg-dark text-light hover:bg-light hover:text-dark">View Course</button></a>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
</body>
</html>
  <?php
} else {
  header("Location: ../login.php");
  exit();
}
?>
