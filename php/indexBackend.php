<?php 
$servername = "localhost";
$username = "phpmyadmin";
$password = "Martinis";
$dbName = "Website";

$conn = new mysqli($servername, $username, $password, $dbName);

$v = "SELECT * FROM Product";
$result = $conn->query($v);


?>