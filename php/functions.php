<?php
include("indecBackend.php");
function check_login($conn){

    if(isset($_SESSION['UID'])){
        echo"Welcome $username";




        }else{
            echo"no suer";
        }
    }
   
