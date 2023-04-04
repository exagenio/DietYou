<?php
include "backend/db.php";
include "backend/microFilters.php";
include "classes/User.php";
//set session values
session_start();
//check the login status of the user
if ((isset($_SESSION['username'])) && $_SESSION["userVerified"] == 1) {
  //logged in
} else {
  // Session variable is not set
  echo '<script>window.location.replace("http://localhost/dietYou/login.php");</script>';
}
$username = $_SESSION['username'];

//get the user data by creating a user object
$user = new User($username, $connection);
$age = $user->getAge();
$gender = $user->getGender();
if ($age == null || $gender == null) {
  echo '<script>window.location.replace("http://localhost/dietYou/form.php");</script>';
}

//the below array only takes into consideration the food codes that has fish 
//there are dishes in 3402 that include seafood and meat as well
$fish = [2402, 2404, 3006, 3730];
$fishString = ["seafood", "squid", "tuna", "crab"];
//below code is the first column 
//the below array only takes into consideration the food codes that has egg 
$egg = [2502, 3406, 3706];
$eggString = ["egg"];
//the below array only takes into consideration the food codes that has meat 
$meat = [2002, 2004, 2006, 2008, 2010, 2202, 2204, 2206, 2604, 3002, 3004, 3006, 3602, 3702, 3704, 3742];
$meatString = ["meat", "chicken", "poultry", "beef", "pork", "meatballs", "turkey"];

$cPlanDate = $user->getPlanDate();
$havePlan = false;
if ($cPlanDate != null) {
  // Create two DateTime objects
  $date1 = new DateTime($cPlanDate);
  $date2 = new DateTime();

  // Get the difference between the two dates
  $diff = $date1->diff($date2);
  $changeDays = $diff->days;
  if ($changeDays >= 7) {
    $query =   "DELETE FROM mealplans WHERE user = 1";
    $query = mysqli_query($connection, $query);
    if ($query) {
    } else {
      die("query failed" . mysqli_error($connection));
    }
    $havePlan = false;
  } else {
    $havePlan = true;
  }
}

