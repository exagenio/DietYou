<?php 
function userValidate($username){
    global $connection;
    // mysqli_real_escape_string($connection, "input from the frontend")
        $find = "SELECT email FROM users where email = $username";
        $findQuery = mysqli_query($connection, $find); 
        if(!$findQuery){
            return false;
        }else{
            return true;
        }
    };
?>