<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='../css/admin.css'>

    <title>Admin Management</title>

</head>
<body>

<?php
include_once("navBar.php");
include("indexBackend.php");
session_start();
if(isset($_SESSION['UID'])) {
    if($_SESSION['Role']!=3){
        header("Location: http://130.240.200.34");
    }
}else {
    header("Location: http://130.240.200.34");
}
?>

<div class="header">
    <h2>
        Admin Management
    </h2>
</div>

<div id="flex-2">
    <div id="banner-customers">
        <a>Customer accounts</a>
    </div>
    <div id="banner-attributes">
        <div class="smallbl">
            <p> UID & Username</p>
        </div>
        <div class="smallb">
            <p>Full Name</p>
        </div>
        <div class="smallb">
            <p>E-mail</p>
        </div>
        <div class="smallbr">
            <p>Permission Level</p>
        </div>
    </div>
    <div class="user-list">
        <?php

        if(isset($_POST['submit-deletion'])){
            $uid = $_POST['uid'];
            if(!empty($uid)){
                //Update the database
                $sql = "DELETE FROM Carts WHERE UID=?";
                $stmt = mysqli_prepare($conn, $sql); 
                mysqli_stmt_bind_param($stmt, "s", $uid);
                mysqli_stmt_execute($stmt);

                $sql = "DELETE FROM Users WHERE UID=?";
                $stmt = mysqli_prepare($conn, $sql); 
                mysqli_stmt_bind_param($stmt, "s", $uid);
                mysqli_stmt_execute($stmt);
            }
        }
        if(isset($_POST['submit-save'])){
            $role = $_POST['role'];
            $uid = $_POST['uid'];
            if(!empty($role)&&!empty($uid)){
                //Update the database
                $sql = "UPDATE Users SET Role=? WHERE UID=$uid";
                $stmt = mysqli_prepare($conn, $sql); 
                mysqli_stmt_bind_param($stmt, "s", $role);
                mysqli_stmt_execute($stmt);
            }
        }

        $sql = "SELECT FName, Lastname, Email, Role, Password_1, username, UID FROM Users";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $role = $row["Role"];
                echo '<div class="bblock">
                        <div class="lsmallbl">
                            <p>'. $row["UID"] . " - " . $row["username"] .'</p>
                        </div>
                        <div class="lsmallb">
                            <p>'. $row["FName"] . " " . $row["Lastname"] .'</p>
                        </div>
                        <div class="lsmallb">
                            <p>'. $row["Email"] .'</p>
                        </div>
                        <div class="lsmallbr">
                            <p>'. $row["Role"] .'</p>
                        </div>
                        
                    </div>';
            }
        }

        $conn->close();
        ?>
    </div>
    <div class="deleteCustomer">
        <div id="bannerDeleteCustomer">
            <a>Change Permission</a>
        </div>
        <form action="admin.php" method="post">
            <div class="dcform">
                <div class="sUidBanner">
                    <p>UID:</p>
                </div>
                <div class="permInput">
                    <input type="text" id="uid" name="uid"><br>
                </div>

                <div class="permBanner">
                    <p>Permisson:</p>
                </div>
                <div class="permInput">
                    <input type="text" id="role" name="role"><br>
                </div>

                <div class="sbutton">
                    <input type="submit" name="submit-save" value="Save">
                </div>
            </div> 
        </form>
    </div>

    <div class="deleteCustomer">
        <div id="bannerDeleteCustomer">
            <a>Delete Customer</a>
        </div>
        <form action="admin.php" method="post">
            <div class="dcform">
                <div class="uidBanner">
                    <p>UID:</p>
                </div>
                <div class="uidInput">
                    <input type="text" id="uid" name="uid"><br>
                </div>
                <div class="dbutton">
                    <input type="submit" name="submit-deletion" value="Delete">
                </div>
            </div> 
        </form>
    </div>
    
    <a id="oButton" href="orders.php">
        <button> Orders </button>
    </a>

</div>

</body>
</html>
