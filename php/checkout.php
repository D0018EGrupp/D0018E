<?php
session_start();
include_once("navBar.php");
require("indexBackend.php");
include("loginCheck.php");

        //some thing was posted
if(isset($_SESSION['UID'])){
    $UserID = ($_SESSION["UID"]);
    

    $sql =$conn->prepare("SELECT CartID FROM Carts WHERE UID = ?");
    $sql->bind_param("s",$UserID);
    $sql->execute();
    $sql->bind_result($CartID);
    $sql->fetch();
    $sql->close();


    $sql_cartItems = "SELECT PID FROM CartItems WHERE CartID=$CartID";
    $result_cartItems = $conn->query($sql_cartItems);

    $PIDs=array();
    $PIDsPrice=array();
    $PIDsName=array();
    //Fetches items in cart and their information
    $k=0;
    if($result_cartItems->num_rows > 0) {
        while($row_cartItems = $result_cartItems->fetch_assoc()) {
            array_push($PIDs, $row_cartItems["PID"]);
            $sql_pidInfo = "SELECT Name, Price FROM Product WHERE PID=$PIDs[$k]";
            $result_pidInfo = $conn->query($sql_pidInfo);
            $row_pidInfo = $result_pidInfo->fetch_assoc();
            array_push($PIDsPrice, $row_pidInfo["Price"] );
            array_push($PIDsName, $row_pidInfo["Name"] );
            $k++;
        }
    }
    if (isset($_POST['submit'])){
        $cname = $_POST['cardname'];
        $ccnum = $_POST['cardnumber'];
        $expmonth = $_POST['expmonth'];
        $expyear = $_POST['expyear'];
        $cvv = $_POST['cvv'];

        if(!empty($cname) && !empty($ccnum) && !empty($expmonth) && !empty($expyear) && !empty($cvv)){
      
            mysqli_begin_transaction($conn);
            try{     
                $sql = "SELECT FName, Lastname, Email, Adress, City, Zipcode FROM Users WHERE UID='$UserID'"; 
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $data = mysqli_fetch_array($result);
                    $fname = $data["FName"];
                    $lname = $data["Lastname"];
                    $email = $data["Email"];
                    $address = $data["Adress"];
                    $city = $data ["City"];
                    $zipc = $data["Zipcode"];
                    
                }


                if(count($PIDs) > 0){
                    $sql = "INSERT INTO Orders (FName, Lastname, Email, Adr, City, Zipcode, UID,CartID) VALUES (?,?,?,?,?,?,?,?)";
                    $stmt= $conn->prepare($sql);
                    $stmt->bind_param('ssssssii', $fname,$lname, $email, $address, $city, $zipc, $UserID,$CartID);
                    $stmt->execute();
                    $stmt->close();
                }
            }catch(Exception $e){
                echo"Something went wrong Exception thrown try again!";
                echo $e->getMessage();
                
                $conn->rollBack();
                throw $e;
            }catch(Error $e){
                echo"Something went wrong Error: ";
                echo $e->getMessage();
                $conn->rollBack();
                throw $e;
            }

        //Update old cart with NULL UID
        $sql_cartUpdate = "UPDATE Carts SET UID=Null WHERE CartID=$CartID";
        $conn->query($sql_cartUpdate);
        $x=0;
        echo $PIDs[0];
        echo sizeof($PIDS);
        while ($PIDs[$x]!= NULL) {
          echo $PIDS[$x];
          /*$sql =$conn->prepare("SELECT Amount FROM Product WHERE PID = ?");
                $sql->bind_param("i",31);
                $sql->execute();
                $sql->bind_result($currentAmount);
                $sql->fetch();
                $sql->close();
                $newAmount = $currentAmount -1;
                
                $sql_amount = "UPDATE Product SET Amount=? WHERE PID=31";
                $stmt = mysqli_prepare($conn, $sql_amount); 
                mysqli_stmt_bind_param($stmt, "i", $newAmount);
                mysqli_stmt_execute($stmt);*/

          $item = $PIDs[$x];
          //echo $item;
          $remove = "UPDATE Product SET Amount = Amount - 1 WHERE PID = $item";
          //$conn->query($remove);
          if ($conn->query($remove) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $remove . "<br>" . $conn->error;
          }
          $x++;
          //echo " ".$x;
        }
        
        //Create a new cart for the account
        $sql_cartInsert = "INSERT INTO Carts SET UID=$UserID";
        $conn->query($sql_cartInsert);


        $conn->commit();
        header("Location: http://130.240.200.34/");
        exit;
        }
    }      

}

