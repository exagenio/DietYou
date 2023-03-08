<?php
  include "backend/functions.php"; 
  session_start();
  $username = $_SESSION['username'];
echo $_SESSION["userVerified"];

  if($_POST["submit"]){
      $age = $_POST["age"];
      $gender = $_POST["gender"];
      $height = $_POST["height"];
      $weight = $_POST["weight"];
      $ncd = $_POST["ncd"];
      $activityFactor = $_POST["activityFactor"];
      $workout = $_POST["workout"];
      $foodType = $_POST["foodType"];
      $vegetables =$_POST["vegetables"];
      $meat =$_POST["meat"];
      echo $age;
      echo $vegetables;
      echo $meat;


      // $find = "SELECT password FROM users where email = '$username'";
      // $findQuery = mysqli_query($connection, $find);
      // $row = mysqli_fetch_row($findQuery);
      // if (mysqli_num_rows($findQuery) == 0) {

      // } else {
      // }
  }
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
    <link rel="stylesheet" href="assets/css/form.css">
</head>
<body>
    <nav class="container">
        <div class="row py-3">
            <div class="col-4 d-flex justify-content-start align-items-center">
                <i class="feather mx-2" data-feather="menu"></i>
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


    <section class="d-flex py-4 align-items-center justify-content-center background-dark ">
        
        
        <div class="py-4 formQuestion">
            <div class="text-center">
                <h3>What is the Best diet for Me? </h3>
                <p> Stop guessing when it comes to your eating plan. 
                    Take this quick quiz to get matched with a meal plan that will finally get you results.
                </p>
            </div>
            <hr>
            <!-- start -->
            <form class="question-form text-center h5 d-flex flex-column justify-content-center form-wrap" action="form.php" method="post" autocomplete="on" >
              
                <label for="gender" class="form-label">What is your gender?</label>
                <select class="form-control bg-transparent border border-secondary" id="" name="gender" aria-label="Default select example" required>
                  <option selected disabled></option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
                    <br>

                <label for="age" class="form-label">What is your age?</label>
                <input type="number" class="form-control" id="" name="age" placeholder="must be an integer" required>
                  <br>

                <label for="height" class="form-label">What is your height?</label>
                <div class="input-group">
                    
                    <input type="number" aria-label="Ft" class="form-control" placeholder="cm" id="" name="height" required>
                  </div>
                  <br>

                  <label for="weight" class="form-label">What is your weight?</label>
                  <div class="input-group">
                    
                    <input type="number" aria-label="kg" class="form-control" placeholder="Kg" id="" name="weight" required>
                  </div>
                  <br>

                  <label for="NCD" class="form-label">What NCD do you have? </label>
                  <select class="form-control bg-transparent border border-secondary" aria-label="Default select example" id="" name="ncd" required>
                    <option selected disabled></option>
                    <option value="1">Diabetes</option>
                    <option value="2">Hyper Tension</option>
                    <option value="3">Osteoarthritis</option>
                    <option value="4">Rheumatoid Arthritis</option>
                    <option value="5">Elevated blood cholesterol</option>
                    <option value="6">Other</option>
                    <option value="7">none</option>
                  </select>
                  <br>
<!-- 
                  <label for="sleep" class="form-label">How much sleep do you get?</label>

                  <select class="form-control bg-transparent border border-secondary" aria-label="Default select example" id="" name="" required>
                    <option selected disabled></option>
                    <option value="1">Fewer than 5 hours</option>
                    <option value="2">Between 5 and 6 hours</option>
                    <option value="3">Between 7 and 8 hours</option>
                    <option value="4">Over 8 hours</option>
                  </select>
                  <br> -->
                  <label for="level" class="form-label">What is your fitness level?</label>

                  <select class="form-control bg-transparent border border-secondary" aria-label="Default select example" name="activityFactor" required>
                    <option selected disabled></option>
                    <option value="1">Beginner - I’m new to fitness</option>
                    <option value="2">Intermediate - I work out 2-3 times a week</option>
                    <option value="3">Advanced - I have regular workouts</option>
                  </select>
                  <br>
                  <!-- <label for="work" class="form-label">How much time do you want to workout?</label>

                  <select class="form-control bg-transparent border border-secondary" aria-label="Default select example" id="" name="" required>
                    <option selected disabled></option>
                    <option value="1">Let DietMe decide</option>
                    <option value="2">10-15 min</option>
                    <option value="3">15-25 min</option>
                    <option value="4">30+ min</option>
                  </select>
                  <br> -->
                  <label for="meal" class="form-label">What type of food do you eat? </label>

                  <fieldset class="form-control bg-transparent border border-secondary d-flex ">
                    <div>
                      <input style="height: fit-content;" type="checkbox" id="" name="vegetables" checked>
                      <label for="">Vegetables</label>
                    </div>
                
                    <div>
                      <input style="height: fit-content;" type="checkbox" id="" name="fruits">
                      <label for="">Fruits</label>
                    </div>

                    <div>
                      <input style="height: fit-content;" type="checkbox" id="" name="eggs">
                      <label for="">Eggs</label>
                    </div>

                    <div>
                      <input style="height: fit-content;" type="checkbox" id="" name="fish">
                      <label for="">Fish</label>
                    </div>

                    <div>
                      <input style="height: fit-content;" type="checkbox" id="" name="meat">
                      <label for="">Meat</label>
                    </div>

                    <div>
                      <input style="height: fit-content;" type="checkbox" id="" name="diary">
                      <label for="">Diary <br> Products</label>
                    </div>

                  </fieldset>
                  
                  <br>

                  <div class="col-auto">
                    <input name="submit" type="submit"class="btn secndry-btn my-4 form-control">
                  </div>
                  
            </form>
           <!-- end -->
            
        </div>
    </section>

    <footer class="d-flex flex-column align-items-center justify-content-center container py-4">
        <div class="my-2">
            <img src="assets/img/logo-min.png" height="80" alt="logo">
        </div>
        <!-- <div class="my-4">
            <a class="mx-2" href="#">About Us</a>
            <a class="mx-2" href="#">Contact Us</a>
            <a class="mx-2" href="#">Team</a>
        </div> -->
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
</body>
</html>
