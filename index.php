
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php?phpvar=All Products">All Products</a>
        <?php   

            include("./php/indexBackend.php");
            $v = "SELECT Category FROM Product";
            $result = $conn->query($v);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo'
                <a href="index.php?phpvar='.$row["Category"].'">'.$row["Category"].'</a>
                ';
              }
            }
            $conn->close();
            
?>
      </div>
<span style="font-size:30px;cursor:pointer;position: absolute;" onclick="openNav()">&#9776; Products</span>
<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }
    
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
</script>
<div class="myTopLink">
    <a href="./php/checkout.php"><img src="img/cart.png" href="/php/checkout.php" style="width: 3%; float: right; padding: 10px;"></a>
    <a href="./php/login.php"><img src="img/profile.png" href="/php/login.php" style="width: 2.5%; float: right; margin-top: 6px;"></a>
    <form method="POST" >
      <div class="logout">
      <input class="button" name="logout" id="logout" type="submit" value="Logout">
      </div>
    </form>
</div>

<?php
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
  while($row = $result->fetch_assoc()) {

    echo '<div class="card">
    <img src="'.$row["ImgSrc"].'" style="width:100%">
    <h1>'.$row["Name"].'</h1>
    <p class="price">$'.$row["Price"].'</p>
    <p>'.$row["Description"].'</p>
    <script>
    function visitPage(){
        window.location="/productPages/'.$row["Name"].'.php";
    }
    </script>
    <p><button onclick="visitPage();">Add to Cart</button></p>
    </div>';
  }
}
$conn->close();
?>
</body>
</html>

<?php
session_start();

if(isset($_SESSION['UID'])){
  echo"Welcome","\r\n" ;
  print_r($_SESSION['username']); 
}else{
  echo"Not logged in";
}

?>

<?php
session_start();
if(isset($_POST['logout'])){
  unset($_SESSION["UID"]);
  unset($_SESSION["username"]);

  header("Location: http://130.240.200.34/");

}
?>