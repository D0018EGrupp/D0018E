<html>
<body>
    <form method="post">
    <textarea rows="1" cols="2" name="comment"> </textarea>
    <input type="submit" name="rating" style="margin-top: 10px;">
    </from>
    </body>
</html>

<?php include('indexBackend.php');
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
//$productName = 'Apple';
//echo $productName;

$sql = "SELECT Rating,AmountRated FROM Product WHERE Name='$productName'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rating = $row['Rating'];
        $ratingAmount = $row['AmountRated'];
        //echo "AMOUNT IS ".$ratingAmount." !!!";
        //echo $raiting;
        //echo $ratingAmount;
    }
}



if(isset($_POST['rating'])){
    $canUpdate = true;
    $newRating = $_POST['comment'];
    if($_POST['comment']>10 || $newRating<0 || is_int($newRating) ||  !preg_match('/^[0-9 +-]*$/', $newRating) || preg_match("/[\[^\'£$%^&*()}{@:\'#~?><>,;@\|\\\-=\-_+\-¬\`\]]/", $newRating)){
        echo'<script>
        
          alert("Please enter a valid input, rating is from 0-10");
        
        </script>';
        $canUpdate = false;
    }
    echo $newRating." ";
    if($rating==NULL && $canUpdate){
        $ratingAmount = $ratingAmount+1;
        $sql = "UPDATE Product SET Rating = $newRating, AmountRated = $ratingAmount WHERE Name='$productName' ";
        //$sql = "INSERT INTO Comments (Comment, Name, Product) VALUES ('".$text."','".$_SESSION['username']."',".$id.") ";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            //echo '<meta http-equiv="refresh" content="0">';
        }
    }

    if($ratingAmount>=1 && $canUpdate){
        $ratingAmount++;
        //echo "NEW AMOUNT IS ".$ratingAmount." !!!!!";
        $aveRating = (($rating*$ratingAmount)+$newRating)/($ratingAmount+1);
        //$aveRating = 6;
        //echo $aveRating;
        $aveRating = round($aveRating);
        //echo $aveRating;
        $sql = "UPDATE Product SET Rating = $aveRating, AmountRated = $ratingAmount WHERE Name='$productName' ";
        //$sql = "INSERT INTO Comments (Comment, Name, Product) VALUES ('".$text."','".$_SESSION['username']."',".$id.") ";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            //echo '<meta http-equiv="refresh" content="0">';
        }
    }
    echo "New record created successfully";
}




?>