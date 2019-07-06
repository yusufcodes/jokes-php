<?php 
// DatabaseConnection.php: Allows for the connection to the ijdb database to be established
$pdo = new PDO('mysql:host=localhost; dbname=ijdb; charset=utf8', 'ijdbuser', 'mypassword');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>