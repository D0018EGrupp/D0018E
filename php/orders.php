<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='../css/orders.css'>

    <title>Admin Management</title>

</head>
<body>

<?php
include_once("navBar.php");
include("indexBackend.php");
if(!isset($_SESSION['UID'])) {
    header("Location: http://130.240.200.34");
}
?>

<div class="header">
    <h2>
        Admin Management
    </h2>
    
</div>

<div id="mainBlock">
    <div class="orderAndShipping">
        <div id="orders">
            <div id="banner-customers">
                <a>Orders</a>
            </div>
            <div id="banner-attributes">
                <div class="firstAttr">
                    <p> OID</p>
                </div>
                <div class="secToSixAttr">
                    <p>PID:s</p>
                </div>
                <div class="secToSixAttr">
                    <p>Full Name</p>
                </div>
                <div class="secToSixAttr">
                    <p>Zip Code</p>
                </div>
                <div class="secToSixAttr">
                    <p>City</p>
                </div>
                <div class="secToSixAttr">
                    <p>Address</p>
                </div>
                <div class="seventhAttr">
                    <p>UID</p>
                </div>
            </div>
            <div class="user-list">
                <?php
                session_start();
                
                if(isset($_POST['submit-del'])){
                    $doid = $_POST['doid'];
                    $sql_del_orders = "SELECT CartID FROM Orders WHERE OID=$doid";
                    $result_del_orders = $conn->query($sql_del_orders);
                    
                    if(($result_del_orders->num_rows > 0) && !empty($doid)) {
                        $row_del_orders = $result_del_orders->fetch_assoc();
                        $cart_to_delete = intval($row_del_orders["CartID"]);
                        $sql = $conn->prepare("DELETE FROM Carts WHERE CartID=?");
                        $sql->bind_param('i',$cart_to_delete);
                        $sql->execute();
                    }
                }
                if(isset($_POST['submit-save'])){
                    $soid = $_POST['soid'];
                    $status = $_POST['status'];
                    if(!empty($soid)&&!empty($status)){
                        //Update the database
                        $sql = "UPDATE Orders SET Status=? WHERE OID=$soid";
                        $stmt = mysqli_prepare($conn, $sql); 
                        mysqli_stmt_bind_param($stmt, "s", $status);
                        mysqli_stmt_execute($stmt);
                    }
                }

                $sql_orders = "SELECT FName, Lastname, Adr, City, ZipCode, UID, CartID, OID, Status FROM Orders";
                $result_orders = $conn->query($sql_orders);

                $sql_cartItems = "SELECT  PID, CartID FROM CartItems";
                $result_cartItems = $conn->query($sql_cartItems);

                if($result_orders->num_rows > 0) {
                    $cartItems_CartID=array();                                                      //Creates arrays for cartId:s and PID:s
                    $cartItems_PID=array();
                    
                    while($row_orders = $result_orders->fetch_assoc()) {
                        if($result_cartItems->num_rows > 0) {
                            if($row_orders["Status"]==1){
                                $pids = "";

                                while($row_cartItems = $result_cartItems->fetch_assoc()){           //Fetches all the cartId:s and PID:s then adds them to serperate arrays
                                    array_push($cartItems_CartID, $row_cartItems["CartID"] );
                                    array_push($cartItems_PID, $row_cartItems["PID"]);                                
                                }

                                for($x=0;$x<count($cartItems_CartID);$x++){                               //Adds the correct PID to the string that is going to be printed for each order
                                    if($cartItems_CartID[$x]==$row_orders["CartID"]){
                                        //echo "cartItems cartID: " . $cartItems_CartID[$x] . "<br>";
                                        //echo "order cartID: " . $row_orders["CartID" ] . "<br>";
                                        $pids = strval($cartItems_PID[$x]) . ", " . $pids; 
                                    }
                                }
                                
                                echo '<div class="bblock">
                                        <div class="lfirstAttr">
                                            <p>'. $row_orders["OID"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. substr($pids, 0, -2) .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["FName"] . " " . $row_orders["Lastname"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["ZipCode"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["City"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["Adr"] .'</p>
                                        </div>
                                        <div class="lseventhAttr">
                                            <p>'. $row_orders["UID"] .'</p>
                                        </div>
                                        
                                    </div>';
                            }
                            $i++;
                        }
                    }
                }

                ?>
            </div>
        </div>

        <div id="shipping">
            <div id="banner-customers">
                <a>Shipped Orders</a>
            </div>
            <div id="banner-attributes">
                <div class="firstAttr">
                    <p> OID</p>
                </div>
                <div class="secToSixAttr">
                    <p>PID:s</p>
                </div>
                <div class="secToSixAttr">
                    <p>Full Name</p>
                </div>
                <div class="secToSixAttr">
                    <p>Zip Code</p>
                </div>
                <div class="secToSixAttr">
                    <p>City</p>
                </div>
                <div class="secToSixAttr">
                    <p>Address</p>
                </div>
                <div class="seventhAttr">
                    <p>UID</p>
                </div>
            </div>
            <div class="user-list">
                <?php

                $sql_orders = "SELECT FName, Lastname, Adr, City, ZipCode, UID, CartID, OID, Status FROM Orders";
                $result_orders = $conn->query($sql_orders);

                if($result_orders->num_rows > 0) {
                    //$cartItems_CartID=array();                                                      //Creates arrays for cartId:s and PID:s
                    //$cartItems_PID=array();
                    while($row_orders = $result_orders->fetch_assoc()) {
                        
                        if($result_cartItems->num_rows > 0) {
                            if($row_orders["Status"]==2){
                                $pids = "";
                                
                                while($row_cartItems = $result_cartItems->fetch_assoc()){           //Fetches all the cartId:s and PID:s then adds them to serperate arrays
                                    array_push($cartItems_CartID, $row_cartItems["CartID"] );
                                    array_push($cartItems_PID, $row_cartItems["PID"]);                                
                                }

                                for($x=0;$x<count($cartItems_CartID);$x++){                               //Adds the correct PID to the string that is going to be printed for each order
                                    if($cartItems_CartID[$x]==$row_orders["CartID"]){
                                        //echo "cartItems cartID: " . $cartItems_CartID[$x] . "<br>";
                                        //echo "order cartID: " . $row_orders["CartID" ] . "<br>";
                                        $pids = strval($cartItems_PID[$x]) . ", " . $pids; 
                                    }
                                }
                                
                                echo '<div class="bblock">
                                        <div class="lfirstAttr">
                                            <p>'. $row_orders["OID"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. substr($pids, 0, -2) .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["FName"] . " " . $row_orders["Lastname"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["ZipCode"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["City"] .'</p>
                                        </div>
                                        <div class="lsecToSixAttr">
                                            <p>'. $row_orders["Adr"] .'</p>
                                        </div>
                                        <div class="lseventhAttr">
                                            <p>'. $row_orders["UID"] .'</p>
                                        </div>
                                        
                                    </div>';
                            }
                            $i++;
                        }
                    }
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <div class="deleteCustomer">
        <div id="bannerDeleteCustomer">
            <a>Change Order Status <br> | 1 = Ordered | 2 = Shipped |</a>
        </div>
        <form action="orders.php" method="post">
            <div class="dcform">
                <div class="sUidBanner">
                    <p>OID:</p>
                </div>
                <div class="permInput">
                    <input type="text" id="soid" name="soid"><br>
                </div>

                <div class="permBanner">
                    <p>Status:</p>
                </div>
                <div class="permInput">
                    <input type="text" id="status" name="status"><br>
                </div>

                <div class="sbutton">
                    <input type="submit" name="submit-save" value="Save">
                </div>
            </div> 
        </form>
    </div>

    <div class="deleteCustomer">
        <div id="bannerDeleteCustomer">
            <a>Delete Order</a>
        </div>
        <form action="orders.php" method="post">
            <div class="dcform">
                <div class="uidBanner">
                    <p>OID:</p>
                </div>
                <div class="uidInput">
                    <input type="text" id="doid" name="doid"><br>
                </div>
                <div class="dbutton">
                    <input type="submit" name="submit-del" value="Delete">
                </div>
            </div> 
        </form>
    </div>

    <a id="oButton" href="admin.php">
        <button> Permissions </button>
    </a>
</div>

</body>
</html>
