<?php
ini_set("include_path", '/home/goleuwupz58z/php:' . ini_get("include_path") );
require_once("Mail.php");

$from = "wmpaulphelps@gmail.com";
$to = 'williampaul@phelpsfamily.org';

$host = "ssl://smtp.gmail.com";
$port = "465";
$username = 'wmpaulphelps@gmail.com';
$password = 'My name is William Phelps and I am a web developer.';

$subject = "test";
$body = "test";

$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp',
array ('host' => $host,
'port' => $port,
'auth' => true,
'username' => $username,
'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
echo($mail->getMessage());
} else {
echo("Message successfully sent!\n");
}
?>
