<?php
session_start();
include_once("../../includes/connect.php");
include_once("../../includes/data.php");
$data = new Data;

if (isset($_SESSION['user_id'])) {

  $user = $data->getUserInfo($_SESSION['user_id']);
  $role = $data->getRole($user['roleid']);
  $courses = $data->getUserCourses($user['id']);

  if (isset($_POST['join'])) {
    $code = $_POST['code'];
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT * FROM course WHERE join_code = ?");
    $query->bindValue(1, $code);
    $query->execute();

    $course = $query->fetch(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("INSERT INTO user_course (user_id, course_id) VALUES (?, ?)");
    $query->bindValue(1, $_SESSION['user_id']);
    $query->bindValue(2, $course['id']);
    $query->execute();

    header("Location: ../index.php");
    exit();

  }

?>
<html>
<head>
  <title>Number Playground | Join A Course</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/main.css">
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
    <div class="grid-column-2-5 grid-row-1 full-height overflow-auto" style="background-color: #ccc;">
      <div class="navbar bg-dark text-light">
        <a href="../../index.php">Home</a>
        <div class="right-links">
          <a href="../logout.php">Logout</a>
        </div>
      </div>
      <div class="grid-10-10">
        <div class="card grid-column-2-9 grid-row-2-9 bg-light text-dark">
          <form action="course.php" method="post" class="padding-30">
            <h1 class="subheading">Join A Course</h1>
            <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
            <label for="code">Course Join Code</label>
            <input type="text" name="code" placeholder="Join Code...">
            <br><br>
            <input type="submit" name="join" value="Join Course" class="btn bg-blue hover:bg-green text-light text-12">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php } else {
  header("Location: ../index.php");
  exit();
} ?>
