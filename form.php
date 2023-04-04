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
//get submitted data
if (isset($_POST["submit"])) {
  $age = $_POST["age"];
  $gender = $_POST["gender"];
  $height = $_POST["height"];
  $weight = $_POST["weight"];
  $ncd = $_POST["ncd"];
  $activityFactor = $_POST["activityFactor"];

  //get the allergies array and convert it into a string
  $allergyString = null;
  if (isset($_POST["allergies"])) {
    $allergyArray = $_POST["allergies"];
    $allergyString = implode(',', $allergyArray);
  }

  //get the country array and convert it into a string 
  $countryString = null;
  if (isset($_POST["country"])) {
    $countryArray = $_POST["country"];
    $countryString = implode(',', $countryArray);
  }

  //get the preferences array and convert it into a string
  $preferenceString = null;
  if (isset($_POST["preference"])) {
    $preferenceArray = $_POST["preference"];
    $preferenceString =  implode(',', $preferenceArray);
  }
  //validate the id of the user
  $id = findUser($username, $connection);

  //update query
  $updateQuery = <<<SQL
  UPDATE users SET
  height = '$height',
  weight = '$weight',
  gender = '$gender',
  age = '$age',
  activityFactor = '$activityFactor',
  ncds = '$ncd',
  country = '$countryString',
  preferences = '$preferenceString',
  allergies = '$allergyString'
  WHERE id = '$id';
  SQL;

  $resultUpdate = mysqli_query($connection, $updateQuery);
  if (!$resultUpdate) {
    die("Error creating tables: " . mysqli_error($connection));
  } else {
    header('Location: http://localhost/dietYou/mealGenerate.php');
  }
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
      <form class="question-form text-center h5 d-flex flex-column justify-content-center form-wrap" action="form.php" method="post" autocomplete="on">

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
          <option value="5">Heart failure</option>
          <option value="null">none</option>
        </select>
        <br>

        <label for="level" class="form-label">What is your fitness level?</label>

        <select class="form-control bg-transparent border border-secondary" aria-label="Default select example" name="activityFactor" required>
          <option value="1.2">Sedentary: Little or no exercise, desk job or mostly sitting activities</option>
          <option value="1.375">Lightly active: Light exercise or sports 1-3 days per week, some walking during the day. </option>
          <option value="1.55">Moderately active: Moderate exercise or sports 3-5 days per week, active job or daily activities that require more movement.</option>
          <option value="1.725">Very active: Hard exercise or sports 6-7 days per week, physically demanding job, or training for a sports event. </option>
          <option value="1.9">Extremely active: Hard daily exercise or sports and physical job, or training for an athletic competition multiple times per day.</option>
        </select>
        <br>

        <label for="meal" class="form-label">What type of food do you <strong>not like</strong> eat? </label>

        <fieldset class="form-control bg-transparent border border-secondary d-flex ">
          <div>
            <input style="height: fit-content;" type="checkbox" id="" name="preference[]" value="vege" checked>
            <label for="">Vegetables</label>
          </div>

          <div>
            <input style="height: fit-content;" type="checkbox" id="" name="preference[]" value="fruits">
            <label for="">Fruits</label>
          </div>

          <div>
            <input style="height: fit-content;" type="checkbox" id="" name="preference[]" value="eggs">
            <label for="">Eggs</label>
          </div>

          <div>
            <input style="height: fit-content;" type="checkbox" id="" name="preference[]" value="fish">
            <label for="">seafood</label>
          </div>

          <div>
            <input style="height: fit-content;" type="checkbox" id="" name="preference[]" value="meat">
            <label for="">Meat</label>
          </div>

          <div>
            <input style="height: fit-content;" type="checkbox" id="" name="preference[]" value="diary">
            <label for="">Diary <br> Products</label>
          </div>

        </fieldset>

        <br>

        <label for="allergies" class="form-label">What kind of allergies you have?</label>
        <fieldset class="form-control bg-transparent border border-secondary d-flex">
          <div>
            <input style="height: fit-content;" type="checkbox" id="" value="lactose-intolerance" name="allergies[]">
            <label for="">Lactose intolerance</label>
          </div>
          <div>
            <input style="height: fit-content;" type="checkbox" id="" value="fructose-intolerance" name="allergies[]">
            <label for="">Fructose intolerance</label>
          </div>
          <div>
            <input style="height: fit-content;" type="checkbox" id="" value="galactosemia" name="allergies[]">
            <label for="">Galactosemia</label>
          </div>
        </fieldset>
        <br>
        <label for="country" class="form-label">What country foods do you prefer?</label>
        <fieldset class="form-control bg-transparent border border-secondary justify-content-center d-flex">
          <div>
            <input style="height: fit-content;" type="checkbox" id="" value="united states" name="country[]">
            <label for="">United States</label>
          </div>
          <div>
            <input style="height: fit-content;" type="checkbox" id="" value="sri lanka" name="country[]">
            <label for="">Sri Lanka</label>
          </div>
        </fieldset>

        <div class="col-auto">
          <input name="submit" type="submit" class="btn secndry-btn my-4 form-control">
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script>
    feather.replace()
  </script>
  <script src="assets/js/form.js"></script>
</body>

</html>