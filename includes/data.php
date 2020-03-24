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

  public function getCourses($id) {
    global $pdo;

    $query = $pdo->prepare("SELECT * FROM user_course WHERE user_id = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetchAll();
  }
}

 ?>
