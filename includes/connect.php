<?php
// Connect to Database

try {
	$pdo = new PDO('mysql:host=localhost;dbname=numberplayground', 'phelpstech', 'Sw0rd0ftruth@');
} catch (PDOException $e) {
	exit('Database error.');
}

?>
