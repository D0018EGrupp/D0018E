<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='../css/Profile.css'>

    <title>User Information</title>

</head>
<body>

<?php
include_once("navBar.php");
include("indexBackend.php");

session_start();

if(!isset($_SESSION['UID'])) {
    header("Location: http://130.240.200.34");
}

$user = $_SESSION["UID"];
if(isset($_POST['submit'])){
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST ['city'];
    $mphone = $_POST['mphone'];
    $passw = $_POST['passw'];
    $zipc = $_POST['zipc'];
    /*$username = $_POST["username"];*/

    if(!empty($fname) && !empty($lname) && !empty($email)  && !empty($passw)){
        //Update the database
        //$id------Hård kodad BOB ID----------------------------------
        $sql = "UPDATE Users SET FName=?, Lastname=?, Email=?, Adress=?, City=?, Phonenumber=?, Password_1=?, Zipcode=? WHERE UID=$user";
        $stmt = mysqli_prepare($conn, $sql); 
        mysqli_stmt_bind_param($stmt, "ssssssss", $fname, $lname, $email, $address, $city, $mphone, $passw, $zipc);
        mysqli_stmt_execute($stmt);
    }
}

$sql = "SELECT FName, Lastname, Email, Adress, City, Phonenumber, Password_1, Zipcode, username FROM Users WHERE UID=$user"; //$id ------------------------------
$result = $conn->query($sql);
if($result->num_rows > 0){
    $data = mysqli_fetch_array($result);
    
    $fname = $data["FName"];
    $lname = $data["Lastname"];
    $email = $data["Email"];
    $address = $data["Adress"];
    $city = $data ["City"];
    $mphone = $data["Phonenumber"];
    $passw = $data["Password_1"];
    $zipc = $data["Zipcode"];
    $username = $data["username"];

}

$conn->close();
?>


<img class="profile" src="../img/profile.png" style="width:200px; height: 200px;;">

<div class="header">
    <h2>
        <?php echo $username ?> Information
    </h2>
</div>

<p>Here you can edit your account information.</p>

<form action="profile.php" method="post">
    <div id="flex">
    <div class="inputContainer">
        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="fname" value="<?php echo $fname ?>"><br>
    </div>

    <div class="inputContainer">
        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" name="lname" value="<?php echo $lname ?>"><br>
    </div>

    <div class="inputContainer">
        <label for="email">E-mail:</label><br>
        <input type="text" id="email" name="email" value="<?php echo $email ?>"><br>
    </div>

    <div class="inputContainer">
        <label for="passw">Password:</label><br>
        <input type="password" id="passw" name="passw" value="<?php echo $passw ?>"><br>
    </div>

    <div class="inputContainer">
        <label for="address">address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo $address ?>"><br>
    </div>

    <div class="inputContainer">
        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" value="<?php echo $city ?>"><br>
    </div>

    <div class="inputContainer">
        <label for="zipc">Zip code:</label><br>
        <input type="text" id="zipc" name="zipc" value="<?php echo $zipc ?>"><br>
    </div>

    <div class="inputContainer">
        <label for="mphone">Mobilephone number:</label><br>
        <input type="text" id="mphone" name="mphone" value="<?php echo $mphone ?>"><br>
    </div>
</div>

    <div class="submitButton">
        <input type="submit" name="submit" value="Save">
    </div>
    
</form>

</body>
</html>




