<?php
session_start();
    include("connection.php");
    include("functions.php");
        //some thing was posted
    if($_SERVER['REQUEST_METHHOD'] == "POST"){
       $name = $_POST['name'];
       $lastname = $_POST['lastname'];
       $username = $_POST['username'];
       $email = $_POST['email'];
       $password = $_POST['password'];
       $phonenumber = $_POST['phonenumber'];

        if(!empty($name) && !empty($lastname) && !empty($username) && !empty($email)  && !empty($password)){

            //save to database
            $UID = random_num(50);
            $query = "insert into users (Name,Lastname,Email,Adress,Phonenumber,Password,Zipcode) values ('$Name','$Lastname','$Email','$Phonenumber','$Password')";
            mysqli_query($con, $query);

            header("Location: login.php");
            die;
        }

        else{
            echo "please enter valid information";
    
        }
    }
?>

<!DOCTYPE html>

<html>

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="../css/registrationStyle.css">        
</head>
<body>
    <div class="registration-form">
        <h1> <img src="../img/profile.png" style="width:200px; height: 200px;;"></h1>
        <form action="register.php" method="post">
            <p>Name:</p>
            <input type="text" name="name" placeholder="Firstname" required >
            <p>Lastname:</p>
            <input type="text" name="lastname" placeholder="Lastname" required >
            <p>User Name:</p>
            <input type="text" name="username" placeholder="User Name" required>
            <p>Email:</p>
            <input type="email" name="email" placeholder="Email Address" required>
            <p>Password:</p>
            <input type="password" name="password" placeholder="Password" required>
            <p>PhoneNumber:</p>
            <input type="text" name="phonenumber" placeholder="Phone Number Optional">
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>