<?php 
include "backend/functions.php"; 
include "backend/crypt.php"
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
    <link rel="stylesheet" href="assets/css/login.css">
    <?php
        include 'tests/browser-detection.php';
        include 'tests/javascript-detection.php';
    ?>
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
        <div class="py-4 formMainWrap">
            <h1>Login</h1>
            <p>New to DietYou? <span><a href="">Signup</a></span></p>
            <?php
                if($_POST["submit"]){
                    include "backend/db.php";
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $find = "SELECT password FROM users where email = '$username'";
                    $findQuery = mysqli_query($connection, $find);
                    $row = mysqli_fetch_row($findQuery);
                    if (mysqli_num_rows($findQuery) == 0) {
                        echo ' <div class="alert alert-danger" role="alert"> Invalid username or a password. Please try again!</div>';
                    } else {
                        $hash = $row["password"];
                    if (validate_pw($password,$row[0])) {
                        session_start();
                        $_SESSION["username"] = "$username";
                        $_SESSION["userVerified"] = true;
                        mysqli_close($connection);
                        header('Location: http://localhost/dietYou/dashboard.php');
                    } else {
                        echo ' <div class="alert alert-danger" role="alert"> Invalid username or a password. Please try again!</div>';
                    }
                    }
                    mysqli_close($connection);
                }
            ?>
            <form class="login-form" action="login.php" method="post">
                <div class="d-flex flex-column justify-content-center form-wrap">
                    <input type="email" name="username" id="" placeholder="Email">
                    <input type="password" name="password" id="" placeholder="Password">
                    <a href="http://">Forgot your password?</a>
                    <input type="submit" name="submit" class="btn secndry-btn my-4">
                </div>
            </form>
            <div class="row d-flex justify-content-center align-items-center">
                <hr class="col-5">
                <p class="col-2 text-center">OR</p>
                <hr class="col-5">
            </div>
            <div class="d-flex flex-column justify-content-center form-wrap">
                <button class="btn alt-btn mb-2 d-flex justify-content-start align-items-center"><img height="35" src="assets/img/Google.png" alt="google">  Continue with Google</button>
                <button class="btn alt-btn mb-2 d-flex justify-content-start align-items-center"><img height="35" src="assets/img/fb.png" alt="google">  Continue with Facebook</button>
                <button class="btn alt-btn mb-2 d-flex justify-content-start align-items-center"><img height="35" src="assets/img/apple.png" alt="google">  Continue with Apple</button>
            </div>
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