//echo "out" . getype($UserID);
if(isset($_POST['removeItem'])){
  $UserID = ($_SESSION["UID"]);
  $PID = $_POST['itemToRemove'];
  $sql = "DELETE FROM CartItems WHERE CartID = $CartID AND PID = $PID";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    echo '<meta http-equiv="refresh" content="0">';
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
  echo '<b> '. "$" . $totalPrice . ' </b>';
  
?>

<head><link rel="stylesheet" href="../css/checkoutStyle.css">
<div class="row">
    <div class="col-75">
      <div class="container">
        <form method ="POST" action="">
  
          <div class="row">
            <div class="col-50">
              <h3>Billing Address</h3>
              <label for="fname"><i class="fa fa-user"></i> First Name</label>
              <input type="text" id="fname" name="fname" placeholder="John">
              <label for="lname"><i class="fa fa-user"></i> Last Name</label>
              <input type="text" id="lastname" name="lastname" placeholder="M. Doe">
              <label for="email"><i class="fa fa-envelope"></i> Email</label>
              <input type="text" id="email" name="email" placeholder="john@example.com">
              <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
              <input type="text" id="adr" name="adr" placeholder="Address">
              <label for="city"><i class="fa fa-institution"></i> City</label>
              <input type="text" id="city" name="city" placeholder="New York">
  
              <div class="row">
                <div class="col-50">
                  <label for="zip">Zip</label>
                  <input type="text" id="zip" name="zip" placeholder="10001">
                </div>
              </div>
            </div>
  
            <div class="col-50">
              <h3>Payment</h3>
              <label for="fname">Accepted Cards</label>
              <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
              </div>
              <label for="cname">Name on Card</label>
              <input type="text" id="cname" name="cardname" placeholder="John More Doe">
              <label for="ccnum">Credit card number</label>
              <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
              <label for="expmonth">Exp Month</label>
              <input type="text" id="expmonth" name="expmonth" placeholder="September">
  
              <div class="row">
                <div class="col-50">
                  <label for="expyear">Exp Year</label>
                  <input type="text" id="expyear" name="expyear" placeholder="2018">
                </div>
                <div class="col-50">
                  <label for="cvv">CVV</label>
                  <input type="text" id="cvv" name="cvv" placeholder="352">
                </div>
              </div>
            </div>
  
          </div>
          <label>
            <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
          </label>
          <input class="btn" name="submit" id="button" type="submit" value="Order">
        
        </form>
      </div>
    </div>
  
    <div class="col-25">
        <div class="container">
            <h4>Cart
                <span class="price" style="color:black">
                    <i class="fa fa-shopping-cart"></i>
                    <?php 
                        echo '<b> ' . count($PIDs) . ' </b>'; 
                    ?>
                </span>
            </h4>
            <?php
            
            $totalPrice = 0;
            $x=0;
            while(count($PIDs)>$x) {  
                echo '<p><a href="#">' . $PIDsName[$x] ." ID:". $PIDs[$x].'</a> <span class="price">'.$PIDsPrice[$x] .'</span></p>';
                $x++;
                $totalPrice = $totalPrice + $PIDsPrice[$x];
            }
            ?>
            <form action="" method='post'>
              <div class="col-50">
                <label for="cvv">Enter an item's id to remove</label>
                <input type="text" id="itemToRemove" name="itemToRemove" placeholder="e.g 31">
                <input class="btn" name="removeItem" id="removeItem" type="submit" value="Remove Item">
              </div>
            </form>
            <hr>
            <p>Total 
                <span class="price" style="color:black">

                </span>
            </p>
        </div>
    </div>
</div>
</head>


             


