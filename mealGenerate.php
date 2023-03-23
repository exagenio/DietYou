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
$age = $user ->getAge();
$gender = $user->getGender();
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
$snacks = [];
$TEEperSnack = ($user->getTEE() - $TEEreduction)*0.033;

// Free the memory used by the result set
mysqli_free_result($result);

for($i=0; $i<count($foods); ++$i){
  $foodCategory = $foods[$i]["wweia_category_description"];
  if( $foodCategory == "Wine" || $foodCategory == "Liquor and cocktails" || $foodCategory == "Beer"|| $foodCategory == "Salad dressings and vegetable oils" || $foodCategory == "Cream and cream substitutes" || $foodCategory == "Cream cheese, sour cream, whipped cream" ){
    continue;
  }
  //energy ratio give the ratio of energy relative to the required energy rae per meal for 1 servin
  $energyRatio = ($foods[$i]["energy"])/$TEEperMeal;
  //check whether the energy ratio is equal to 0 or not
  if($energyRatio == 0){
    continue;
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
          if($servingRatio<6){
            $foods[$i]['sRatio'] = $servingRatio;
            array_push($mainMeals, $foods[$i]);
          }
        }
      }
    }
  }


  if($ncds == 5 && ($foodCategory == "Tea" || $foodCategory == "coffee")){
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
      $foods[$i]['sRatio'] = $servingRatio;
      array_push($snacks, $foods[$i]);
    }

  }
}
echo "<br>";
echo "meals count = ", count($mainMeals);
echo "<br>";

$start_time = microtime(true);
// Create an array to hold all the possible combinations
function factorial($n)
{
    if ($n == 0)
        return 1;
    return $n * factorial($n - 1);
}

$totCombinations = factorial(count($mainMeals)) / (factorial(3)*(factorial(count($mainMeals)-3)));

$combinations = [];

// Keep generating combinations until all possible combinations are found
$countingNumber = 0;
if($totCombinations>5000){
  $countingNumber = 5000;
}else{
  $countingNumber = $totCombinations;
}
while (count($combinations) < $countingNumber) {

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
echo "combinations count = ",  count($combinations);
echo "<br>";

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo " Execution time of script = " . $execution_time . " sec<br>";





$mealPackages = [];
//filter meals for ncds
foreach ($combinations as $mealPack) {
  if($ncds == 2 || $ncds == 1 || $ncds == 5){
    $totSodium = 0;
    $totProtein = 0;
    foreach ($mealPack as $meal) {
      $servingRatio = $meal["sRatio"];
      $sodium = $meal["sodium"] * $servingRatio;
      $protein = $meal["protein"] * $servingRatio;
      $totSodium = $totSodium + $sodium;
      $totProtein = $totProtein + $protein;
    }
    if($totSodium < 1900 && $totProtein > 60){
      array_push($mealPackages, $mealPack);
    }

  }
  if($ncds == "null"){
    array_push($mealPackages, $mealPack);
  }
}



echo "meal packages count = ",  count($mealPackages);
echo "<br><br>-----------------------------------------------------------------------------------------------<br><br>";

echo "snacks count = ", count($snacks);





$totCombinations = factorial(count($snacks)) / (factorial(3)*(factorial(count($snacks)-3)));
echo "<br>",$totCombinations;
$sCombinations = [];

// Keep generating combinations until all possible combinations are found
$countingNumber = 0;
if($totCombinations>5000 || is_nan($totCombinations)){
  $countingNumber = 5000;
}else{
  $countingNumber = $totCombinations;
}
while (count($sCombinations) < $countingNumber) {

    // Generate a random combination of 3 items
    $combination = [];
    while (count($combination) < 3) {
        $item = $snacks[array_rand($snacks)];
        if (!in_array($item, $combination)) {
            $combination[] = $item;
        }
    }

    // Sort the combination to ensure that the same set of 3 items won't be repeated
    sort($combination);

    // Add the combination to the list if it doesn't already exist
    if (!in_array($combination, $sCombinations)) {
        $sCombinations[] = $combination;
    }
}
echo "<br>snack combinations = ",count($sCombinations); 

echo "<br><br>-----------------------------------------------------------------------------------------------<br><br>";

sleep(1);
$dietPlans = [];
$start_time = microtime(true);
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
  foreach ($sCombinations as $totSnacks) {
    $dailySFat = 0;
    $dailySProtein = 0;
    foreach($totSnacks as $snack){
      $serving = $snack["sRatio"];
      $snackFat = $snack["fat"]*$serving;
      $snackProtein = $snack["protein"]*$serving;
      $dailySFat = $dailySFat + $snackFat;
      $dailySProtein = $dailySProtein + $snackProtein;
    }
    $dailyTFat = $dailyMFat + $dailySFat;
    $dailyTProtein = $dailyMProtein + $dailySProtein;
    if(( ($dailyTProtein>= $proteinTot*1) && ($dailyTProtein < $proteinTot*1.15) ) &&  ( ($dailyTFat>= $fatTot*1) && ($dailyTFat < $fatTot*1.15) )   ){
      $dietPack = [$meals,$totSnacks];
      array_push($dietPlans, $dietPack);
    }
  }
}
echo "dietplans count = ", count($dietPlans);
$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo " Execution time of script = " . $execution_time . " sec<br>";
echo "<br><br><br><br>";

