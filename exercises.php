<?php
include "backend/db.php"; 
include "classes/User.php";
session_start();
if(islogged(isset($_SESSION['username']),$_SESSION["userVerified"])){

}else{
    echo'<script>window.location.replace("login.php");</script>';
}

$username = $_SESSION['username'];
if(havePlans($username, $connection)){

}else{
  echo'<script>window.location.replace("form.php");</script>';
}

$query = "SELECT * FROM exercises";
//get the result according to the query

// Initialize an empty array to store exeercises
$exercises = array();
$result = mysqli_query($connection, $query);
if(!$result){
die("error");
}
// Fetch each row of data and add it to the array
while ($row = mysqli_fetch_assoc($result)) {
array_push($exercises, $row);
}
$user = new User($username, $connection);
$ncds = $user->getNcds();

$finalExercises = [];
foreach($exercises as $exercise){
    $restrictions = $exercise["restriction"];
    $rArray = explode(",",$restrictions);
    if (!in_array($ncds, $rArray)){
        array_push($finalExercises, $exercise);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/multiex.css">
    
</head>
<body>
    <?php include "includes/header.php"; ?>
    <div class="d-flex justify-content-center align-items-center">
        <div class="exContainer">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    for($i=0; $i<5; $i++){
                        $name = $finalExercises[$i]["name"];
                        $id = $finalExercises[$i]["id"];
                        if($i==0){
                            echo <<<HTML
                            <div class="carousel-item active">
                                <h3 class="text-center">{$name}</h3>
                                <p class="text-center">1 min</p>
                                <img class="d-block w-100 exImage" src="assets/img/Exercices/{$id}.gif" alt="First slide">
                            </div>
                            HTML;
                        }else{
                            echo <<<HTML
                            <div class="carousel-item">
                                <h3 class="text-center">{$name}</h3>
                                <p class="text-center">1 min</p>
                                <img class="d-block w-100 exImage" src="assets/img/Exercices/{$id}.gif" alt="First slide">
                            </div>
                            HTML;
                        }
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <!-- <span class="sr-only mr-4">Previous</span> -->
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <!-- <span class="sr-only">Next</span> -->
                </a>
            </div>
        </div>
    </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
      <script>
          feather.replace()
      </script>
</body>

</html>