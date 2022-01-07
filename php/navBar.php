<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='../css/navBar.css'>

    <title>Navigation Bar</title>

</head>
<body>

<?php
session_start();
?>
<div class="navBar">
    <div class="dropDownMenu">
        <?php if(isset($_SESSION['UID'])) : ?>
            <a href="../php/profile.php">
                <img class="smallProfile" src="../img/profile.png" style="width: 40px;">
            </a>
        <?php else : ?>
            <a href="../php/login.php">
                <img class="smallProfile" src="../img/profile.png" style="width: 40px;">
            </a>
        <?php endif; ?>
        <div class="dropdownContent">
        <?php if(isset($_SESSION['UID'])) : ?>
            <form method = "POST" action="..">
                <input class="button" name="logout" id="logout" type="submit" value="Logout">
            </form>
            <a href="../php/profile.php">
                <button> profile </button>
            </a> 
        <?php else : ?>
            <a href="../php/login.php">
                <button> Login </button>
            </a> 
        <?php endif; ?>
        <?php if(isset($_SESSION['UID'])) : ?>
            <?php if($_SESSION['Role']==3) : ?>
                <a href="../php/admin.php">
                    <button> Admin </button>
                </a>
            <?php endif; ?>
            <?php if($_SESSION['Role']==2) : ?>
                <a href="../php/productManager.php">
                    <button> Manager </button>
                </a>
            <?php endif; ?>
        <?php endif; ?>
        </div>
    </div>
    <a href="../php/checkout.php">
        <img class="smallProfile" src="../img/cart.png" style="width: 40px;">
    </a>
    <a href="..">
        <img class="smallProfile" src="../img/home.png" style="width: 45px;">
    </a>
    <div id="shopBanner">
    <img class="shopBanner" src="../img/fastlogo.png" style="width: 160px;">
        <a></a>
    </div>
    
    <div class="loggedin" type="text"> 
        <?php

        if(isset($_SESSION['UID'])) {
            echo '<a>Welcome '. $_SESSION['username'] . ' </a>' ;
            print_r(); 
        }else {
            echo '<a>Not logged in </a>';
        } 
        ?>
    </div>
</div>

</body>
</html>
<?php

if(isset($_POST['logout'])){
  unset($_SESSION["UID"]);
  unset($_SESSION["username"]);
  unset($_SESSION["Role"]);
  echo '<meta http-equiv="refresh" content="0">';

}

?>