// for($i=0; $i<count($dietPlans); $i++){
//   echo "<br>---Main meals ---<br>";
//   echo $dietPlans[$i][0][0]["name"],"<br>", $dietPlans[$i][0][1]["name"],"<br>", $dietPlans[$i][0][2]["name"];
//   echo "<br><br>---Snacks ---<br>";
//   echo $dietPlans[$i][1][0]["name"],"<br>", $dietPlans[$i][1][1]["name"],"<br>", $dietPlans[$i][1][2]["name"];
//   echo "<br><br><br><br>";
// }

$finalDPlans = [];
$start_time = microtime(true);
for($i=0; $i<count($dietPlans); $i++){
  $fiber = 0;
  $folate = 0;
  $Vitamin_B6 = 0;
  $Vitamin_B12 = 0;
  $choline = 0;
  // $biotin = 0;
  $Vitamin_A = 0;
  $Vitamin_C = 0;
  $Vitamin_E = 0;
  $Vitamin_K = 0;
  $vitamin_D = 0;
  $calcium = 0;
  // $chromium = 0;
  // $iodine = 0;
  $iron = 0;
  $magnesium = 0;
  $potassium = 0;
  $selenium = 0;
  $sodium = 0;
  $zinc = 0;
  for($n=0; $n<2; $n++){
    for($j=0; $j<3; $j++){
      $sodium  += $dietPlans[$i][$n][$j]["sodium"];
      $fiber += $dietPlans[$i][$n][$j]["fiber_total_dietary_(g)"];
      $folate += $dietPlans[$i][$n][$j]["folate_food_(mcg)"];
      $Vitamin_B6 += $dietPlans[$i][$n][$j]["vitamin_B-6_(mg)"];
      $Vitamin_B12 += $dietPlans[$i][$n][$j]["vitamin_B-12_(mcg)"] + $dietPlans[$i][$n][$j]["vitamin_B-12_added(mcg)"];
      $choline += $dietPlans[$i][$n][$j]["choline_total_(mg)"];
      $Vitamin_A += $dietPlans[$i][$n][$j]["vitamin_A_RAE_(mcg_RAE)"];
      $Vitamin_C += $dietPlans[$i][$n][$j]["vitamin_C_(mg)"];
      $Vitamin_E += $dietPlans[$i][$n][$j]["vitamin_E_(alpha-tocopherol)_(mg)"];
      $Vitamin_K += $dietPlans[$i][$n][$j]["vitamin_K_(phylloquinone)_(mcg)"];
      $vitamin_D += $dietPlans[$i][$n][$j]["vitamin_D_(D2+D3)_(mcg)"];
      $calcium  += $dietPlans[$i][$n][$j]["calcium_(mg)"];
      $iron += $dietPlans[$i][$n][$j]["iron_(mg)"];
      $magnesium  += $dietPlans[$i][$n][$j]["magnesium_(mg)"];
      $potassium += $dietPlans[$i][$n][$j]["potassium_(mg)"];
      $selenium += $dietPlans[$i][$n][$j]["selenium_(mcg)"];
      $zinc += $dietPlans[$i][$n][$j]["zinc_(mg)"];
    }
  }
  $fiberReqM = ($fiber>=38*0.2)&&($fiber<=38*1.5);
  $fiberReqF = ($fiber>=25*0.2)&&($fiber<=25*1.5);

  $folateReq = ($folate>=400*0.2)&&($folate<=400*1.5);

  $vit_b6Req = ($Vitamin_B6>=1.3*0.2)&&($Vitamin_B6<=1.3*1.5);
  $vit_b6ReqW50 = ($Vitamin_B6>=1.7*0.2)&&($Vitamin_B6<=1.7*1.5);
  $vit_b6ReqM50 = ($Vitamin_B6>=1.5*0.2)&&($Vitamin_B6<=1.5*1.5);

  $vit_b12Req = ($Vitamin_B12 >= 2.4*0.2)&&($Vitamin_B12 <= 2.4*1.5);

  $cholineReqW = ($choline >=550*0.2)&&($choline <=550*1.5);
  $cholineReqM =($choline >=225*0.2)&&($choline <=225*1.5);

  $vit_AReqW = ($Vitamin_A >=700*0.2) && ($Vitamin_A <=700*1.5);
  $vit_AReqM = ($Vitamin_A >=900*0.2) && ($Vitamin_A <=900*1.5);

  $vit_EReq = ($Vitamin_E >=15*0.2)&& ($Vitamin_E <=15*1.5);

  $vit_KReq = ($Vitamin_E >=15*0.2) &&($Vitamin_K <=120*1.5);

  $vit_DReq = ($vitamin_D >= 15*0.2) && ($vitamin_D <= 15*1.5) ;
  $vit_DReq70 =($vitamin_D >= 20*0.2) && ($vitamin_D <= 20*1.5);

  $calcium_Req = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
  $calcium_Req50 = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
  $calcium_Req70 = ($calcium >= 1200*0.2) && ($calcium <= 1200*1.5);

  $iron_ReqW = ($iron >= 18*0.2) && ($iron <= 18*1.5);;
  $iron_ReqM = ($iron >= 8*0.2) && ($iron <= 8*1.5);
  $iron_Req50 = ($iron >= 8*0.2) && ($iron <= 8*1.5);;

  $magenesium_Req = ($magnesium >= 400*0.2) && ($magnesium <= 400*1.5);
  $magenesium_Req30 = ($magnesium >= 420*0.2) && ($magnesium <= 420*1.5);

  $potassium_Req =($potassium >= 3400*0.2) && ($potassium <= 3400*1.5);

  $seleniumReq =($selenium >= 55*0.2) && ($selenium <= 55*1.5);

  $sodiumReq = ($sodium >=2300*0.2) && ($sodium <=2300*1.5);

  $zincReqW =($zinc >= 8*0.2) && ($zinc <= 8*1.5);
  $zincReqM = ($zinc >= 11*0.2) && ($zinc <= 11*1.5);

  if(($folateReq) && ($vit_b12Req) && ($vit_EReq) && ($vit_KReq) && ($potassium_Req) && ($seleniumReq) && ($sodiumReq) ){
    if($gender =="F"){
     
      if(($fiberReqF) && ($cholineReqW) && ($vit_AReqW) && ($iron_ReqW) && ($zincReqW)){
        if($age>70){
          if(($calcium_Req70) && ($vit_b6ReqW50) && ($iron_Req50) && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>50){
          if( ($calcium_Req50) && ($vit_b6ReqW50) && ($iron_Req50) && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>30){
          if(($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>19){
          array_push($finalDPlans, $dietPlans[$i]);
        }

      }
    }
    if($gender =="M"){
      
      if(($fiberReqM) && ($cholineReqM)  && ($vit_AReqM) && ($iron_ReqM) && ($zincReqM)){
        
        if($age>70){
          if(($calcium_Req70) && ($vit_b6ReqM50) && ($iron_Req50) && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>50){
          if( ($calcium_Req50) && ($vit_b6ReqM50) && ($iron_Req50) && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>30){
          if(($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>19){
          array_push($finalDPlans, $dietPlans[$i]);
        }
      }
    }
  }
}

echo "<br><br>-----------------------------------------------------------------------------------------------<br><br>";
echo "final dietplans count = ", count($finalDPlans);
$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo " Execution time of script = " . $execution_time . " sec<br>";

$estimatedWloss = 0;
if($TEEreduction != 0){
  $estimatedWloss = ($TEEreduction*7)/7500;
}

$userId = findUser($username, $connection);
for($i=0; $i<count($finalDPlans); $i++){
  echo "<br>---Main meals ---<br>";
  echo $finalDPlans[$i][0][0]["name"],"-",$finalDPlans[$i][0][0]["sRatio"]*100,"g","<br>", $finalDPlans[$i][0][1]["name"],"-",$finalDPlans[$i][0][1]["sRatio"]*100,"g","<br>", $finalDPlans[$i][0][2]["name"],"-",$finalDPlans[$i][0][2]["sRatio"]*100,"g";
  echo "<br><br>---Snacks ---<br>";
  echo $finalDPlans[$i][1][0]["name"],"-",$finalDPlans[$i][1][0]["sRatio"]*100,"g","<br>", $finalDPlans[$i][1][1]["name"],"-",$finalDPlans[$i][1][1]["sRatio"]*100,"g","<br>", $finalDPlans[$i][1][2]["name"],"-",$finalDPlans[$i][1][2]["sRatio"]*100,"g";
  $mealArray = [$finalDPlans[$i][0][0]["food_code"],$finalDPlans[$i][0][1]["food_code"],$finalDPlans[$i][0][2]["food_code"],$finalDPlans[$i][0][0]["sRatio"],$finalDPlans[$i][0][1]["sRatio"],$finalDPlans[$i][0][2]["sRatio"]];
  $mealString = implode(',', $mealArray);
  $snackArray = [$finalDPlans[$i][1][0]["food_code"],$finalDPlans[$i][1][1]["food_code"],$finalDPlans[$i][1][2]["food_code"],$finalDPlans[$i][1][0]["sRatio"],$finalDPlans[$i][1][1]["sRatio"],$finalDPlans[$i][1][2]["sRatio"]];
  $snackString = implode(',', $snackArray);
  $query =   "INSERT INTO mealplans (meals, snacks, user, estimatedWLoss ) VALUES('$mealString','$snackString','$userId', '$estimatedWloss')";
  $query = mysqli_query($connection, $query); 
  if($query){
    echo "<br>";
      echo "mealplan added";
  }else{
      die("query failed".mysqli_error($connection));
  }
  echo "<br><br><br><br>";
  
}



?>
