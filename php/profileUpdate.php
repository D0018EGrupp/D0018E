<?php
session_start();
include("indexBackend.php");
include("functions.php");

$fname = $_POST("fname");

$sql = "UPDATE Users SET FName = $fname WHERE UID='5'"; //$id
if(mysql_query($sql)){ echo "updated";} else{ echo "fail";}

$conn->close();
?>