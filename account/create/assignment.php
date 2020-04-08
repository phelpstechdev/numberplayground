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
    $course_id = $_POST['course_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $startdate = strtotime($_POST['startdate']);
    $enddate = strtotime($_POST['enddate']);
    $gameid = $_POST['game'];
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("INSERT INTO assignment (course_id, name, intro, timedue, timeavailable, game_id) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bindValue(1, $course_id);
    $query->bindValue(2, $name);
    $query->bindValue(3, $description);
    $query->bindValue(4, $enddate);
    $query->bindValue(5, $startdate);
    $query->bindValue(6, $gameid);
    $query->execute();

    header("Location: ../index.php");
    exit();

  }

?>
<html>
<head>
  <title>Number Playground | Create An Assignment</title>
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
          <form action="assignment.php" method="post" class="padding-30">
            <h1 class="subheading">Create An Assignment</h1>
            <p class="text-red"><?php if (isset($error)) { echo $error; } ?></p>
            <input type="text" name="course_id" style="display: none;" value="<?php echo $_GET['cid']; ?>" readonly>
            <label for="name">Assignment Name</label>
            <input type="text" name="name" placeholder="First Name...">
            <label for="description">Assignment Description</label>
            <textarea name="description" placeholder="Complete this Game by Tomorrow with an 80% or better..."></textarea>
            <label for="startdate">Time Available</label>
            <input type="date" name="startdate">
            <label for="enddate">Due Date</label>
            <input type="date" name="enddate">
            <label for="game">Game</label>
            <div id="gameList" class="padding-10"></div>
            <input type="text" name="game" style="display: none;" id="game" readonly>
            <input type="text" name="gameSearch" id="gameSearch" oninput="gameSearcher()" placeholder="Search for A Game...">
            <div id="gameSearchResults"></div>
            <br><br>
            <input type="submit" name="create" value="Create Assignment" class="btn bg-blue hover:bg-green text-light text-12">
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
  function addGame(id) {
    gameInput = document.getElementById("game");
    gameInputValue = gameInput.value;
    if (gameInputValue == id) {
      // do nothing
    } else {
      gameInput.value = id;
    }
    clearInput();
    gameLister();
  }

  function removeGame(id) {
    gameInput = document.getElementById("game");
    gameInputValue = gameInput.value;
    if (gameInputValue.includes(id)) {
      var searchValue = id;
      gameInputValue = gameInputValue.replace(searchValue, "");
      gameInput.value = gameInputValue;
    } else {
      // do nothing
    }
    clearInput();
    gameLister();
  }

  function clearInput() {
    gameSearchInput = document.getElementById("gameSearch");
    gameSearchInput.value = "";
    document.getElementById("gameSearchResults").innerHTML = "";
  }

  function gameSearcher() {
    gameSearchInput = document.getElementById("gameSearch");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("gameSearchResults").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "../../includes/ajax.php?search=game&value=" + gameSearchInput.value, true);
    xhttp.send();
  }
  function gameLister() {
    gameSearchInput = document.getElementById("game");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("gameList").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "../../includes/ajax.php?list=game&value=" + gameSearchInput.value, true);
    xhttp.send();
  }
  </script>
</body>
</html>
<?php } else {
  header("Location: ../index.php");
  exit();
} ?>
