<?php
include "backend/db.php"; 
include "classes/User.php";
//set session values
session_start();
//check the login status of the user
if ((isset($_SESSION['username'])) && $_SESSION["userVerified"] == 1) {
  //logged in
} else {
  // Session variable is not set
echo'<script>window.location.replace("http://localhost/dietYou/login.php");</script>';
}
$username = $_SESSION['username'];
$userID = findUser($username, $connection);
$query = "SELECT * FROM mealplans where user=$userID";
$findQuery = mysqli_query($connection, $query);

  // Initialize an empty array to store the rows of the filtered food table
  $plans = array();

  // Fetch each row of data and add it to the array
  while ($row = mysqli_fetch_assoc($findQuery)) {
      array_push($plans, $row);
  }
//   echo $plans[0]["meals"];
    // foreach($plans as $plan){
    //     $originalString = $plan["meals"];
    //     $beforeArray = array();
    //     $afterArray = array();
    //     $items = explode(",", $originalString);
    //     foreach ($items as $item) {
    //     $parts = explode("-", $item);
    //     $beforeArray[] = $parts[0];
    //     $afterArray[] = $parts[1];
    //     }
    //     // print_r($beforeArray);
    //     // print_r($afterArray);    
    //     $meals = implode(",", $beforeArray);
    //     echo $meals, "<br>";
    //     for($i = 0; $i<3; $i++){
    //         $query = "SELECT name, food_code FROM foods WHERE food_code=$beforeArray[$i]";
    //         $findQuery = mysqli_query($connection, $query);
    //         $row = mysqli_fetch_row($findQuery);
    //         if (mysqli_num_rows($findQuery) == 0) {
    //             echo "no items <br>";
    //         } else {
    //             print_r($row);
    //             echo "-",round($afterArray[$i], 1);;
    //             echo "<br>";
    //         }
    //     }
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DietYou</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">

