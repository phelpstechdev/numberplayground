<?php
require_once("../../assets/api/google-php/vendor/autoload.php");

$CLIENT_ID = "811519910005-mgi1lgkvpjfr7mk2gbqmh7i10e49sckj.apps.googleusercontent.com";

$id_token = $_POST['idtoken'];

$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
  $userid = $payload['sub'];
  print_r($payload);
} else {
  // Invalid ID token
  echo "Invalid ID Token";
}

?>