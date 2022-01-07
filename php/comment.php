<?php 
session_start();

if(isset($_SESSION['UID'])){
    echo '<html>
    <body>
    <form method="post">
    <textarea rows="4" cols="50" name="comment"> </textarea>
    <input type="submit" name="submitComment">
    </from>
    </body>
    </html>';
    
 
}else{
  
}


include('indexBackend.php');
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


$sql = "SELECT PID FROM Product WHERE Name='$productName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id = $row['PID'];
    }
}

if(isset($_POST["submitComment"])) {

    
    $text = $_POST['comment'];
    $sql = "INSERT INTO Comments (Comment, Name, Product) VALUES ('".$text."','".$_SESSION['username']."',".$id.") ";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    echo '<meta http-equiv="refresh" content="0">';
}

$sql = "SELECT * FROM Comments WHERE Product='$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo'<div class="comments"> '.$row['Name'].'<br> <br>'.$row['Comment'].'</div>';
    }
  }
?>