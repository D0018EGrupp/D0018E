
<?php 
$servername = "phpmyadmin";
$username = "Martinis";
$password = "";
$dbName = "d0018e";

if(!$conn = mysqli_connect($servername, $username, $password, $dbName)){

    die("failed to connect!". mysqli_connect_error());
}
