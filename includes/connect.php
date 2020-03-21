<?php
// Connect to Database

try {
	$pdo = new PDO('mysql:host=localhost;dbname=numberplayground', 'root', '');
} catch (PDOException $e) {
	exit('Database error.');
}

?>
