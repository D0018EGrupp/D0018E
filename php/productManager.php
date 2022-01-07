<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='../css/admin.css'>

    <title>Product Management</title>

</head>
<body>

<?php
include_once("navBar.php");
include("indexBackend.php");
session_start();
if(isset($_SESSION['UID'])) {
    if($_SESSION['Role']!=2){
        header("Location: http://130.240.200.34");
    }
}else {
    header("Location: http://130.240.200.34");
}
?>

<div class="header">
    <h2>
        Product Management
    </h2>
</div>

<div id="flex-2">
    <div id="banner-customers">
        <a>Customer accounts</a>
    </div>
    <div id="banner-attributes">
        <div class="smallbl">
            <p>PID</p>
        </div>
        <div class="smallb">
            <p>Product Name</p>
        </div>
        <div class="smallb">
            <p>Price</p>
        </div>
        <div class="smallbr">
            <p>In Stock</p>
        </div>
    </div>
    <div class="user-list">
        <?php

        if(isset($_POST['submit-deletion'])){
            $pid = $_POST['pid'];
            if(!empty($pid)){
                //Update the database
                $sql = "DELETE FROM Product WHERE PID=?";
                $stmt = mysqli_prepare($conn, $sql); 
                mysqli_stmt_bind_param($stmt, "i", $pid);
                mysqli_stmt_execute($stmt);
            }
        }
        if(isset($_POST['submit-save'])){
            $amount = $_POST['amount'];
            $pid = $_POST['pid'];
            if(!empty($amount)&&!empty($pid)){

                $sql =$conn->prepare("SELECT Amount FROM Product WHERE PID = ?");
                $sql->bind_param("s",$pid);
                $sql->execute();
                $sql->bind_result($currAmount);
                $sql->fetch();
                $sql->close();
                $newAmount = $currAmount + $amount;
                
                $sql_amount = "UPDATE Product SET Amount=? WHERE PID=$pid";
                $stmt = mysqli_prepare($conn, $sql_amount); 
                mysqli_stmt_bind_param($stmt, "i", $newAmount);
                mysqli_stmt_execute($stmt);
            }
        }

        $sql = "SELECT Name, PID, Amount, Price FROM Product";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="bblock">
                        <div class="lsmallbl">
                            <p>'. $row["PID"] . '</p>
                        </div>
                        <div class="lsmallb">
                            <p>'. $row["Name"] . '</p>
                        </div>
                        <div class="lsmallb">
                            <p>'. "$" . $row["Price"] .'</p>
                        </div>
                        <div class="lsmallbr">
                            <p>'. $row["Amount"] .'</p>
                        </div>
                        
                    </div>';
            }
        }

        $conn->close();
        ?>
    </div>
    <div class="deleteCustomer">
        <div id="bannerDeleteCustomer">
            <a>Change Stock</a>
        </div>
        <form action="productManager.php" method="post">
            <div class="dcform">
                <div class="sUidBanner">
                    <p>PID:</p>
                </div>
                <div class="permInput">
                    <input type="text" id="uid" name="pid"><br>
                </div>

                <div class="permBanner">
                    <p>Amount:</p>
                </div>
                <div class="permInput">
                    <input type="text" id="role" name="amount"><br>
                </div>

                <div class="sbutton">
                    <input type="submit" name="submit-save" value="Save">
                </div>
            </div> 
        </form>
    </div>

    <div class="deleteCustomer">
        <div id="bannerDeleteCustomer">
            <a>Delete Product</a>
        </div>
        <form action="productManager.php" method="post">
            <div class="dcform">
                <div class="uidBanner">
                    <p>PID:</p>
                </div>
                <div class="uidInput">
                    <input type="text" id="uid" name="pid"><br>
                </div>
                <div class="dbutton">
                    <input type="submit" name="submit-deletion" value="Delete">
                </div>
            </div> 
        </form>
    </div>
    
    <a id="oButton" href="../html/productUpload.php">
        <button> Upload Product </button>
    </a>

</div>

</body>
</html>
