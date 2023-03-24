<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User DashBoard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script type="text/javascript">
        function menuclick() {
            console.log("pakaya");
            // document.getElementById('sidenav').style.display == 'none';


            // if (menu_true == "true"){
            //     document.getElementById('sidenav').style.display == 'none';
            //     menu_true = "false";
            //     console.log(menu_true);
            // }else{
            //     document.getElementById('sidenav').style.display == 'block';
            //     menu_true = "true";
            //     console.log(menu_true);

            // }
        }
    </script>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>


    <div id="blur_body">
        <nav class="header sticky-top px-4">
            <div class="row py-3">
                <div class="col-4 d-flex justify-content-start align-items-center">
                    <div class="menu">
                        <input type="button" class="feather mx-2" data-feather="menu" onclick="menuclick()"></i>
                    </div>
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

        <!-- background gradient -->
        <div id="grad"></div>



        <div class="profile_info" id="card">
            <div class="profile_pic">
                <img src="assets/img/profile_pic.png" alt="profile_pic" width="100px" height="100px">
            </div>
            <div class="info">
                <h1>Daniel Ricciardo</h1>
                <h4>Age: 32 yrs</h4>
                <h4>Weight: 68.5 kg</h4>
                <h4>Height: 6 ft 1 in</h4>
            </div>
        </div>


        <div class="resipe_cat_card" id="card">
            <h2>Recipe Categories</h2>

            <div class="sub_card_1" id="sub_card" style="position: relative; left: 340px;">
                <a href="#">
                    <div class="reciper_pic"><img src="assets/img/dinner.jpg" alt="dinner" height="100px" width="150px"></div>
                    <h6 style="position: relative; left: 35px; top: 15px;">Dinner</h6>
                </a>
            </div>


            <div class="sub_card_2" id="sub_card" style="position: relative; bottom: 140px; left: 190px;">
                <a href="">
                    <div class="reciper_pic"><img src="assets/img/lunch.jpg" alt="lunch" height="100px" width="150px"></div>
                    <h6 style="position: relative; left: 38px; top: 15px;">Lunch</h6>
                </a>
            </div>

            <div class="sub_card_3" id="sub_card" style="position: relative; bottom: 280px; left:40px">
                <a href="#">
                    <div class="reciper_pic"> <img src="assets/img/breakfast.jpg" alt="breakfast" height="100px" width="150px"></div>
                    <h6 style="position: relative; left: 30px; top: 15px;">Breakfast</h6>
                </a>
            </div>
            <div class="sub_card_4" id="sub_card" style="position: relative;bottom: 260px; left: 40px;">
                <a href="#">
                    <div class="reciper_pic"><img src="assets/img/desserts.jpg" alt="desserts" height="100px" width="150px"></div>
                    <h6 style="position: relative; left: 33px; top:15px">Desserts</h6>
                </a>
            </div>
            <div class="sub_card_5" id="sub_card" style="position: relative; bottom: 400px; left:190px">
                <a href="#">
                    <div class="reciper_pic"><img src="assets/img/snacks.jpg" alt="snacks" height="100px" width="150px"></div>
                    <h6 style="position: relative; left: 35px; top: 15px;">Snacks</h6>
                </a>
            </div>
            <div class="sub_card_6" id="sub_card" style="position: relative; bottom: 540px; left:340px ;">
                <a href="#">
                    <div class="reciper_pic"><img src="assets/img/fav.jpg" alt="fav" height="100px" width="150px"></div>
                    <h6 style="position: relative; left: 30px; top: 15px;">Favourite</h6>
                </a>
            </div>

        </div>

        <div class="water_consumption" id="card">
            <div class="cups">
                <img src="assets/img/glass-of-water.png" alt="water cup">
                <span class="current-cups">0/10</span>
            </div>

            <div class="litres">
                <img src="assets/img/drop.png" alt="water drop">
                <span class="current-litres">0l/2.5l</span>
            </div>
            <div>
                <div class="percentage-container">
                    <span class="current-percentage">0%</span>
                    <div class="progress"></div>
                </div>
            </div>


            <div class="buttons">
                <button class="remove" disabled>-</button>
                <button class="add">+</button>
            </div>






        </div>

        <div class="cal_count" id="card">
            <div class="cal_progress">
                <div class="progress"></div>
            </div>
            <div class="percentage-cal">0%</div>
            <div class="gain_cal">0Kcal</div>


        </div>


        <div class="insert_nut" id="card">
            <h2>Calorie Intake</h2>
            <h4>Today's Calorie Total</h4>
            <p>"Please make sure to aim for the targeted amount of calories you need.
                This will help you achieve your desired results and ensure that you are meeting
                your nutritional needs. Be mindful of your daily intake and stay on track with
                your goals."</p>

            <div class="kcal_form" id="kcal_form">
                <form action="#">
                    <input type="text" id="kcal" name="kcal">
                    <label for="kcal">Kcal</label>
                    <input type="button" id="Kcal_add_button" value="Add">
                </form>
            </div>

            <!-- this is replced instead of a drag and drop -->
            <form action="upload.php" class="secondform" method="post" enctype="multipart/form-data">
                <input type="file" name="image" id="image">
                <input type="submit" name="submit" value="Upload Image">
            </form>
        </div>

        <a href="#" id="stretching">
            <div class="stretching_card" id="card">
                <h1>Stretching</h1>
                <h3>10 min</h3>
            </div>
        </a>

        <a href="#" id="cardio">
            <div class="cardio_card" id="card">
                <h1>Cardio</h1>
                <h3>15 min</h3>
            </div>
        </a>




    </div>










    <!-- side nav -->
    <div id="sidenav">
        <nav class="sidenav">
            <ul>
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









    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script>
        feather.replace()
    </script>

    <script>
        // kcal_progress();


        const droparea = document.querySelector(".droparea");

        droparea.addEventListener("dragover", (e) => {
            e.preventDefault();
            droparea.classList.add("hover");
        })

        droparea.addEventListener("dragleave", () => {
            droparea.classList.remove("hover");
        })

        droparea.addEventListener("drop", (e) => {
            e.preventDefault();

            const image = e.dataTransfer.files[0];
            const type = image.type;
            console.log(type);

            if (type == "image/jpg" || type == "image/png" || type == "image/jpeg") {
                droparea.setAttribute("class", "droparea valid");
                droparea.innerText = "Added " + image.name;

            } else {
                droparea.setAttribute("class", "droparea invalid");
                droparea.innerText = "Invalid File Format";
                return false;
            }
        })


        //button selctor
        const add_Button = document.querySelector(".add"),
            removeButton = document.querySelector(".remove");

        const currentCupsEl = document.querySelector(".current-cups"),
            currentlitresEl = document.querySelector(".current-litres"),
            currentprogressEl = document.querySelector(".current-percentage"),
            progressArea = document.querySelector(".progress");



        const MAX_CUPS = 10,
            MIN_CUPS = 0;

        let cups = 0,
            litres = 0,
            percentage = 0;

        add_Button.addEventListener("click", addcup);
        removeButton.addEventListener("click", removeCup);


        function addcup() {
            cups++;
            litres += 250;
            percentage = (cups / MAX_CUPS) * 100;

            console.log(cups, litres, percentage);


            //updating
            updatedLayout();

            if (cups === MAX_CUPS) {
                add_Button.disabled = true;
            } else {
                removeButton.disabled = false;
            }
        };

        function removeCup() {
            cups--;
            litres -= 250;
            percentage = (cups / MAX_CUPS) * 100;

            console.log(cups, litres, percentage);
            //updating
            updatedLayout();


            if (cups === MIN_CUPS) {
                removeButton.disabled = true;
            } else {
                add_Button.disabled = false;
            }
        };

        function updatedLayout() {
            currentCupsEl.textContent = `${cups}/10`;
            currentlitresEl.textContent = `${litres/1000}l/2.5l`;
            currentprogressEl.textContent = `${percentage}%`;
            progressArea.style.height = `${percentage}%`;
        }

        function kcal_progress() {

            let cal_count;
            let cal_aim;
            let cal_percentage;

            cal_count = 789;
            cal_aim = 2500;
            cal_percentage = Math.round((cal_count / cal_aim) * 100);

            const progress2 = document.querySelector('.progress'),
                percentagecal2 = document.querySelector('.percentage-cal'),
                gain_cal2 = document.querySelector('.gain-cal');

            progress2.style.height = `${cal_percentage}%`;
            percentagecal2.textContent = `${cal_percentage}%`;
            gain_cal2.textContent = `${cal_count}Kcal`;


        }
    </script>
</body>

</html>