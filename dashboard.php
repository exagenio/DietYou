<?php
include "backend/db.php";
include "classes/User.php";
//set session values
session_start();
//check the login status of the user

if (islogged(isset($_SESSION['username']), $_SESSION["userVerified"])) {
} else {
    echo '<script>window.location.replace("login.php");</script>';
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
$user = new User($username, $connection);
if (isset($_POST['submit'])) {
    $fileDestination;
    $isUploaded = false;
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileParts = explode('.', $fileName);
    $fileExt = strtolower(end($fileParts));
    // $fileExt = strtolower(end(explode('.',$fileName)));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $isUploaded = true;
                echo "File uploaded successfully!";
            } else {
                echo "File size too large.";
            }
        } else {
            echo "There was an error uploading the file.";
        }
    } else {
        echo "You cannot upload files of this type.";
    }
    if ($isUploaded) {
        // Path to Rscript executable
        $rscript_path = "Rscript";

        // R script file path
        $rscript_file = "MLModels/R_OCR.R ";

        // Arguments to pass to R script
        $arg1 = $fileDestination;

        // Command to execute
        $command = "{$rscript_path} {$rscript_file} {$arg1}";
?>
<?php
        // outputs the username that owns the running php/httpd process
        // (on a system with the "whoami" executable in the path)
        $output = null;
        $retval = null;
        exec($command, $output, $retval);
        echo "Returned with status $retval and output:\n";
        print_r($output);
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
    <link rel="stylesheet" href="assets/css/dashboard.css">

</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="container overflow-hidden">
        <div class="row">
            <div class="col-md-4 p-4">
                <div class="profile_info row d-flex justify-content-between" id="card">
                    <div class="profile_pic col-3 ">
                        <img src="assets/img/profile_pic.png" alt="profile_pic" width="100px" height="100px">
                    </div>
                    <div class="info col-9">
                        <h3><?php echo $user->getfName(); ?> <?php echo $user->getlName(); ?></h3>
                            <h4>Age: <?php echo $user->getAge(); ?> yrs</h4>
                            <h4>Weight: <?php echo $user->getWeight(); ?> kg</h4>
                            <h4>Height: <?php echo $user->getHeight() ?> cm</h4>
                    </div>
                </div>
                <div class="col d-flex justify-content-center align-items-center mt-4">
                    <div class="caloriePro p-4">
                        <div class="progress-card">
                            <div class="progress2">
                                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <span class="kcalValue"><span id="currentCalories">0</span>/<span id="totalCalories">0</span> Kcal</span>
                                <span id="progressPercentage">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-8 p-4">
                <div class="water_consumption row align-items-center justify-content-center p-2 col-12" id="card">
                    <div class="cups d-flex flex-column align-items-center col-md col-12">
                        <img src="assets/img/glass-of-water.png" alt="water cup">
                        <span class="current-cups">0/10</span>
                    </div>
                    <div class="buttons col-md col-4 d-flex justify-content-center ">
                        <button class="add">+</button>
                    </div>
                    <div class="col-md col-4">
                        <div class="percentage-container d-flex justify-content-center">
                            <span class="current-percentage mb-4">0%</span>
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
                <div class="manualCalIn p-4 col-md-8 mt-2 row" id="card">
                    <h2>Enter Your Calorie Intake</h2>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active btn btn-warning rounded-pill px-4 py-1.5 text-black" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Manual Input</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn btn-warning rounded-pill px-4 py-1.5 text-black" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Scan Label</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form action="dashboard.php" method="post" enctype="multipart/form-data">
                                <input type="text" id="kcal" name="kcal">
                                <label for="kcal">Kcal</label>
                                <input type="button" id="Kcal_add_button" class="btn btn-warning rounded-pill px-4 py-1.5 text-black btnAdd" value="Add">
                            </form>
                            <form action="dashboard.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="image" id="image">
                                <input type="submit" name="submit" class="btn btn-warning rounded-pill px-4 py-1.5 text-black" value="Upload Image">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <?php
    $count = 1;
    //   echo $plans[0]["meals"];
    foreach ($plans as $plan) {
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

        for ($i = 0; $i < 3; $i++) {
            $query = "SELECT name, food_code, weight FROM foods WHERE food_code=$beforeArray[$i]";
            $findQuery = mysqli_query($connection, $query);
            $row = mysqli_fetch_row($findQuery);
            if (mysqli_num_rows($findQuery) == 0) {
                echo "no items <br>";
            } else {
                $weight = $row[2] * round($afterArray[$i], 1);
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


        for ($i = 0; $i < 3; $i++) {
            $query = "SELECT name, food_code, weight FROM foods WHERE food_code=$beforeArray[$i]";
            $findQuery = mysqli_query($connection, $query);
            $row = mysqli_fetch_row($findQuery);
            if (mysqli_num_rows($findQuery) == 0) {
                echo "no items <br>";
            } else {
                $weight = $row[2] * round($afterArray[$i], 1);
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

    <?php include "includes/footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script>
        // Set total calories and current calories
        const totalCalories = 2000;
        let currentCalories = 0;

        // updateProgressBar();

        // Function to update progress bar
        function updateProgressBar() {
            const progressBar = document.getElementById('progressBar');
            const progressPercentage = document.getElementById('progressPercentage');
            const totalCaloriesElement = document.getElementById('totalCalories');
            const currentCaloriesElement = document.getElementById('currentCalories');

            const progress = (currentCalories / totalCalories) * 100;
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            progressPercentage.textContent = progress.toFixed(1) + '%';
            totalCaloriesElement.textContent = totalCalories;
            currentCaloriesElement.textContent = currentCalories;
        }

        // Simulate progress by incrementing current calories
        const interval = setInterval(function() {
            currentCalories += 100;
            if (currentCalories > totalCalories) {
                clearInterval(interval);
            } else {
                updateProgressBar();
            }
        }, 1000);
    </script>
    <script>
        feather.replace()
    </script>
    <script src="assets/js/dashboard.js"></script>
</body>

</html>