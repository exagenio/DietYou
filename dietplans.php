<?php
include "backend/db.php"; 
include "classes/User.php";
session_start();
if(isset($_POST['checkedIds'])){
    $username = $_SESSION['username'];
    $planIds = $_POST['checkedIds'];
    $totPlans =$_SESSION["finalPlans"];

    $user = new User($username, $connection);

    $TEEtot = $user->getTEE();
    $TEEreduction = 0;
    $bmi = $user->getBMI();
    $ncds = $user->getNcds();
    $countries = $user->getCountries();
    $preferences = $user->getPreferences();
    // according to the BMI value, total energy requirement will be reduced for weight loss
    $proteinTot = $user->getProtein();
    $carbTot = ($TEEtot*0.55)/4;
    $fatTot = $user->getFat();

    $teeReduction = 0;
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

      $estimatedWloss = 0;
      if($TEEreduction != 0){
        $estimatedWloss = ($TEEreduction*7)/7500;
      }

    $userId = findUser($username, $connection);
    $isSuccess = true;
    for($i=0; $i<count($planIds); $i++){
        $mealArray = [$totPlans[$i][0][0]["food_code"],$totPlans[$i][0][1]["food_code"],$totPlans[$i][0][2]["food_code"],$totPlans[$i][0][0]["sRatio"],$totPlans[$i][0][1]["sRatio"],$totPlans[$i][0][2]["sRatio"]];
        $mealString = implode(',', $mealArray);
        $mealArray = [];
        $snackArray = [];
        for ($n = 0; $n < 3; $n++) {
          $mealId = $totPlans[$i][0][$n]["food_code"]."-".$totPlans[$i][0][$n]['sRatio'];
          $snckId = $totPlans[$i][1][$n]["food_code"]."-".$totPlans[$i][1][$n]['sRatio'];
          array_push($mealArray, $mealId);
          array_push($snackArray, $snckId);
        }
        $mealString = implode(',', $mealArray);
        $snackString = implode(',', $snackArray);

        // $mealString = $sPlans[$i][0];
        // $snckString = $sPlans[$i][1];

        // echo  $mealString;
        // echo  $snckString;
        // $mealArray = [$sPlans[$i][0][0]["food_code"],$sPlans[$i][0][1]["food_code"],$sPlans[$i][0][2]["food_code"],$sPlans[$i][0][0]["sRatio"],$sPlans[$i][0][1]["sRatio"],$sPlans[$i][0][2]["sRatio"]];
        // $mealString = implode(',', $mealArray);
        // $snackArray = [$sPlans[$i][1][0]["food_code"],$sPlans[$i][1][1]["food_code"],$sPlans[$i][1][2]["food_code"],$sPlans[$i][1][0]["sRatio"],$sPlans[$i][1][1]["sRatio"],$sPlans[$i][1][2]["sRatio"]];
        // $snackString = implode(',', $snackArray);
        // echo  $mealString;
        $query =   "INSERT INTO mealplans (meals, snacks, user, estimatedWLoss ) VALUES('$mealString','$snackString','$userId', '$estimatedWloss')";
        $query = mysqli_query($connection, $query); 
        if($query){
        }else{
            $isSuccess = false;
        }  
    }
    if($isSuccess){
      $date = new DateTime();
  
      // Format the date as a string
      $dateString = $date->format('Y-m-d H:i:s');

      //   //update query
      $query = <<<SQL
      UPDATE users SET
      planDate = '$dateString'
      WHERE id = '$userId';
      SQL;
  
      $query = mysqli_query($connection, $query); 
      if($query){
    
      }else{
        die("query failed".mysqli_error($connection));
      }
      echo "success";
    }else{
        echo "fail";
    }
}
?>