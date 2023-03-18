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
$foods = array();

// Fetch each row of data and add it to the array
while ($row = mysqli_fetch_assoc($result)) {
    array_push($foods, $row);
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

$TEEperMeal = ($user->getTEE() - $TEEreduction)*0.30;

// Free the memory used by the result set
mysqli_free_result($result);

for($i=0; $i<count($foods); ++$i){
  $foodCategory = $foods[$i]["wweia_category_description"];
  if( $foodCategory == "Wine" || $foodCategory == "Liquor and cocktails" || $foodCategory == "Beer"|| $foodCategory == "Salad dressings and vegetable oils"){
    continue;
  }
  //energy ratio give the ratio of energy relative to the required energy rae per meal for 1 servin
  $energyRatio = ($foods[$i]["energy"])/$TEEperMeal;
  //check whether the energy ratio is equal to 0 or not
  if($energyRatio == 0){

  }else{
    //serving ratio gives the multiplication no.for single serving to match the total energy requirement per meal.
    $servingRatio = (1/($energyRatio*100))*100;

    //protein, carn and fat containing in the meal that gives the total energy requirement per meal
    $proteinContain = ($foods[$i]["protein"])*$servingRatio;
    $carbContain = ($foods[$i]["carbohydrate"])*$servingRatio;
    $fatContain = ($foods[$i]["fat"])*$servingRatio;
    
    //check total protein and carbs contain will be > 86% or less than 98% of the total protein and carbs requirement per day.
    if( ($proteinContain >= ((0.8*$proteinTot)/3)) && ($proteinContain <= ((0.98*$proteinTot)/3)) ){
      if(($fatContain >= ((0.7*$fatTot)/3)) && ($fatContain <= ((0.98*$fatTot)/3))){
        if(($carbContain >= ((0.8*$carbTot)/3)) && ($carbContain <= ((1.02*$carbTot)/3))){
          if($servingRatio<8){
            $foods[$i]['sRatio'] = $servingRatio;
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
            array_push($mainMeals, $foods[$i]);
          }
        }
      }
    }
  }
}




echo "<br>";
echo count($mainMeals);
echo "<br>";
foreach ($mainMeals as $row) {
  echo $row["name"];
  echo "<br>";
}


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
echo "<br>";

// foreach ($combinations as $rows) {
//   echo "<br>";
//   foreach ($rows as $row) {
//     echo $row["name"];
//     echo "---";
//   }
// }
$mealPackages = [];
//filter meals for ncds
foreach ($combinations as $mealPack) {
  if($ncds == 2 || $ncds == 1 || $ncds == 5){
    $totSodium = 0;
    $totProtein = 0;
    foreach ($mealPack as $meal) {
      // echo $row["name"];
      $servingRatio = $meal["sRatio"];
      $sodium = $meal["sodium"] * $servingRatio;
      $protein = $meal["protein"] * $servingRatio;
      // echo "<br>sodium and protein values -----------<br>";
      // echo "sodium =";
      // echo $sodium;
      // echo "<br>protein = ";
      // echo $protein;
      // echo "<br>serving ratio = ";
      // echo $servingRatio;
      // echo "<br>food code = ";
      // echo $meal["food_code"];
      $totSodium = $totSodium + $sodium;
      $totProtein = $totProtein + $protein;
    }
    // echo "<br>total sodium =";
    //   echo $totSodium;
    //   echo "<br>total protein = ";
    //   echo $totProtein;
    // echo "<br> ---------end ------------<br><br><br>";
    if($totSodium < 1900 && $totProtein > 60){
      array_push($mealPackages, $mealPack);
    }

  }
  if($ncds == "null"){
    array_push($mealPackages, $mealPack);
  }
}



echo count($mealPackages);
echo "<br><br>-----------------------------------------------------------------------------------------------<br><br>";
foreach ($mealPackages as $rows) {
  echo "<br>";
  foreach ($rows as $row) {
    echo $row["name"];
    echo "---";
  }
}

echo "<br><br>-----------------------------------------------------------------------------------------------<br><br>";

$snacks = [];
$TEEperSnack = ($user->getTEE() - $TEEreduction)*0.033;
for($i=0; $i<count($foods); ++$i){
  $foodCategory = $foods[$i]["wweia_category_description"];
  if($ncds == 5 && ($foodCategory == "Tea" || $foodCategory == "coffee")){
    continue;
  }
  if( $foodCategory == "Wine" || $foodCategory == "Liquor and cocktails" || $foodCategory == "Beer"|| $foodCategory == "Salad dressings and vegetable oils"){
    continue;
  }
  //energy ratio give the ratio of energy relative to the required energy rae per meal for 1 servin
  $energyRatio = ($foods[$i]["energy"])/$TEEperSnack;
  //check whether the energy ratio is equal to 0 or not
  if($energyRatio == 0){

  }else{
    //serving ratio gives the multiplication no.for single serving to match the total energy requirement per meal.
    $servingRatio = (1/($energyRatio*100))*100;

    //protein, carn and fat containing in the meal that gives the total energy requirement per meal
    $proteinContain = ($foods[$i]["protein"])*$servingRatio;
    $carbContain = ($foods[$i]["carbohydrate"])*$servingRatio;
    $fatContain = ($foods[$i]["fat"])*$servingRatio;
    if($foods[$i]["sodium"] < 33.33 && ($servingRatio*100 < 100)){
      // echo"<br>";
      // echo"<br>";
      // echo $servingRatio*100;
      // echo"<br>";
      // echo $foods[$i]["name"];
      // echo"<br>";
      // echo"<br>";
      // echo $servingRatio*100;
      // echo "<br>";
      // echo "carb = ";
      // echo $carbContain;
      // echo "<br>";
      // echo "protein = ";
      // echo  $proteinContain ;
      // echo "<br>";
      // echo "fat = ";
      // echo $fatContain ;
      // echo "<br>";
      // echo "fat percentage = ";
      // echo (($fatContain/$fatTot)/3)*100 ;
      // echo "<br>";
      // echo "<br>";
      $foods[$i]['sRatio'] = $servingRatio;
      array_push($snacks, $foods[$i]);
    }

  }
}
echo count($snacks);
// foreach ($snacks as $row) {
//   echo $row["name"];
//   echo "<br>";
// }

echo "<br><br>-----------------------------------------------------------------------------------------------<br><br>";

sleep(1);

// $sncakCombine = [];


// echo(count($sncakCombine));

$dietPlans = [];

foreach ($mealPackages as $meals) {
  $dailyMProtein = 0;
  $dailyMFat = 0;
  foreach ($meals as $meal) {
    $serving = $meal["sRatio"];
    $mealFat = $meal["fat"]*$serving;
    $mealProtein = $meal["protein"]*$serving;

    $dailyMFat = $dailyMFat + $mealFat;
    $dailyMProtein = $dailyMProtein + $mealProtein;
  }
  // if($dailyMFat < $fatTot*1){
  //   echo"<br><br>";
  //   echo $dailyMProtein;
  //   echo"<br>";
  //   echo $fatTot;
  //   echo"<br>";
  //   echo $dailyMFat;
  //   echo"<br><br>";
  // }
  $checkedSets = [];
  for($n=0; $n<1000; $n++){
    $s1 = array_rand($snacks);
    $s2 = array_rand($snacks);
    if($s2 == $s1){
      $n--;
      continue;
    }
    $s3 = array_rand($snacks);
    if($s3 == $s1 || $s3 == $s2 ){
      $n--;
      continue;
    }
    $checksItems = [$s1, $s2,$s3];
    $equalItems = false;
    for($m=0; $m<count($checkedSets); $m++) {
      if (count(array_diff($checksItems, $checkedSets[$m])) == 0 && count(array_diff( $checkedSets[$m], $checksItems)) == 0) {
          $equalItems = true;
          break;
      }
    }
    if($equalItems){
      continue;
    }else{
      array_push($checkedSets, $checksItems);
    }
    $s1serving = $snacks[$s1]["sRatio"];
    $s2serving = $snacks[$s2]["sRatio"];
    $s3serving = $snacks[$s3]["sRatio"];

    $s1Fat = $snacks[$s1]["fat"]*$s1serving;
    $s1Protein = $snacks[$s1]["protein"]*$s1serving;

    $s2Fat = $snacks[$s2]["fat"]*$s2serving;
    $s2Protein = $snacks[$s2]["protein"]*$s2serving;

    $s3Fat = $snacks[$s3]["fat"]*$s3serving;
    $s3Protein = $snacks[$s3]["protein"]*$s3serving;

    $dailySFat = $s1Fat + $s2Fat + $s3Fat;
    $dailySProtein = $s1Protein + $s2Protein + $s3Protein;

    $dailyTFat = $dailyMFat + $dailySFat;
    $dailyTProtein = $dailyMProtein + $dailySFat;
    if(( ($dailyTProtein>= $proteinTot*1) && ($dailyTProtein < $proteinTot*1.15) ) &&  ( ($dailyTFat>= $fatTot*1) && ($dailyTFat < $fatTot*1.15) )   ){
      $dietPack = [$meals,[$snacks[$s1], $snacks[$s2], $snacks[$s3]]];
      array_push($dietPlans, $dietPack);

    }
  }

  // foreach($sncakCombine as $snacks){
  //   $dailySProtein = 0;
  //   $dailySFat = 0;
  //   // foreach($snacks as $snack){
  //   //   $serving = $snack["sRatio"];
  //   //   $snackFat = $snack["carbohydrate"]*$serving;
  //   //   $snackProtein = $snack["protein"]*$serving;
  
  //   //   $dailySFat = $dailySFat + $snackFat;
  //   //   $dailySProtein = $dailySProtein + $snackProtein;


  //   // }
  //   // echo"<br><br>";
  //   // echo $dailySProtein;
  //   // echo"<br>";
  //   // echo $dailySFat;
  //   // echo"<br><br>";
  //   // $dailyProtein = $dailyMProtein + $dailySProtein;
  //   // $dailyFat = $dailyMFat + $dailySFat;
  //   // echo"<br><br>";
  //   // echo $dailyProtein;
  //   // echo"<br>";
  //   // echo $dailyFat;
  //   // echo"<br><br>";
  //   // if(( ($dailyProtein>= $proteinTot*1) && ($dailyProtein < $proteinTot*1.2) ) &&  ( ($dailyFat>= $fatTot*1) && ($dailyFat < $fatTot*1.2) )   ){
  //   //   $dietPack = [$meals,$snacks];
  //   //   array_push($dietPlans, $dietPack);
  //   //   break;
  //   // }
  // }
}
echo count($dietPlans);
echo "<br><br><br><br>";

for($i=0; $i<count($dietPlans); $i++){
  echo "<br>---Main meals ---<br>";
  echo $dietPlans[$i][0][0]["name"],"<br>", $dietPlans[$i][0][1]["name"],"<br>", $dietPlans[$i][0][2]["name"];
  echo "<br><br>---Snacks ---<br>";
  echo $dietPlans[$i][1][0]["name"],"<br>", $dietPlans[$i][1][1]["name"],"<br>", $dietPlans[$i][1][2]["name"];
  echo "<br><br><br><br>";
}



// // foreach ($mealPackages as $meals) {
// //   $dailyProtein = 0;
// //   $dailyFat = 0;
// //   foreach ($meals as $meal) {
// //     $serving = $meal["sRatio"];
// //     $mealFat = $meal["carbohydrate"]*$serving;
// //     $mealProtein = $meal["protein"]*$serving;

// //     $dailyFat = $dailyFat + $mealFat;
// //     $dailyProtein = $dailyProtein + $mealProtein;
// //   }
// //   foreach($sncakCombine as $snacks){
// //     foreach($snacks as $snack){
// //       $serving = $snack["sRatio"];
// //       $snackFat = $snack["carbohydrate"]*$serving;
// //       $snackProtein = $snack["protein"]*$serving;
  
// //       $dailyFat = $dailyFat + $snackFat;
// //       $dailyProtein = $dailyProtein + $snackProtein;
// //     }
// //     if(( ($dailyProtein>= $proteinTot*0.5) && ($dailyProtein < $proteinTot) ) &&  ( ($dailyFat>= $fatTot*0.5) && ($dailyFat < $fatTot) )   ){
// //       $dietPack = [$meals,$snacks];
// //       array_push($dietPlans, $dietPack);
// //       break;
// //     }
// //   }
// //   if(count($dietPlans)>1000){
// //     break;
// //   }
// // }

// // echo count($dietPlans);
// // foreach($dietPlans as $totPackage){
// //   echo"-Main Meals-";
// //   print_r( $totPackage[0][0]["name"]);
// //   echo "<br>";
// //   print_r( $totPackage[0][1]["name"]);
// //   echo "<br>";
// //   print_r( $totPackage[0][2]["name"]);
// //   echo "<br>";
// //   echo "<br>";
// //   echo"-Snacks-";
// //   print_r( $totPackage[1][0]["name"]);
// //   echo "<br>";
// //   print_r( $totPackage[1][1]["name"]);
// //   echo "<br>";
// //   print_r( $totPackage[1][2]["name"]);
// //   echo "<br>";
// //   echo "<br>";
// //   echo "<br>";
// // }
// // foreach ($dietPlans as $totPackage) {
// //   echo "<br><br>--Meal plan--<br>";
// //   foreach($totPackage as $items){
// //     $mealsPerDay = $items[0];
// //     $snacksPerDay = $items[1];
// //     echo "-Main meals- <br>";
// //     foreach($mealsPerDay as $meal){
// //       echo $meal["name"];
// //       echo "<br>";
// //     }
// //     echo "<br>-Snacks- <br>";
// //     foreach($snacksPerDay as $snack){
// //       echo $snack["name"];
// //       echo "<br>";
// //     }
// //   }
// //   echo "============end==========<br><br>";
// // }


// $fiber = 0;
// $folate = 0;
// $vitb6 = 0;
// $vitb12 = 0;
// $choline = 0;
// $biotin = 0;
// $vita = 0;
// $vitc = 0;
// $vite = 0;


?>
