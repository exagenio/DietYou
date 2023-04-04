<?php 
    include "backend/db.php"; 
    $foodId = $_GET['food'];
    $ratio = $_GET['ratio'];
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
    <link rel="stylesheet" href="assets/css/indi_dietplan.css">
</head>
<body>

    <div class="container">
        <div class="heading">
            <h1><?php echo $ingredients[0]["name"]; ?></h1>
            <h3><?php echo $weightR?>g</h3>
        </div>
        <div class="ingredient">
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
    
</body>
</html>