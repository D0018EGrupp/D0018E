<?php

?>


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

            <input class="signup" name="submit" id="button" type="submit" value="Sign Up">
            
        </form>

     </div>

</body>
</html> 

<?php
//include_once("navBar.php");
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
            $Role = 1;
            //save to database
            $query = $conn->prepare("INSERT INTO Users (FName, Lastname, Email, Phonenumber, Password_1, Role, username) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $query->bind_param("sssssis",$fname, $lastname, $email, $phonenumber, $password, $Role, $username);
            $query->execute();
            $query->close();
           

            $sql_uid = $conn->prepare("SELECT UID FROM Users WHERE username=?");
            $sql_uid->bind_param("s",$username);
            $sql_uid->execute();
            $sql_uid->bind_result($UserID);
            $sql_uid->fetch();
            $sql_uid->close();

            

            $sql_cartInsert = "INSERT INTO Carts SET UID=$UserID";
            $conn->query($sql_cartInsert);
            
            header("Location: login.php",);
            die;
        }

        else{
            echo "please enter valid information";
    
        }
}
   
?>