if ($havePlan) {
  echo '<script>window.location.replace("dashboard.php");</script>';
} else {
  $TEEtot = $user->getTEE();
  $TEEreduction = 0;
  $bmi = $user->getBMI();
  $ncds = $user->getNcds();
  $countries = $user->getCountries();
  $preferences = $user->getPreferences();
  // according to the BMI value, total energy requirement will be reduced for weight loss
  $proteinTot = $user->getProtein();
  $carbTot = ($TEEtot * 0.55) / 4;
  $fatTot = $user->getFat();

  if ($bmi >= 30) {
    $TEEreduction = 1000;
    $proteinEnergy = $proteinTot * 4;
    $fatEnergy = $fatTot * 9;
    $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
    if ($remainEnergy < 0) {
      $TEEreduction = 500;
      $proteinEnergy = $proteinTot * 4;
      $fatEnergy = $fatTot * 9;
      $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
    }
    //reduce the carb amount if the BMI value is greater than the normal range.
    $carbTot = $remainEnergy / 4;
  } else if ($bmi >= 25 || $ncds == 1) {
    $TEEreduction = 750;
    $proteinEnergy = $proteinTot * 4;
    $fatEnergy = $fatTot * 9;
    $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
    if ($remainEnergy < 0) {
      $TEEreduction = 500;
      $proteinEnergy = $proteinTot * 4;
      $fatEnergy = $fatTot * 9;
      $remainEnergy = $TEEtot - $proteinEnergy - $fatEnergy -  $TEEreduction;
    }
    //reduce the carb amount if the BMI value is greater than the normal range.
    $carbTot = $remainEnergy / 4;
  }


  //query to get all the data in the foods table
  $findQuery = "SELECT * FROM foods";

  //get the restrictions for allergies from the function
  $allergyRestrictions = allergyFilter($connection, $username);

  if (count($allergyRestrictions) > 0) {
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

  $TEEperMeal = ($user->getTEE() - $TEEreduction) * 0.30;
  $snacks = [];
  $TEEperSnack = ($user->getTEE() - $TEEreduction) * 0.033;

  $countryArray = [];
  if ($countries != null) {
    $countryArray = explode(",", $countries);
  }
  // Free the memory used by the result set
  mysqli_free_result($result);

  $preferArray = [];
  if ($countries != null) {
    $preferArray = explode(",", $preferences);
  }

  $allNotPrefer = [];
  $notPrefStrings = [];

  if (in_array("fish", $preferArray)) {
    $allNotPrefer = array_merge($allNotPrefer, $fish);
    $notPrefStrings = array_merge($notPrefStrings, $fishString);
  }
  if (in_array("egg", $preferArray)) {
    $allNotPrefer = array_merge($allNotPrefer, $egg);
    $notPrefStrings = array_merge($notPrefStrings, $eggString);
  }
  if (in_array("meat", $preferArray)) {
    $allNotPrefer = array_merge($allNotPrefer, $meat);
    $notPrefStrings = array_merge($notPrefStrings, $meatString);
  }




  $count = 0;
  for ($i = 0; $i < count($foods); ++$i) {
    $foodCategory = $foods[$i]["wweia_category_description"];
    if ($foodCategory == "Wine" || $foodCategory == "Liquor and cocktails" || $foodCategory == "Beer" || $foodCategory == "Salad dressings and vegetable oils" || $foodCategory == "Cream and cream substitutes" || $foodCategory == "Cream cheese, sour cream, whipped cream") {
      continue;
    }
    $country = $foods[$i]["country"];
    if (in_array($country, $countryArray)) {
      $count++;
    } else {
      continue;
    }
    $categNumber = $foods[$i]["food_category"];
    if (in_array($categNumber, $allNotPrefer)) {
      continue;
    }
    $foodName = $foods[$i]["name"];
    $foodName = str_replace(",", "",  $foodName);
    $foodName = strtolower($foodName);
    $fNameArray = explode(" ", $foodName);

    if (in_array($categNumber, $notPrefStrings)) {
      continue;
    }


    //energy ratio give the ratio of energy relative to the required energy rae per meal for 1 servin
    $energyRatio = ($foods[$i]["energy"]) / $TEEperMeal;
    //check whether the energy ratio is equal to 0 or not
    if ($energyRatio == 0) {
      continue;
    } else {
      //filter that can't use as main meals
      if ($foodCategory == "Yogurt, Greek") {
        continue;
      }
      //serving ratio gives the multiplication no.for single serving to match the total energy requirement per meal.
      $servingRatio = (1 / ($energyRatio * 100)) * 100;

      //protein, carn and fat containing in the meal that gives the total energy requirement per meal
      $proteinContain = ($foods[$i]["protein"]) * $servingRatio;
      $carbContain = ($foods[$i]["carbohydrate"]) * $servingRatio;
      $fatContain = ($foods[$i]["fat"]) * $servingRatio;

      //check total protein and carbs contain will be > 86% or less than 98% of the total protein and carbs requirement per day.
      if (($proteinContain >= ((0.8 * $proteinTot) / 3)) && ($proteinContain <= ((0.98 * $proteinTot) / 3))) {
        if (($fatContain >= ((0.7 * $fatTot) / 3)) && ($fatContain <= ((0.98 * $fatTot) / 3))) {
          if (($carbContain >= ((0.8 * $carbTot) / 3)) && ($carbContain <= ((1.02 * $carbTot) / 3))) {
            if ($servingRatio < 6) {
              $foods[$i]['sRatio'] = $servingRatio;
              array_push($mainMeals, $foods[$i]);
            }
          }
        }
      }
    }


    if ($ncds == 5 && ($foodCategory == "Tea" || $foodCategory == "coffee")) {
      continue;
    }
    //energy ratio give the ratio of energy relative to the required energy rae per meal for 1 servin
    $energyRatio = ($foods[$i]["energy"]) / $TEEperSnack;
    //check whether the energy ratio is equal to 0 or not
    if ($energyRatio == 0) {
    } else {
      //serving ratio gives the multiplication no.for single serving to match the total energy requirement per meal.
      $servingRatio = (1 / ($energyRatio * 100)) * 100;

      //protein, carn and fat containing in the meal that gives the total energy requirement per meal
      $proteinContain = ($foods[$i]["protein"]) * $servingRatio;
      $carbContain = ($foods[$i]["carbohydrate"]) * $servingRatio;
      $fatContain = ($foods[$i]["fat"]) * $servingRatio;
      if ($foods[$i]["sodium"] < 33.33 && ($servingRatio * 100 < 100)) {
        $foods[$i]['sRatio'] = $servingRatio;
        array_push($snacks, $foods[$i]);
      }
    }
  }
  if (count($mainMeals) == 0) {
    echo '<script>window.location.replace("http://localhost/dietYou/nomeals.php");</script>';
  }

  $start_time = microtime(true);
  // Create an array to hold all the possible combinations
  function factorial($n)
  {
    if ($n == 0)
      return 1;
    return $n * factorial($n - 1);
  }

  $totCombinations = factorial(count($mainMeals)) / (factorial(3) * (factorial(count($mainMeals) - 3)));

  $combinations = [];

  // Keep generating combinations until all possible combinations are found
  $countingNumber = 0;
  if ($totCombinations > 5000) {
    $countingNumber = 5000;
  } else {
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





  $mealPackages = [];
  //filter meals for ncds
  foreach ($combinations as $mealPack) {
    if ($ncds == 2 || $ncds == 1 || $ncds == 5) {
      $totSodium = 0;
      $totProtein = 0;
      foreach ($mealPack as $meal) {
        $servingRatio = $meal["sRatio"];
        $sodium = $meal["sodium"] * $servingRatio;
        $protein = $meal["protein"] * $servingRatio;
        $totSodium = $totSodium + $sodium;
        $totProtein = $totProtein + $protein;
      }
      if ($totSodium < 1900 && $totProtein > 60) {
        array_push($mealPackages, $mealPack);
      }
    }
    if ($ncds == null) {
      array_push($mealPackages, $mealPack);
    }
  }

  $totCombinations = factorial(count($snacks)) / (factorial(3) * (factorial(count($snacks) - 3)));
  $sCombinations = [];

  // Keep generating combinations until all possible combinations are found
  $countingNumber = 0;
  if ($totCombinations > 5000 || is_nan($totCombinations)) {
    $countingNumber = 5000;
  } else {
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

  sleep(1);
  $dietPlans = [];
  $start_time = microtime(true);
  foreach ($mealPackages as $meals) {
    $dailyMProtein = 0;
    $dailyMFat = 0;
    foreach ($meals as $meal) {
      $serving = $meal["sRatio"];
      $mealFat = $meal["fat"] * $serving;
      $mealProtein = $meal["protein"] * $serving;

      $dailyMFat = $dailyMFat + $mealFat;
      $dailyMProtein = $dailyMProtein + $mealProtein;
    }
    foreach ($sCombinations as $totSnacks) {
      $dailySFat = 0;
      $dailySProtein = 0;
      foreach ($totSnacks as $snack) {
        $serving = $snack["sRatio"];
        $snackFat = $snack["fat"] * $serving;
        $snackProtein = $snack["protein"] * $serving;
        $dailySFat = $dailySFat + $snackFat;
        $dailySProtein = $dailySProtein + $snackProtein;
      }
      $dailyTFat = $dailyMFat + $dailySFat;
      $dailyTProtein = $dailyMProtein + $dailySProtein;
      if ((($dailyTProtein >= $proteinTot * 1) && ($dailyTProtein < $proteinTot * 1.15)) &&  (($dailyTFat >= $fatTot * 1) && ($dailyTFat < $fatTot * 1.15))) {
        $dietPack = [$meals, $totSnacks];
        array_push($dietPlans, $dietPack);
      }
    }
  }

  if (count($dietPlans) == 0) {
    echo '<script>window.location.replace("http://localhost/dietYou/nomeals.php");</script>';
  } else {
  }

  $finalDPlans = [];
  $start_time = microtime(true);
  $finalDPlans = [];

  microFilter100($finalDPlans, $dietPlans, $age, $gender);
  if (count($finalDPlans) > 3) {
  } else {
    $finalDPlans = [];
    microFilter75($finalDPlans, $dietPlans, $age, $gender);
    if (count($finalDPlans) > 3) {
    } else {
      $finalDPlans = [];
      microFilter50($finalDPlans, $dietPlans, $age, $gender);
      if (count($finalDPlans) > 3) {
      } else {
        $finalDPlans = [];
        microFilter30($finalDPlans, $dietPlans, $age, $gender);
        if (count($finalDPlans) > 3) {
        } else {
          $finalDPlans = [];
          microFilter25($finalDPlans, $dietPlans, $age, $gender);
        }
      }
    }
  }
  if (count($finalDPlans) < 3) {
    $finalDPlans = $dietPlans;
  }

  if (count($finalDPlans) == 0) {
    die("no diet plans");
    echo '<script>window.location.replace("http://localhost/dietYou/nomeals.php");</script>';
  } else {
    $estimatedWloss = 0;
    if ($TEEreduction != 0) {
      $estimatedWloss = ($TEEreduction * 7) / 7500;
    }

    $userId = findUser($username, $connection);
    $limit = 0;
    if (count($finalDPlans) > 500) {
      $limit = 500;
    } else {
      $limit = count($finalDPlans);
    }

    // }
    $date = new DateTime();

    // Format the date as a string
    $dateString = $date->format('Y-m-d H:i:s');

    $jsonPlans = json_encode($finalDPlans);
  }
  mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DietYou</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.3/bootstrap-table.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/mealGenerate.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form id="myForm">
          <table id="table" data-toggle="table" data-search="true" data-search-highlight="true">
            <thead>
              <tr>
                <th data-field="id" rowspan="2"></th>
                <th colspan="3" class="center-header">Meals</th>
                <th colspan="3" class="center-header">Snacks</th>
              </tr>
              <tr>
                <th data-field="meal1">Meal 1</th>
                <th data-field="meal2">Meal 2</th>
                <th data-field="meal3">Meal 3</th>
                <th data-field="snack1">Snack 1</th>
                <th data-field="snack2">Snack 2</th>
                <th data-field="snack3">Snack 3</th>
              </tr>
            </thead>
            <tbody>
              <?php
              for ($i = 0; $i < $limit; $i++) {
                echo '<tr>';
                echo '<td><input type="checkbox" id="', $i, '"></td>';
                echo '<td>', $dietPlans[$i][0][0]["name"], '</td>';
                echo '<td>', $dietPlans[$i][0][1]["name"], '</td>';
                echo '<td>', $dietPlans[$i][0][2]["name"], '</td>';
                echo '<td>', $dietPlans[$i][1][0]["name"], '</td>';
                echo '<td>', $dietPlans[$i][1][1]["name"], '</td>';
                echo '<td>', $dietPlans[$i][1][2]["name"], '</td>';
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>
          <input class="btn btn-warning rounded-pill px-4 py-1.5 text-white" type="button" id="dietSubmit" value="Submit" />
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.3/bootstrap-table.min.js"></script>
  <!-- <script src="assets/js/mealGenarate.js"></script> -->
  <script>
    // Parse the JSON object into a JavaScript array
    // jsArray = [];
    // console.log(wLoss);
    // Log the JavaScript array to the console

    // var checkedIDs = [];

    // $('input[type=checkbox]').change(function() {
    //   var checkboxID = $(this).attr('id');

    //   if ($(this).is(':checked')) {
    //     checkedIDs.push(checkboxID);
    //   } else {
    //     var index = checkedIDs.indexOf(checkboxID);
    //     checkedIDs.splice(index, 1);
    //   }

    //   console.log(checkedIDs); // display the array of checked IDs in the console
    // });
    $('#dietSubmit').on('click', function(e) {
      e.preventDefault(); // prevent default form submission
      dietArry = JSON.parse('<?php echo $jsonPlans; ?>');
      // console.log(test[0])
      planIdArry = [];
      $("input[type=checkbox]:checked").each(function() { // loop through all checked checkboxes
        planId = parseInt($(this).attr("id"));
        mealArry = [];
        snckArry = [];
        for (n = 0; n < 3; n++) {
          mealId = dietArry[planId][0][n]["food_code"] + "-" + dietArry[planId][0][n]['sRatio'];
          snckId = dietArry[planId][1][n]["food_code"] + "-" + dietArry[planId][1][n]['sRatio'];
          mealArry.push(mealId);
          snckArry.push(snckId);
        }
        finalMeal = [mealArry.toString(), snckArry.toString()];
        planIdArry.push(finalMeal);
        // checkedIds.push(mealArry[planId]); // add checked ID to array
      });
      $.ajax({
        type: "POST",
        url: "dietplans.php",
        data: {
          checkedIds: planIdArry
        },
        success: function(response) {
          if (response == "success") {
            window.location.replace("dashboard.php");
          }
        }
      });
    });
  </script>
</body>

</html>