<?php
require_once('../../../assets/api/google-php/vendor/autoload.php');

session_start();

$client = new Google_Client();
$client->setAuthConfig('client_secret_811519910005-mgi1lgkvpjfr7mk2gbqmh7i10e49sckj.apps.googleusercontent.com.json');
$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/apps/numberplayground/test/google/classroom/test2.php');
$client->addScope(Google_Service_Classroom::CLASSROOM_COURSES_READONLY);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/apps/numberplayground/test/google/classroom/test.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}