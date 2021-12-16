<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='../css/admin.css'>

    <title>Admin Management</title>

</head>
<body>



<h1>
    <a href="../php/profile.php">
        <img class="smallProfile" src="../img/profile.png" style="width: 2.5%;">
    </a>

    <a href="..">
        <img class="smallProfile" src="../img/home.png" style="width: 2.75%;">
    </a>

    <a href="../html/checkout.html">
        <img class="smallProfile" src="../img/cart.png">
    </a>
</h1>

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
        session_start();
        include("indexBackend.php");
        include("functions.php");

        if(isset($_POST['submit'])){
            $uid = $_POST['uid'];
            if(!empty($uid)){
                //Update the database
                $sql = "DELETE FROM Users WHERE UID=?";
                $stmt = mysqli_prepare($conn, $sql); 
                mysqli_stmt_bind_param($stmt, "s", $uid);
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
                            <p>'. $row[UID] . " - " . $row["username"] .'</p>
                        </div>
                        <div class="lsmallb">
                            <p>'. $row["FName"] . " " . $row[Lastname] .'</p>
                        </div>
                        <div class="lsmallb">
                            <p>'. $row["Email"] .'</p>
                        </div>
                        <form action="admin.php" method="post">
                            <div class="sform">
                                <div class="lsmallbr">
                                    <input type="text" id="role" name="role" value="'.$role.'"><br>
                                </div>
                                <div class="sbutton">
                                    <input type="submit" name="submit" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>';
            }
        }

        $conn->close();
        ?>
    </div>
    <!--<div class="sbutton">
        <button type="button">Save</button>
    </div>-->
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
                    <input type="submit" name="submit" value="Delete">
                </div>
            </div> 
        </form>
    </div>
</div>
</body>
</html>
