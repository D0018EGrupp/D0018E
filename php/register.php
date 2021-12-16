

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registration Form</title>  
        <link rel="stylesheet" type="text/css" href="../css/registrationStyle.css">      
    </head>

<body>
    <div class ="registration-form">
        <h1> <img src="../img/profile.png" style="width:200px; height: 200px;"></h1>
        <form method = "POST" action="">
            <input id="text" type="text" name="fname" placeholder="Firstname" required>
            <input id="text" type="text" name="lastname" placeholder="Lastname" required>
            <input id="text" type="text" name="username" placeholder="User Name" required>
            <input id="text" type="email" name="email" placeholder="Email Address" required>
            <input id="text" type="password" name="password" placeholder="Password" required>
            <input id="text" type="text" name="phonenumber" placeholder="Phone Number Optional">

            <input class="button" name="submit" id="button" type="submit" value="Sign Up">
            
        </form>

     </div>


    
</body>
</html> 




<?php
session_start();
require("indexBackend.php");
include("functions.php");
        //some thing was posted
    
    if (isset($_POST['submit'])){
        $fname = $_POST['fname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phonenumber = $_POST['phonenumber'];
        $username = $_POST['username'];
    
        if(!empty($fname) && !empty($lastname) && !empty($username) && !empty($email)  && !empty($password)){
            //save to database
            $query = $conn->prepare("INSERT INTO Users (FName, Lastname, Email, Phonenumber, Password_1, username) VALUES (?, ?, ?, ?, ?, ?)");
            $query->bind_param("ssssss",$fname, $lastname, $email, $phonenumber, $password, $username);
            $query->execute();
            $query->close();

            header("Location: login.php",);
            die;
        }

        else{
            echo "please enter valid information";
    
        }
}
   
?>