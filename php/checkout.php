<?php
session_start();
require("indexBackend.php");
include("functions.php");
        //some thing was posted
if(isset($_SESSION['UID'])){
            echo"User","\r\n" ;
            print_r($_SESSION['username']);
            $UserID = ($_SESSION["UID"]);
      if (isset($_POST['submit'])){
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
                  $ProductName = "Santa Hat";
                
                if(!empty($fname) && !empty($lname) && !empty($email) && !empty($address)  && !empty($city)&& !empty($zipc)){
                    $sql ="SELECT PID FROM Product WHERE Name = '$ProductName'";
                    $result = $conn->query($sql);
                      if($result->num_rows > 0){
                        $data = mysqli_fetch_array($result);
                        $PID = $data["PID"];
                        
                      }
                      if($PID > 0){
                        echo"$UserID";
                        $sql = "INSERT INTO Orders (FName, Lastname, Email, Adr, City, Zipcode, PID, UID) VALUES (?,?,?,?,?,?,?,?)";
                        $stmt= $conn->prepare($sql);
                        $stmt->bind_param('ssssssss', $fname,$lname, $email, $address, $city, $zipc, $PID, $UserID);
                        $stmt->execute();
                        $stmt->close();
                        
                  
                      }
                   


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
                $conn->commit();
                header("Location: http://130.240.200.34/");
                exit;
        }      

            
          
               
          
    
    

}else{
  if (isset($_POST['submit'])){
    $fname = $_POST['fname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $adr = $_POST['adr'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $cname = $_POST['cname'];
    $ccname = $_POST['ccname'];
    $expyear = $_POST['expyear'];
    $cvv = $_POST['cvv'];
    $ProductName = "Santa Hat";
      //&& !empty($cname) && !empty($ccname) && !empty($expyear) && !empty($cvv) ifall man vill testa enkelt ta bort från övre if
    
    if(!empty($fname) && !empty($lastname) && !empty($email) && !empty($adr)  && !empty($city)&& !empty($zip) && !empty($cname) && !empty($ccname) && !empty($expyear) && !empty($cvv)){
        mysqli_begin_transaction($conn);
        try{
        $query =$conn->prepare("SELECT PID FROM Product WHERE Name = ?");
        $query->bind_param("s",$ProductName);
        $query->execute();
        $query->bind_result($PID);
        $query->fetch();
        $query->close();
    
         $query = $conn->prepare("INSERT INTO Orders (FName, Lastname, Email, Adr, City, Zipcode,PID) VALUES (?, ?, ?, ?, ?, ?, ?)");
         $query->bind_param("ssssssi",$fname, $lastname, $email, $adr, $city, $zip, $PID);
         $query->execute();
         $query->close();

         
      
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

      $conn->commit();
      header("Location: http://130.240.200.34/");
      exit;
    }

  else{
        echo "Please enter in valid infromation";

    }
}
 
 } 



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
            <b>4</b>
          </span>
        </h4>
        <p><a href="#">Product 1</a> <span class="price">$15</span></p>
        <p><a href="#">Product 2</a> <span class="price">$5</span></p>
        <p><a href="#">Product 3</a> <span class="price">$8</span></p>
        <p><a href="#">Product 4</a> <span class="price">$2</span></p>
        <hr>
        <p>Total <span class="price" style="color:black"><b>$30</b></span></p>
      </div>
    </div>
  </div>
</head>
