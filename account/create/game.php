<?php
session_start();
include_once("../../includes/connect.php");
include_once("../../includes/data.php");
$data = new Data;

if (isset($_SESSION['user_id'])) {

  $user = $data->getUserInfo($_SESSION['user_id']);
  $role = $data->getRole($user['roleid']);
  $courses = $data->getUserCourses($user['id']);

  if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $domain = $_POST['domain'];
    $class = $_POST['class'];
    $javascriptFile = $_FILES['javascriptFile'];
    $imageFile = $_FILES['imageFile'];
    $jF_upload = $data->uploadjsFile($javascriptFile);
    $iF_upload = $data->uploadimageFile($imageFile);

    echo $name;
    echo $class;

    if ($jF_upload != "Failure" && $iF_upload != "Failure") {

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query = $pdo->prepare("INSERT INTO game (name, class_id, domain_id, javascript, image) VALUES(?, ?, ?, ?, ?)");
      $query->bindValue(1, $name);
      $query->bindValue(2, $class);
      $query->bindValue(3, $domain);
      $query->bindValue(4, basename($jF_upload));
      $query->bindValue(5, basename($iF_upload));
      $query->execute();

    }

  }

?>
<html>
<head>
  <title>Number Playground | Create A Game</title>
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
          <form action="game.php" method="post" class="padding-30" enctype="multipart/form-data">
            <h1 class="subheading">Create A Game</h1>
            <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
            <label for="name">Game Name</label>
            <input type="text" name="name" placeholder="Game Name...">
            <label for="class">Class</label>
            <select name="class">
              <?php

              $classes = $data->getClasses();

              foreach ($classes as $class) {

                ?>
                <option value="<?php echo $class['id']; ?>"><?php echo $class['class']; ?></option>
                <?php

              }

               ?>
            </select>
            <label for="domain">Domain</label>
            <select name="domain">
              <?php

              $domains = $data->getDomains();

              foreach ($domains as $domain) {

                ?>
                <option value="<?php echo $domain['id']; ?>"><?php echo $domain['domain']; ?></option>
                <?php

              }

               ?>
            </select>
            <label for="javascriptFile">Javascript File</label>
            <input type="file" name="javascriptFile">
            <label for="imageFile">Thumbnail Image</label>
            <input type="file" name="imageFile">
            <br><br>
            <input type="submit" name="create" value="Create Game" class="btn bg-blue hover:bg-green text-light text-12">
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
