<?php 
//print values to brower's console
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function findUser($username, $connection){
    $find = "SELECT id FROM users where email = '$username'";
    $findQuery = mysqli_query($connection, $find);
    $row = mysqli_fetch_row($findQuery);
    if (mysqli_num_rows($findQuery) == 0) {
        header('Location: http://localhost/dietYou/login.php');
    } else {
        debug_to_console($row[0]);
        return $row[0];
    }
}

//check whether user is already exist
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

//calculate BMI
function bmiCalculate($height, $weight){
    $bmi = $weight/(($height*$height)/10000);
    return $bmi;
}

//calculate total energy requirement per day
//Male = M      Female = F
function TEE($weight, $height, $activityFactor, $gender, $age){
    $bmi = bmiCalculate($weight, $height);
    $TEE = 0;
    if($gender == "M"){
        if($bmi >24.9){
            //For men: TEE = (10 x weight in kg) + (6.25 x height in cm) - (5 x age in years) + 5
            $BMR = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
            $TEE = $BMR * $activityFactor;
        }else{
            // harrris benedict = 88.362 + (13.397 x weight in kg) + (4.799 x height in cm) - (5.677 x age in years)
            $BMR = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
            $TEE = $BMR * $activityFactor;
        }
    }else if($gender == "F"){
        if($bmi >24.9){
            //For women: TEE = (10 x weight in kg) + (6.25 x height in cm) - (5 x age in years) - 161
            $BMR = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
            $TEE = $BMR * $activityFactor;
        }else{
            // harrris benedict = 447.593 + (9.247 x weight in kg) + (3.098 x height in cm) - (4.330 x age in years)
            $BMR = 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
            $TEE = $BMR * $activityFactor;
        }
    }
    return $TEE;
}

?>