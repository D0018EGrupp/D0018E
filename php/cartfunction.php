<?php
session_start();
include_once("navBar.php");
require("indexBackend.php");

$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$array = str_split($url);

$i = 0;
$continue = 0;
$bool = true;
$str = "";
foreach ($array as $char) {
    if($char=='.'){
        $continue++;
    }
    if($i==2 && $continue != 4){
        $str=$str.$char;
    }
    if($char=='/'){
        $i++;
    }
}
$productName = str_replace("%20"," ",$str);



if(isset($_SESSION['UID'])){

    if (isset($_POST['cart-btn'])){

    $UserID = ($_SESSION["UID"]);
   
    $sql =$conn->prepare("SELECT PID FROM Product WHERE Name = ?");
        $sql->bind_param("s",$productName);
        $sql->execute();
        $sql->bind_result($PID);
        $sql->fetch();
        $sql->close();
        
    $sql =$conn->prepare("SELECT CartID FROM Carts WHERE UID = ?");
        $sql->bind_param("s",$UserID);
        $sql->execute();
        $sql->bind_result($CartID);
        $sql->fetch();
        $sql->close();
    


     $sql = $conn->prepare("INSERT INTO CartItems (CartID, PID) VALUES (?, ?)");
     $sql->bind_param("ii",$CartID ,$PID);
     $sql->execute();
     $sql->close();

     header("Location: http://130.240.200.34/");
     exit;
     

 }
}
?>
