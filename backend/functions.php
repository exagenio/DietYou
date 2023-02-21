<?php 
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function userExist($username){
    global $connection;
    // mysqli_real_escape_string($connection, "input from the frontend")
    $find = "SELECT email FROM users where email = '$username'";
    $findQuery = mysqli_query($connection, $find);
    if (mysqli_num_rows($findQuery) == 0) {
        return false;
    } else {
       return true;
    }
};
?>