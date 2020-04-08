<?php

class Data {
  public function userExists($username) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $query->bindValue(1, $username);
    $query->execute();

    $num = $query->rowCount();

    if ($num != 1) {
      return false;
    } else {
      return true;
    }

  }

  public function getUserInfo($id) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetch();
  }

  public function getRole($id) {
    global $pdo;
    $query = $pdo->prepare("SELECT * FROM role WHERE id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    $role = $query->fetch();

    return $role['name'];
  }

  public function getCoursesbyCreator($id) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM course WHERE creator_id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetchAll();
  }

  public function getCoursebyId($id) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM course WHERE id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetch();
  }

  public function getUserCourses($id) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM user_course WHERE user_id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetchAll();
  }

  public function courseExists($id) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM course WHERE id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    $num = $query->rowCount();

    if ($num != 1) {
      return false;
    } else {
      return true;
    }
  }

  public function getAssignmentsByCourse($course) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM assignment WHERE course_id = ?");
    $query->bindValue(1, $course);
    $query->execute();

    return $query->fetchAll();
  }

  public function getGameById($id) {
    global $pdo;
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT * FROM game WHERE id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetch();
  }

  public function getGamesBySearch($search) {
    global $pdo;
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT * FROM game WHERE name LIKE '%$search%'");
    $query->execute();

    return $query->fetchAll();
  }

  public function getGames() {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM game");
    $query->execute();

    return $query->fetchAll();
  }

  public function getClasses() {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM class");
    $query->execute();

    return $query->fetchAll();
  }

  public function getDomains() {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM domain");
    $query->execute();

    return $query->fetchAll();
  }

  public function uploadFile($file) {
    $target_dir = "../../images/";
    $file_name = uniqid();
    $file_type = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
    $target_file = $target_dir . $file_name . "." . $file_type;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $target_file;
    } else {
      return "Failure";
    }

  }

}

 ?>
