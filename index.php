<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>


<body>
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
            <a href="php/profile.php">
                <button> profile </button>
            </a> 
        <?php else : ?>
            <a href="/php/login.php">
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
<div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php?phpvar=All Products">All Products</a>
        <?php   
            
            include("./php/indexBackend.php");
            $v = "SELECT Category FROM Product GROUP BY Category";
            $result = $conn->query($v);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo'
                  <a href="index.php?phpvar='.$row["Category"].'">'.$row["Category"].'</a>
                  ';
                  array_push($alreadyPosted,$row["Category"]);
              }
            }
            $conn->close();?>
      </div>
<span style="font-size:30px;cursor:pointer;position: absolute;" onclick="openNav()">&#9776; Products</span>
<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "300px";
    }
    
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
</script>
<?php
session_start();
include("./php/indexBackend.php");
$var=$_GET['phpvar'];
if($var == "All Products" ||  $var == NULL){
  $v = "SELECT * FROM Product";
}
else{
  $v = "SELECT * FROM Product WHERE Category='$var'";
}
$result = $conn->query($v);
if ($result->num_rows > 0) {
  $i = 0;
  while($row = $result->fetch_assoc()) {
    if($row["Rating"]==NULL){
        $rating = 0;
    }
    else{
        $rating = $row["Rating"];
    }
    echo '<div class="card">
    <img src="'.$row["ImgSrc"].'" style="width:100%">
    <h1>'.$row["Name"].'</h1>
    <p class="price">$'.$row["Price"].'</p>
    <p>'.$row["Description"].'</p>
    <br>
    <p>'.$rating.'/10</p>
    <script>
    function visitPage'.$i.'(){
        window.location="/productPages/'.$row["Name"].'.php";
    }
    </script>
    <p><button onclick="visitPage'.$i.'();">Add to Cart</button></p>
    </div>';
    $i++;
  }
}
$conn->close();
?>
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