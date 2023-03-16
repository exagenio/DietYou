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

//query to get all the data in the foods table
$findQuery = "SELECT * FROM foods";

//get the restrictions for allergies from the function
$allergyRestrictions = allergyFilter($connection, $username);

if(count($allergyRestrictions) >0){
  //convert category no.s in array format to a string
  $filterValues = implode(',', $allergyRestrictions);
  //filter foods that not in the allergies food categories.
  $findQuery = "SELECT * FROM foods WHERE food_category NOT IN ($filterValues)";
}

//get the result according to the query
$result = mysqli_query($connection, $findQuery);

// Initialize an empty array to store the rows of the filtered food table
$rows = array();

// Fetch each row of data and add it to the array
while ($row = mysqli_fetch_assoc($result)) {
    array_push($rows, $row);
}

//initialize an array to store meals that filter using PN formula
$mainMeals = [];
//get the user data by creating a user object
$user = new User($username, $connection);
$TEEtot = $user->getTEE();
$TEEreduction = 0;
$bmi = $user->getBMI();
$ncds = $user->getNcds();
// according to the BMI value, total energy requirement will be reduced for weight loss
$proteinTot = $user->getProtein();
$carbTot = ($TEEtot*0.55)/4;
$fatTot = $user->getFat();

if($bmi>=30){
  $TEEreduction = 1000;
  $proteinEnergy = $proteinTot*4;
  $fatEnergy = $fatTot*9;
  $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
  if($remainEnergy<0){
    $TEEreduction = 500;
  $proteinEnergy = $proteinTot*4;
  $fatEnergy = $fatTot*9;
  $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
  }
  //reduce the carb amount if the BMI value is greater than the normal range.
  $carbTot = $remainEnergy/4;
}else if($bmi>=25 || $ncds == 1){
  $TEEreduction = 750;
  $proteinEnergy = $proteinTot*4;
  $fatEnergy = $fatTot*9;
  $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
  if($remainEnergy<0){
    $TEEreduction = 500;
  $proteinEnergy = $proteinTot*4;
  $fatEnergy = $fatTot*9;
  $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
  }
  //reduce the carb amount if the BMI value is greater than the normal range.
  $carbTot = $remainEnergy/4;
}

$TEEperMeal = ($user->getTEE() - $TEEreduction)*0.32;

// Free the memory used by the result set
mysqli_free_result($result);

for($i=0; $i<count($rows); ++$i){
  //energy ratio give the ratio of energy relative to the required energy rae per meal for 1 servin
  $energyRatio = ($rows[$i]["energy"])/$TEEperMeal;
  //check whether the energy ratio is equal to 0 or not
  if($energyRatio == 0){

  }else{
    //serving ratio gives the multiplication no.for single serving to match the total energy requirement per meal.
    $servingRatio = (1/($energyRatio*100))*100;

    //protein, carn and fat containing in the meal that gives the total energy requirement per meal
    $proteinContain = ($rows[$i]["protein"])*$servingRatio;
    $carbContain = ($rows[$i]["carbohydrate"])*$servingRatio;
    $fatContain = ($rows[$i]["fat"])*$servingRatio;
    
    //check total protein and carbs contain will be > 86% or less than 98% of the total protein and carbs requirement per day.
    if( ($proteinContain >= ((0.86*$proteinTot)/3)) && ($proteinContain <= ((0.98*$proteinTot)/3)) ){
      if(($carbContain >= ((0.86*$carbTot)/3)) && ($carbContain <= ((0.98*$carbTot)/3))){
        $rows[$i]['sRatio'] = $servingRatio;
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
        array_push($mainMeals, $rows[$i]);
      }
    }
  }
}




echo "<br>";
echo "<br>";
// foreach ($mainMeals as $row) {
//   echo $row["name"];
//   echo "<br>";
// }

// Create an array to hold all the possible combinations
$combinations = [];

// Keep generating combinations until all possible combinations are found
while (count($combinations) < count($mainMeals) * (count($mainMeals) - 1) * (count($mainMeals) - 2) / 6) {

    // Generate a random combination of 3 items
    $combination = [];
    while (count($combination) < 3) {
        $item = $mainMeals[array_rand($mainMeals)];
        if (!in_array($item, $combination)) {
            $combination[] = $item;
        }
    }

    // Sort the combination to ensure that the same set of 3 items won't be repeated
    sort($combination);

    // Add the combination to the list if it doesn't already exist
    if (!in_array($combination, $combinations)) {
        $combinations[] = $combination;
    }
}

echo count($combinations);

foreach ($combinations as $rows) {
  echo "<br>";
  foreach ($rows as $row) {
    echo $row["name"];
    echo "---";
  }
}
$mealPackages = [];
foreach ($combinations as $mealPack) {
  if($ncds == 2){
    $totSodium = 0;
    $totProtein = 0;
    foreach ($mealPack as $meal) {
      // echo $row["name"];
      $servingRatio = $row["sRatio"];
      $sodium = $row["sodium"] * $servingRatio;
      $protein = $row["protein"] * $servingRatio;
      $totSodium = $totSodium + $sodium;
      $totProtein = $totProtein + $protein;
    }
    if($totSodium < 2 && $totProtein > 60){
      array_push($mealPackages, $mealPack);
    }

  }else if($ncds){

  }
}



?>
