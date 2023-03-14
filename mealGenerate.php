<?php
include "backend/db.php"; 
include "classes/User.php";

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
    $findQuery = "SELECT * FROM foods WHERE food_category NOT IN ($filterValues)";
}

$result = mysqli_query($connection, $findQuery);

// Initialize an empty array to store the row objects
$rows = array();

// Fetch each row of data and add it to the array
while ($row = mysqli_fetch_assoc($result)) {
    array_push($rows, $row);
}


$mainMeals = [];
$user = new User($username, $connection);
$carbTot = 0;
$TEEtot = $user->getTEE();
$TEEreduction = 0;
$bmi = $user->getBMI();
if($bmi>=30){
  $TEEreduction = 1000;
}else if($bmi>=25){
  $TEEreduction = 750;
}
$carbTot = (($TEEtot*0.6)-$TEEreduction)/4;
$fatTot = $user->getFat();
$proteinTot = $user->getProtein();
$TEEperMeal = ($user->getTEE() - $TEEreduction)*0.32;
$randomNum = rand(0,count($rows)-1);

// Free the memory used by the result set
mysqli_free_result($result);

// Use the array of row objects as desired
foreach ($rows as $row) {
    echo $row["name"];
    echo "<br>";
}

// while(count($mainMeals) <3){
//   $randomNum = rand(0,count($foods)-1);
//   print_r($foods[$randomNum]);

//   $findQuery = mysqli_query($connection, $find);
//   if (mysqli_num_rows($findQuery) == 0) {
//   } else {

//   }
// }

?>