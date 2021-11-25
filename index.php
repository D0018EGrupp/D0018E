<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Product1</a>
        <a href="#">Product2</a>
        <a href="#">Product3</a>
        <a href="#">Product4</a>
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
    <a href="./html/checkout.html"><img src="img/cart.png" href="/html/checkout.html" style="width: 3%; float: right; padding: 10px;"></a>
    <a href="./php/login.php"><img src="img/profile.png" href="/php/login.php" style="width: 2.5%; float: right; margin-top: 6px;"></a>
</div>
<?php
include("./php/indexBackend.php");
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<div class="card">
    <img src="productImg/placeholder.png" style="width:100%">
    <h1>'.$row["Name"].'</h1>
    <p class="price">$'.$row["Price"].'</p>
    <p>'.$row["Description"].'</p>
    <p><button>Add to Cart</button></p>
    </div>';
  }
}
$conn->close();
?>
</body>
</html>