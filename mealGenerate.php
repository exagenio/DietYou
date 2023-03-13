<?php
include "backend/db.php"; 
include "backend/functions.php";

//set session values
session_start();
$username = $_SESSION['username'];
//check the login status of the user
if ((isset($_SESSION['username'])) && $_SESSION["userVerified"] == 1) {
  //logged in
} else {
  // Session variable is not set
  header('Location: http://localhost/dietYou/login.php');
}

$findQuery = "SELECT * FROM foods";
// $result = mysqli_query($connection, $findQuery);

$allergyRestrictions = allergyFilter($connection, $username);
if(count($allergyRestrictions) >0){
    $filterValues = implode(',', $allergyRestrictions);
    echo "<br>";
    echo $filterValues;
    echo "<br>";
    echo "<br>";
    $findQuery = "SELECT * FROM foods WHERE food_category NOT IN ($filterValues)";
}
echo $findQuery;
echo "<br>";
echo "<br>";

$result = mysqli_query($connection, $findQuery);
$foods = mysqli_fetch_assoc($result);
while ($foods) {
    // loop through the associative array and output each key-value pair
    foreach ($foods as $key => $value) {
        echo "$key: $value<br>";
    }
    echo "<br>";
}

$mainMeals = [];
for($i = 0; $i<3; $i++){
    $randomNum = rand(0,count($foods)-1);
}
?>