</head>
<body>
    <nav class="header sticky-top px-4">
        <div class="row py-3">
            <div class="col-4 d-flex justify-content-start align-items-center">
                <button class="feather mx-2 menu-button" data-feather="menu" type="button"></button>
                <i class="feather mx-2" data-feather="search"></i>
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center">
                <img src="assets/img/logo-min.png" height="60" alt="logo">
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <button class="btn theme-btn mx-2">Login</button>
                <i class="feather mx-2" data-feather="bar-chart-2"></i>
                <i class="feather mx-2" data-feather="user"></i>

            </div>
        </div>
    </nav>

    <div class="container overflow-hidden">
        <div class="row">
            <div class="col-md-4">
                <div class="profile_info row" id="card">
                    <div class="profile_pic col">
                        <img src="assets/img/profile_pic.png" alt="profile_pic" width="100px" height="100px">
                    </div>
                    <div class="info col">
                        <h1>Daniel Ricciardo</h1>
                        <h4>Age: 32 yrs</h4>
                        <h4>Weight: 68.5 kg</h4>
                        <h4>Height: 6 ft 1 in</h4>
                    </div>
                </div>
            </div>

          
            <div class="col-md-8">
                <div class="water_consumption row align-items-center justify-content-center" id="card">
                    <div class="cups d-flex flex-column align-items-center col-md col-12">
                        <img src="assets/img/glass-of-water.png" alt="water cup">
                        <span class="current-cups">0/10</span>
                    </div>
                    <div class="buttons col-md col-4 d-flex justify-content-center ">
                        <button class="add">+</button>
                    </div> 
                    <div class="col-md col-4">
                        <div class="percentage-container">
                            <span class="current-percentage">0%</span>
                            <div class="progress"></div>
                        </div>
                    </div>

                    <div class="buttons col-md col-4 d-flex justify-content-center">
                        <button class="remove" disabled="">-</button>
                    </div> 

                    <div class="litres col-md col-12 d-flex flex-column align-items-center ">
                        <img src="assets/img/drop.png" alt="water drop">
                        <span class="current-litres">0l/2.5l</span>
                    </div>
                </div>
                <!-- <div class="col">
                    <div class="cal_count" id="card">
                        <div class="cal_progress">
                            <div class="progress"></div>
                        </div>
                        <div class="percentage-cal">0%</div>
                        <div class="gain_cal">0Kcal</div>
                    </div>
                </div> -->
            </div>
        </div>
        
    </div>

    </div>

    <?php 
    $count = 1;
    //   echo $plans[0]["meals"];
    foreach($plans as $plan){
        echo <<<HTML
            <section>
            <h1 class="title">DIET {$count}</h1>
            <div class="container2">
                <div class="main-meals">
                    <h1>MAIN MEALS</h1>
                </div>
                <div class="snacks">
                    <h1>SNACKS</h1>
                </div>
        HTML;
        $originalString = $plan["meals"];
        $beforeArray = array();
        $afterArray = array();
        $items = explode(",", $originalString);
        foreach ($items as $item) {
        $parts = explode("-", $item);
        $beforeArray[] = $parts[0];
        $afterArray[] = $parts[1];
        }
        echo <<<HTML
                <div class="main-recipes">
        HTML;

        for($i = 0; $i<3; $i++){
            $query = "SELECT name, food_code, weight FROM foods WHERE food_code=$beforeArray[$i]";
            $findQuery = mysqli_query($connection, $query);
            $row = mysqli_fetch_row($findQuery);
            if (mysqli_num_rows($findQuery) == 0) {
                echo "no items <br>";
            } else {
                $weight = $row[2]*round($afterArray[$i], 1);
                $ratio = round($afterArray[$i], 1);
                echo <<<HTML
                <div class="diet-1 dietM" id="card2">
                    <a href="ingredients.php?food={$row[1]}&ratio={$ratio}">
                        <h1>{$row[0]}</h1>
                        <h3>{$weight}g</h3>
                    </a>
                </div>
                HTML;
                // print_r($row);
                // echo "-",round($afterArray[$i], 1);;
                // echo "<br>";

            }
        }
        echo <<<HTML
            </div>
            <div class="snacks-recipes">
        HTML;

        $originalString = $plan["snacks"];
        $beforeArray = array();
        $afterArray = array();
        $items = explode(",", $originalString);
        foreach ($items as $item) {
        $parts = explode("-", $item);
        $beforeArray[] = $parts[0];
        $afterArray[] = $parts[1];
        }


        for($i = 0; $i<3; $i++){
            $query = "SELECT name, food_code, weight FROM foods WHERE food_code=$beforeArray[$i]";
            $findQuery = mysqli_query($connection, $query);
            $row = mysqli_fetch_row($findQuery);
            if (mysqli_num_rows($findQuery) == 0) {
                echo "no items <br>";
            } else {
                $weight = $row[2]*round($afterArray[$i], 1);
                $ratio = round($afterArray[$i], 1);
                echo <<<HTML
                <div class="diet-1 dietM" id="card2">
                    <a href="ingredients.php?food={$row[1]}&ratio={$ratio}">
                        <h1>{$row[0]}</h1>
                        <h3>{$weight}g</h3>
                    </a>
                </div>
                HTML;
            }
        }
        echo <<<HTML
            </div>
        </div>
        </section>
        HTML;
        $count++;
    }    

    ?>


    <!-- <section>
        <h1 class="title">DIET 1</h1>
        <div class="container2">
            <div class="main-meals">
                <h1>MAIN MEALS</h1>
            </div>
            <div class="snacks">
                <h1>SNACKS</h1>
            </div>
            <div class="main-recipes">
                
                <div class="diet-1 dietM" id="card2">
                    <a href="#">
                        <h1>CANED WHITE BEANS FAT ADDED</h1>
                        <h3>285g</h3>
                    </a>
                </div>
                <div class="diet-2 dietM" id="card2">
                    <a href="#">
                    <h1>REGULAR OATMEAL WITH MILK</h1>
                    <h3>519g</h3></a>
                </div>
                <div class="diet-3 dietM" id="card2">
                    <a href="#">
                    <h1>INSTANT OATMEAL WITH MILK</h1>
                    <h3>542g</h3></a>
                </div>

            </div>
            <div class="snacks-recipes">
                <div class="snacks-1 dietS" id="card2">
                    <a href="#">
                    <h1>CHEESE COTTAGE LOW FAT & SODIUM</h1>
                    <h3>92g</h3></a>
                </div>
                <div class="snacks-2 dietS" id="card2">
                    <a href="#">
                    <h1>UNSALTED & ROASTED PEANUTS</h1>
                    <h3>11g</h3></a>
                </div>
                <div class="snacks-3 dietS" id="card2">
                    <a href="#">
                    <h1>REDUCED SODIUM CORN COOKED</h1>
                    <h3>72g</h3></a>
                </div>

            </div>

        </div>
    </section> -->
    



    <footer class="d-flex flex-column align-items-center justify-content-center container py-4">
        <div class="my-2">
            <img src="assets/img/logo-min.png" height="80" alt="logo">
        </div>
        
        <div class="my-3">
            <i class="feather mx-4" data-feather="instagram"></i>
            <i class="feather mx-4" data-feather="facebook"></i>
            <i class="feather mx-4" data-feather="youtube"></i>
            <i class="feather mx-4" data-feather="twitter"></i>

        </div>
        <div class="my-2">
            <a class="mx-2 text-decoration-none" href="#">About Us</a>
            <a class="mx-2 text-decoration-none" href="#">Contact Us</a>
            <a class="mx-2 text-decoration-none" href="#">Team</a>
            <a class="mx-2 text-decoration-none" href="http://">Terms and conditions</a>
            <a class="mx-2 text-decoration-none" href="#">Copyright</a>
            <a class="mx-2 text-decoration-none" href="#">Privacy</a>
            <a class="mx-2 text-decoration-none" href="#">Disclaimer</a>
        </div>
        <p class="py-2">DietYou © 2023</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script>
        feather.replace()
      </script>

      <script>
        var open = 0;


        const menu_click = document.querySelector(".menu-button");
        const collapse = document.querySelector(".sidenav");

        menu_click.addEventListener("click",side_bar_collapse(open));

        function side_bar_collapse(open){

            console.log('function')
            
            if(open == 100){
                console.log("xxxx");
                collapse.style.height = "0%";
                open = 0;
            }else if(open == 0){
                console.log("yyy"); 
                collapse.style.height = "100%";
                open = 100;
            }
        }

        
    
       
      </script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
