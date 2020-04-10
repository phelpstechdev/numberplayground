<?php
session_start();
include_once("../../includes/connect.php");
include_once("../../includes/data.php");
$data = new Data;
if (isset($_SESSION['user_id'])) {
  $user = $data->getUserInfo($_SESSION['user_id']);
  $role = $data->getRole($user['roleid']);
  $courses = $data->getUserCourses($user['id']);
  if (isset($_GET['cid'])) {

    if ($data->courseExists($_GET['cid'])) {

      $courseInfo = $data->getCourseById($_GET['cid']);

  ?>

<html>
<head>
  <title>Number Playground | Course: <?php echo $courseInfo['fullname']; ?></title>
  <link rel="stylesheet" href="../../assets/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
  * {
    font-family: Arial;
  }
  .text-muted {
    color: #393939;
  }
  </style>
</head>
<body>
  <div class="grid-5-1 full-height overflow-auto">
    <div class="grid-column-1 grid-row-1 full-height overflow-auto bg-dark text-light padding-20">
      <h1 class="text-center"><?php echo $user['firstname']; ?> <?php echo $user['lastname']; ?></h1>
      <p class="text-center">You are a <?php echo $role; ?>.</p>
      <br><br>
      <?php if ($role == "manager") { ?>
        <h2>Games</h2>
      <?php } else {
        ?>
        <h2>Courses</h2>
        <?php
      } ?>
      <br>
      <?php if ($role == "teacher") {
        ?>
        <a href="../create/course.php" class="text-light no-text-decoration">+ Create A New Course</a>
        <br><br><br>
        <?php
      }
      ?>
      <?php foreach ($courses as $course) {
        $courseInfo = $data->getCoursebyId($course['course_id']);
         ?>
          <a href="../course/index.php?cid=<?php echo $courseInfo['id']; ?>" class="text-light no-text-decoration"><?php echo $courseInfo['fullname']; ?></a><br><br>
      <?php } ?>
    </div>
    <div class="grid-column-2-5 grid-row-1 full-height overflow-auto" style="background-color: #dedede;">
      <div class="navbar bg-dark text-light">
        <a href="../../index.php">Home</a>
        <div class="right-links">
          <a href="../logout.php">Logout</a>
        </div>
      </div>
      <div class="padding-30">
        <h1 class="text-dark">Course: <?php echo $courseInfo['fullname']; ?></h1>
        <div class="grid-2-auto grid-gap-20">
          <div class="card bg-light text-dark">
            <h2>Assignments</h2>
            <div style="height: 150px; overflow: auto;">
              <?php

              $assignments = $data->getAssignmentsByCourse($courseInfo['id']);

              if (empty($assignments) && $role == "teacher") {
                echo "<p>No Assignments Yet! <a href='../create/assignment.php?cid=" . $courseInfo['id'] . "'>Click Here To Create One!</a></p>";
              } else if (empty($assignments) && ($role == "student" || $role == "parent")) {
                echo "<p>No assignments yet! Your assignments will appear here when your teacher posts them.</p>";
              }

              foreach ($assignments as $assignment) {

                ?>

                <div class="grid-9-auto">
                  <div class="grid-column-1-5">
                    <p class="text-muted hover:text-dark"><?php echo $assignment['name']; ?></p>
                  </div>
                  <div class="grid-column-6-9" style="align-self: center; justify-self: center;">
                    <button class="btn pill bg-red text-light">View</button>
                  </div>
                </div>

                <?php

              }

               ?>
            </div>
          </div>
          <div class="card bg-light text-dark">
            <h2>Students</h2>
            <button class="btn bg-green text-light">Add A Student</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

  <?php

    }
  } else {
    header("Location: ../index.php");
    exit();
  }
} else {
  header("Location: ../index.php");
  exit();
}

?>
