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
}

 ?>
