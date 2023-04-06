<?php 
include "backend/db.php"; 
include "backend/functions.php";
$foodId = $_GET['food'];
$ratio = $_GET['ratio'];
session_start();
if(islogged(isset($_SESSION['username']),$_SESSION["userVerified"])){
    
}else{
    echo'<script>window.location.replace("login.php");</script>';
}

if(isset($_GET['food']) && isset($_GET['ratio'])){
    $foodId = $_GET['food'];
    $ratio = $_GET['ratio'];
    $query = "SELECT food_code, name, ingredient_description, ingredient_weight_g, country FROM ingredients WHERE food_code = $foodId";
     //get the result according to the query
    $result = mysqli_query($connection, $query);

    // Initialize an empty array to store the rows of the filtered food table
    $ingredients = array();

    // Fetch each row of data and add it to the array
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($ingredients, $row);
    }
    if(count($ingredients) == 0 ){
        die("no ingredients -  error");
    }

    $query = "SELECT weight FROM foods WHERE food_code =$foodId";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("error");
    }
    $weight = mysqli_fetch_assoc($result);
    $weightR = $weight["weight"]*round($ratio, 1);
    $unit;
    if($ingredients[0]["country"] == "usa"){
        $unit = "g";
    }else{
        $unit = "portion";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/indi_dietplan.css">
</head>
<body>
    <?php include "includes/header.php";?>
    <div>
        <div class="heading p-4">
            <div class="container">
            <h1><?php echo $ingredients[0]["name"]; ?></h1>
            <h3><?php echo $weightR?>g</h3>
            </div>
        </div>
        <div class="ingredient p-4">
            <div class="container">
            <h2>INGREDIENTS:</h2>
            <ul>
            <?php
            foreach ($ingredients as $ingredient) {
                echo "<li>".$ingredient["ingredient_description"]." - ".$ingredient["ingredient_weight_g"]*$ratio.$unit."</li>";
            }
            ?>
            </ul>
            </div>
        </div>
    </div>
    <?php include "includes/footer.php";?>
</body>
</html>