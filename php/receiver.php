<?php
include_once('../php/navBar.php');
$alreadyUploaded = 0;
$target_dir = "../productImg/";
if($alreadyUploaded == 0){
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    $alreadyUploaded = 1;
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}



?>

<!DOCTYPE html>

<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="../css/productUploadStyle.css">       
</head>
<body>
    <div class="loginform">
            </form>
            <form action="" method="post">
            <?php
            echo "
            <input value='".$target_file."' type='text' name='imageName' id='imageName' placeholder='Name' required>";
            ?>
            <p>Product Name:</p>
                <input type="text" name="productName" id="productName" placeholder="Name" required>
            <p>Description of Product:</p>
                <textarea id="description" name="description" rows="4" cols="50" required>
                </textarea>
            <p>Price:</p>
                <input type="text" name="price" placeholder="Price" required>
            <p>Amount:</p>
              <input type="text" name="amount" placeholder="amount" required>
            <p>Category:</p>
                <input type="text" name="category" placeholder="Category" required>
        <div class="upload">
            <input type="submit" name="submitData" value="Submit"><br>
            <?php
            if(isset($_POST['submitData'])) { 
              echo "INSIDE ",$target_file;
                include("../php/indexBackend.php");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $target_file = $_POST['imageName'];
                echo $_POST['imageName'];
                $imageLocation = "../productImg/".$_FILES["fileToUpload"]["name"];
                $productName = $_POST['productName'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                $amount = $_POST['amount'];
                if($_POST['price']<0 || !preg_match('/^[0-9 +-]*$/', $price ) || preg_match("/[\[^\'£$%^&*()}{@:\'#~?><>,;@\|\\\-=\-_+\-¬\`\]]/",$price)){
                  echo  "<br><br><h> PLEASE ENTER VALID INPUT, You need to enter the name of the file including the extention again in the above text field. </h>";
                  $backUp = $target_file;
                }
                else{
                  echo "BACKUP IS".$backUP,$target_file;
                  echo "VALUES ".$imageLocation." ".$productName." ".$description." ".$price." ".$category;
                  $sql = $sql = "INSERT INTO `Product` (`Name`, `PID`, `Amount`, `ImgSrc`, `Price`, `Description`, `Rating`, `AmountRated`, `Category`)
                  VALUES ('$productName', NULL, '$amount', '$target_file', $price, '$description', NULL, NULL, '$category')";
                  if ($conn->query($sql) === TRUE) {
                      echo "New record created successfully";
                  } else {
                      echo "Error: " . $sql . "<br>" . $conn->error;
                  }
                  $File = $productName.".php"; 
                  $myfile = fopen("Temp", "w") or die("Unable to open file!");
                  $txt = "
                  
                  <link rel='stylesheet' href='../css/productPage.css'>
                      <main class='container'>
                      
                          <!-- Left Column / Headphones Image -->
                          <div class='left-column'>
                          <img data-image='Product' src='".$_POST['imageName']."' style='float: left;' alt=''>
                          </div>
                      
                      
                          <!-- Right Column -->
                          <div class='right-column'>
                      
                          <!-- Product Description -->
                          <div class='product-description'>
                              <h1>".$productName."</h1>
                              <p>".$description."</p>
                          </div>
                      
                          <!-- Product Configuration -->
                          <div class='product-configuration'>
                      
                          <!-- Product Pricing -->
                          <div class='product-price'>
                              <span>".$price."</span>
                              <form method = 'POST' action='$productName.php'>
                              <input class='cart-btn' name='cart-btn' id='cart-btn' type='submit' value='Add to cart'>
                              </form>
                          </div>
                          </div>
                      </main><?php include('../php/comment.php'); include('../php/cartfunction.php'); include('../php/rating.php'); include('../php/loginCheck.php'); ?>"
                      
                  ;
                  fwrite($myfile, $txt);
                  fclose($myfile);
                  rename("Temp", "../productPages/".$File);
                  //echo '<meta http-equiv="refresh" content="0">';
                  $conn->close();

                }
               
            }                
            ?>
        </div>
        </form>
    </div>
</body>
</html>
