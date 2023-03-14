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
$carbTot = (($TEEtot*0.55)-$TEEreduction)/4;
$fatTot = $user->getFat();
$proteinTot = $user->getProtein();
$TEEperMeal = ($user->getTEE() - $TEEreduction)*0.32;
$randomNum = rand(0,count($rows)-1);

// Free the memory used by the result set
mysqli_free_result($result);

// Use the array of row objects as desired
// foreach ($rows as $row) {
//     echo $row["name"];
//     echo "<br>";
// }

$selectedRandomContainer = [];
// while(count($mainMeals) <3){
//   $randomNum = rand(0,count($rows)-1);
//   if( in_array( $randomNum  ,$selectedRandomContainer) ){
//     continue;
//   }
//   $energyRatio = ($rows[$randomNum]["energy"])/$TEEperMeal;
//   if($energyRatio == 0){

//   }else{
//     $servingRatio = (1/($energyRatio*100))*100;
//     $proteinContain = ($rows[$randomNum]["protein"])*$servingRatio;
//     $carbContain = ($rows[$randomNum]["carbohydrate"])*$servingRatio;
//     $fatContain = ($rows[$randomNum]["fat"])*$servingRatio;
    
//     if( ($proteinContain >= ((0.9*$proteinTot)/3)) && ($proteinContain <= ((0.98*$proteinTot)/3)) ){
//       if(($carbContain >= ((0.9*$carbTot)/3)) && ($carbContain <= ((0.98*$carbTot)/3))){
//           echo $servingRatio*100;
//           echo "<br>";
//           echo "carb = ";
//           echo $carbContain;
//           echo "<br>";
//           echo "protein = ";
//           echo  $proteinContain ;
//           echo "<br>";
//           echo "fat = ";
//           echo $fatContain ;
//           echo "<br>";
//           echo "fat percentage = ";
//           echo ($fatContain/$fatTot)/3 ;
//           echo "<br>";
//           echo "<br>";
//           array_push($mainMeals, $rows[$randomNum]);
//           array_push($selectedRandomContainer, $randomNum);

//       }
//     }
//   }
// }

for($i=0; $i<100000; ++$i){
  $randomNum = rand(0,count($rows)-1);
  if( in_array( $randomNum  ,$selectedRandomContainer) ){
    continue;
  }
  $energyRatio = ($rows[$randomNum]["energy"])/$TEEperMeal;
  if($energyRatio == 0){

  }else{
    $servingRatio = (1/($energyRatio*100))*100;
    $proteinContain = ($rows[$randomNum]["protein"])*$servingRatio;
    $carbContain = ($rows[$randomNum]["carbohydrate"])*$servingRatio;
    $fatContain = ($rows[$randomNum]["fat"])*$servingRatio;
    
    if( ($proteinContain >= ((0.86*$proteinTot)/3)) && ($proteinContain <= ((0.98*$proteinTot)/3)) ){
      if(($carbContain >= ((0.86*$carbTot)/3)) && ($carbContain <= ((0.98*$carbTot)/3))){
          echo $servingRatio*100;
          echo "<br>";
          echo "carb = ";
          echo $carbContain;
          echo "<br>";
          echo "protein = ";
          echo  $proteinContain ;
          echo "<br>";
          echo "fat = ";
          echo $fatContain ;
          echo "<br>";
          echo "fat percentage = ";
          echo (($fatContain/$fatTot)/3)*100 ;
          echo "<br>";
          echo "<br>";
          array_push($mainMeals, $rows[$randomNum]);
          array_push($selectedRandomContainer, $randomNum);

      }
    }
  }
}
echo "<br>";
echo "<br>";
foreach ($mainMeals as $row) {
  echo $row["name"];
  echo "<br>";
}

?>