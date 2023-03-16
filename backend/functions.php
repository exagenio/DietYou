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

function ProteinCalculator($TEE){
    $protein = ($TEE*(20/100))/4;
    return $protein;
}

function fatCalculator($TEE){
    $fat = ($TEE*(25/100))/9;
    return $fat;
}

function carbCalculator($TEE){
    $carb = ($TEE*(55/100))/4;
    return $carb;
}

//recognize allergies and return all restriction. If there are no allrgies, outcome will be null
function allergyFilter($connection, $username){
    $fullResArray = [];
    $findAllergQuery = "SELECT allergies FROM users where email = '$username'";
    $findAllergyResult = mysqli_query($connection, $findAllergQuery);
    if (mysqli_num_rows($findAllergyResult) == 0) {

    } else {
        $Allergyow = mysqli_fetch_row($findAllergyResult);
        $AllergyString = $Allergyow[0];
        $allergies = explode(",", $AllergyString);
        if($allergies[0] != null){
            if( in_array( "lactose-intolerance" ,$allergies ) ){
                $findRestrictions = "SELECT restrictions FROM allergies where name = 'lactose-intolerance'";
                $findQuery = mysqli_query($connection, $findRestrictions);
                if (mysqli_num_rows($findQuery) == 0) {
                } else {
                    $row = mysqli_fetch_row($findQuery);
                    $lactString = $row[0];
                    $lactArray = explode(",", $lactString);
                    $fullResArray = array_merge($fullResArray,$lactArray);
                }
            }
            if( in_array( "galactosemia" ,$allergies ) ){
                $findRestrictions = "SELECT restrictions FROM allergies where name = 'galactosemia'";
                $findQuery = mysqli_query($connection, $findRestrictions);
                if (mysqli_num_rows($findQuery) == 0) {
                } else {
                    $row = mysqli_fetch_row($findQuery);
                    $restrictString = $row[0];
                    $restrictArray = explode(",", $restrictString);
                    $fullResArray = array_merge($fullResArray,$restrictArray);
                }
            }
            if( in_array( "fructose-intolerance" ,$allergies ) ){
                $findRestrictions = "SELECT restrictions FROM allergies where name = 'fructose-intolerance'";
                $findQuery = mysqli_query($connection, $findRestrictions);
                if (mysqli_num_rows($findQuery) == 0) {
                } else {
                    $row = mysqli_fetch_row($findQuery);
                    $restrictString = $row[0];
                    $restrictArray = explode(",", $restrictString);
                    $fullResArray = array_merge($fullResArray,$restrictArray);
                }
            }
        }
    }
    return $fullResArray;
}
?>