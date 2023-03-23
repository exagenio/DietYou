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
    
</head>

<body>
    <nav class="header sticky-top px-4">
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

    <!-- side nav -->
    <div>
        <nav class="sidenav">
            <ul>
                <!-- <li>
                    <a href="#">
                        <i data-feather="menu"></i>
                        <span class="nav-item">DietYou</span>
                    </a>
                </li> -->
                <li><a href="#">
                        <i data-feather="home"></i>
                        <span class="nav-item">Home</span>
                    </a></li>
                <li><a href="#">
                        <i data-feather="user"></i>
                        <span class="nav-item">Profile</span>
                    </a></li>
                <li><a href="#">
                        <i data-feather="paperclip"></i>
                        <span class="nav-item">Guides</span>
                    </a></li>
                <li><a href="#">
                        <i data-feather="book-open"></i>
                        <span class="nav-item">Meal Plans</span>
                    </a></li>
                <li><a href="#">
                        <i data-feather="clipboard"></i>
                        <span class="nav-item">Exercise</span>
                    </a></li>
                <li><a href="#">
                        <i data-feather="settings"></i>
                        <span class="nav-item">Settings</span>
                    </a></li>
                <li><a href="#">
                        <i data-feather="help-circle"></i>
                        <span class="nav-item">Help</span>
                    </a></li>
                <li><a href="#" class="log-in">
                        <i data-feather="log-in"></i>
                        <span class="nav-item">Log In</span>
                    </a></li>
            </ul>
        </nav>
    </div>


    <!--first body part-->
    <section class="background-dark pt-4">
        <div class="container pt-4">
            <div class="row" style="height: 500px;">
                <div class="col d-flex align-items-center justify-content-center">
                    <div>
                        <h1>Enjoy a Healthy</h1>
                        <h1>Life Without</h1>
                        <h1>NCDs</h1>
                        <div style="padding: 25px 0px;">
                            <h5>Let yourself be guided by out experts</h5>
                            <h5>and your wellness goals will be within reach</h5>
                        </div>
                        <button type="button" class="btn btn-warning rounded-pill px-4 py-1.5 text-white" style="font-weight: 700">Sign In</button>
                        <p style="font-size:x-small; padding: 15px 0px;;">It's quick and <b>free</b>
                        <p>
                    </div>
                </div>
                <div class="col d-flex align-items-center ">
                    <img src="assets/img/pic-1.png" width="80%" alt="Stayfit" class="p-3">

                    <!--add position relative or absolute and bring the picture close the the text if desired-->
                </div>
            </div>
        </div>
    </section>

    <!-- second part of the home page -->
    <section class="background-dark pt-2">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                <div class="my-2 text-center">
                    <p style="font-weight: bolder;">How it works</p>
                    <p style="font-size: 30px; color: gray;">You Tell Us Your Goals</p>
                    <p style="font-size: 30px; font-weight: bolder;">We'll Help You Get There</p>
                </div>
                <div class="row m-5 text-center">
                    <div class="col">
                        <img src="assets/img/pic-2.png" class="rounded-image" width="100%" style="height: 200px; width: 300px;" alt="">
                        <p class="process-title">Take the quiz</p>
                        <p class="pt-4 process-subtitle">The free quiz only takes a few minutes </p>
                    </div>
                    <div class="col">
                        <img src="assets/img/pic-3.png" class="rounded-image" width="100%" style="height: 200px; width: 300px;" alt="">
                        <p class="process-title">Get your personalized <br>plan</p>
                        <p class="process-subtitle">We'll create a meal plan that matches your preference and needs </p>
                    </div>
                    <div class="col">
                        <img src="assets/img/pic-4.png" class="rounded-image" width="100%" style="height: 200px; width: 300px;" alt="">
                        <p class="process-title">Take it one step at <br>a time</p>
                        <p class="process-subtitle">Our expert guidance keeps you right on track </p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Section 3 of the home page -->
    <section class="background-dark pt-2">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                <button type="button" class="btn btn-warning rounded-pill px-4 py-1.5 text=white" style="font-weight: 700">Get Started</button>
                <div class="my-4 text-center">
                    <p style="font-weight: bolder;">WHY US?</p>
                    <p style="font-size: 30px; font-weight: bolder;">What to expect from us</p>
                </div>
                <div class="row m-0 text-center">
                    <div class="col">
                        <img src="assets/img/louis-hansel-MlPD-AzZYMg-unsplash-min.jpg" class="rounded-image" alt="Image" style="width:400px; height:200px">
                    </div>
                    <div class="col" style="text-align: left;">
                        <p style="font-weight: bolder;" class="ehead">Discover the food<br>that works for you</p>
                        <p class="edesc">We are committed to providing high-quality service and <br>customer satisfaction. Our team is dedicated to making <br> sure that each customer receives the attention and care they deserve.</p>
                    </div>
                </div>
                <div class="row m-5 text-center">
                    <div class="col">
                        <img src="assets/img/8C7DDB37-8102-489B-8106-ACD0B86D2BB0-768x1024 1.jpg" class="rounded-image" alt="Image" style="width:400px; height:200px">
                    </div>
                    <div class="col" style="text-align: left;">
                        <p style="font-weight: bolder;" class="ehead">Find diet plan based<br>on your location</p>
                        <p class="edesc">Discover the best food for your area and get a personalized diet plan.</p>
                    </div>
                </div>
                <div class="row m-5 text-center">
                    <div class="col">
                        <img src="assets/img/bruce-mars-gJtDg6WfMlQ-unsplash 1.jpg" class="rounded-image" alt="Image" style="width:400px; height:200px">
                    </div>
                    <div class="col" style="text-align: left;">
                        <p style="font-weight: bolder;" class="ehead">Find Workouts that<br>suits you</p>
                        <p class="edesc">Get a unique workout plan that is tailoredto your desired needs</p>
                    </div>


                </div>

            </div>
    </section>

    <!-- Section 3 of the home page
    <section class="background-dark pt-3">
        <div class="container-pt2">
            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                <button type="button" class="btn btn-warning rounded-pill px-4 py-1.5 text=white" style="font-weight: 700">Get Started</button>
            </div>
            <div class="my-2 text-center">
                <p style="font-weight: bolder;">WHY US?</p>
                <p style="font-size: 30px; font-weight: bolder;">What to expect from us</p>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-center my-4">
                <div class="expect" style="text-align: center;">
                    <img src="assets/img/louis-hansel-MlPD-AzZYMg-unsplash-min.jpg" class="rounded-image" alt="Image" style="width:400px; height:200px">
                </div>
                <div class="expecttext">
                    <p style="font-weight: bolder;" class="ehead">Discover the food<br>that works for you</p>
                    <p class="edesc">We are committed to providing high-quality service and <br>customer satisfaction. Our team is dedicated to making sure that<br> each customer receives the attention and care they deserve.</p>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-center my-4">
                <div class="expect" style="text-align: center;">
                    <img src="assets/img/8C7DDB37-8102-489B-8106-ACD0B86D2BB0-768x1024 1.jpg" class="rounded-image" alt="Image" style="width:400px; height:200px">
                </div>
                <div class="expecttext">
                    <p style="font-weight: bolder;" class="ehead">Find diet plan based<br>on your location</p>
                    <p class="edesc">Discover the best food for your area and get a personalized diet <br>plan.</p>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-center my-4">
                <div class="expect" style="text-align: center;">
                    <img src="assets/img/bruce-mars-gJtDg6WfMlQ-unsplash 1.jpg" class="rounded-image" alt="Image" style="width:400px; height:200px">
                </div>
                <div class="expecttext">
                    <p style="font-weight: bolder;" class="ehead">Find Workouts that<br>suits you</p>
                    <p class="edesc">Get a unique workout plan that is tailoredto your desired needs</p>
                </div>
            </div>
    </section> -->

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