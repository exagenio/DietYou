<?php
include "backend/db.php"; 
include "classes/User.php";
session_start();
if(islogged(isset($_SESSION['username']),$_SESSION["userVerified"])){

}else{
    echo'<script>window.location.replace("login.php");</script>';
}


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
    mysqli_close($connection);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/indi_dietplan.css">
</head>
<body>
<?php include "includes/header.php";?>
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
<?php include "includes/footer.php";?>  
</body>
</html>