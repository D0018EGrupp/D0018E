<?php

function check_login($con){

    if(isset($_SESSION['UID'])){
        $id = $_SESSION['UID'];
        $query = "select * from Users where UID = '$id' limit 1";

        $result = mysqli_query($conn,$query);

        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
}   
