<?php
session_start();
include("connection.php");
include("functions.php");
    //some thing was posted
    if($_SERVER['REQUEST_METHHOD'] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    

        if(!empty($username) && !empty($password)){

            //read from database
            $query = "select * from Users where Username = '$username' limit 1";
            $result = mysqli_query($con, $query);

            if($result){
                if($result && mysqli_num_rows($result) > 0){
                    $user_data = mysqli_fetch_assoc($result);
                    
                    if($user_data['password'] === $password){

                        $_SESSION['UID'] = $user_data['UID'];
                        header("Location: index.php");
                        die;

                    }
            }

            header("Location: index.php");
            die;
        }

        else{
            echo "Wrong username or password";


        }
}   }

?>
<!DOCTYPE html>

<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="../css/loginStyle.css">
    <link rel="stylesheet" type="text/css" href="../html/login.html">        
</head>
<body>
    <div class="loginform">
        <h1> <img src="../img/profile.png" style="width:250px; height: 250px;;"></h1>
        <form action="#" method="post">
            <p>UserName:</p>
            <input type="username" name="username" placeholder="Username" required>
            <p>Password:</p>
            <input type="password" name="password" placeholder="Password" required>

        </form>
        <form method="get" action="../../D0018E/index.html">
            <button type="submit">Login</button>
        </form>

        <form method="get" action="../html/register.html">
            <button type="submit">Register</button>
        </form>
        
    </div>
</body>
</html>