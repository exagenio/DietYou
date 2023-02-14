<?php 
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function userValidate($username){
    global $connection;
    // mysqli_real_escape_string($connection, "input from the frontend")
        $find = "SELECT email FROM users where email = $username";
        $findQuery = mysqli_query($connection, $find); 
        if(!$findQuery){
            debug_to_console("testing");
            return false;
        }else{
            return true;
        }
    };
?>