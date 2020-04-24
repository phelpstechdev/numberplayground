<?php
require_once("../assets/api/google-php/vendor/autoload.php");
include_once("../includes/connect.php");
include_once("../includes/data.php");
$data = new Data;

$CLIENT_ID = "811519910005-mgi1lgkvpjfr7mk2gbqmh7i10e49sckj.apps.googleusercontent.com";

$id_token = $_POST['idtoken'];

$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $user_exists = $data->googleUserExists($payload['email'], $payload['given_name'], $payload['family_name']);
    
    if ($user_exists) {
        echo "You already exist! Sign In.";
    } else {
        $email_exists = $data->emailExists($payload['email']);
        if ($email_exists) {
            echo "A user with this email already exists. Sign In to link accounts.";
        } else {
            $time = time();
            $query = $pdo->prepare("INSERT INTO user (username, firstname, lastname, roleid, status, auth_key, password_hash, password_reset_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bindValue(1, $payload['email']);
            $query->bindValue(2, $payload['given_name']);
            $query->bindValue(3, $payload['family_name']);
            $query->bindValue(4, $_POST['roleid']);
            $query->bindValue(5, 0);
            $query->bindValue(6, "verified");
            $query->bindValue(7, "google");
            $query->bindValue(8, "not set yet");
            $query->bindValue(9, $time);
            $query->bindValue(10, $time);
            $query->execute();
            
            $lastID = $pdo->lastInsertId();

            $query = $pdo->prepare("INSERT INTO email (user_id, email) VALUES (?, ?)");
            $query->bindValue(1, $lastID);
            $query->bindValue(2, $payload['email']);
            $query->execute();
            
            echo "success";
        }
    }
} else {
  // Invalid ID token
  echo "Invalid ID Token";
}

?>