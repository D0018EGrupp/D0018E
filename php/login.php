<?php
session_start();
require("indexBackend.php");
include("functions.php");
    //some thing was posted
    if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
        
    
        if(!empty($username) && !empty($password)){
            //read from database
            $query =$conn->prepare("SELECT UID FROM Users WHERE username = ? AND Password_1 = ?");
            $query->bind_param("ss",$username, $password);
            $query->execute();
            $query->bind_result($UID);
            $query->fetch();
            $query->close();
           
            if(isset($UID)){
                $_SESSION["username"]= $username;
                $_SESSION["UID"] = $UID;
    

                header("Location: http://130.240.200.34/");
            }else {
                $error = "Your Login Name or Password is invalid";
                echo"$error";
             }
             
            
            
            
        

        }

        
        
        

     }
  
?>
<!DOCTYPE html>

<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="../css/loginStyle.css">
    <link rel="stylesheet" type="text/css" href="../php/login.php">        
</head>
<body>
    <div class="loginform">
        <h1> <img src="../img/profile.png" style="width:250px; height: 250px;;"></h1>
        <form action="#" method="POST">
            <label>Username:</label>
            <input type="username" id="username" name="username" placeholder="Username" required>
            <label >Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <button type="submit" name="submit">Login</button>
           
        </form>

        <form method="get" action="../php/register.php">
            <button type="submit">Register</button>
        </form>
        
    </div>
</body>
</html>