<nav class="header sticky-top px-4">
    <div class="row py-3">
        <div class="col-6 d-flex justify-content-start align-items-center">
            <img src="assets/img/logo-min.png" height="60" alt="logo">
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <!-- <button class="btn theme-btn mx-2">Login</button> -->
            <?php 
            if(islogged(isset($_SESSION['username']),$_SESSION["userVerified"])){
                echo '<a class="col-2 mx-2" href="logout.php"><button class="btn theme-btn" style="background-color: #ffc107; color: black; font-weight: 400; border-radius: 20px; border-style: none; font-family: outfit, sans-serif;">Logout</button></a>';
            }else{
                echo '<a class="col-2 mx-2" href="login.php"><button class="btn theme-btn" style="background-color: #ffc107; color: black; font-weight: 400; border-radius: 20px; border-style: none; font-family: outfit, sans-serif;">Login</button></a>';
            }
            ?>
            <a class="col-2 mx-2" href="dashboard.php"><button class="btn theme-btn" style="background-color: #ffc107; color: black; font-weight: 400; border-radius: 20px; border-style: none; font-family: outfit, sans-serif;">Dashboard</button></a>

        </div>
    </div>
</nav>