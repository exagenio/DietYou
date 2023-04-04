<?php
include "classes/User.php";
session_start();
if ((isset($_SESSION['username'])) && $_SESSION["userVerified"] == 1) {
    //logged in
  } else {
    // Session variable is not set
  echo'<script>window.location.replace("http://localhost/dietYou/login.php");</script>';
  }
include "backend/db.php"; 
if(isset($_GET['id'])){
    $exId = $_GET['id'];
    $username = $_SESSION['username'];

    //get the user data by creating a user object
    $user = new User($username, $connection);
    $ncds = $user->getNcds();

    $query = "SELECT * FROM exercises WHERE id = '$exId'";
        //get the result according to the query
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("error");
    }
    $exercise = mysqli_fetch_assoc($result);

    $ncdRestrict = explode(",",$exercise["restriction"]);
    if(in_array($ncds, $ncdRestrict)){
        die("error");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plan</title>
    <link rel="stylesheet" href="assets/css/indi_dietplan.css">
</head>
<body>

    <div class="container">
        <div class="heading">
            <h1><?php echo $exercise["name"]; ?></h1>
            <h3><?php echo $exercise["time"]?> min</h3>
        </div>
        <div class="ingredient">
            <?php 
            echo "<img src='assets/img/Exercices/".$exId.".gif' alt='".$exercise["name"]."'";
            ?>
        </div>
    </div>
    
</body>
</html>