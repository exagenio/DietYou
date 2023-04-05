<nav class="header sticky-top px-4">
    <div class="row py-3">
        <div class="col-6 d-flex justify-content-start align-items-center">
            <img src="assets/img/logo-min.png" height="60" alt="logo">
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <!-- <button class="btn theme-btn mx-2">Login</button> -->
            <?php 
            if(islogged(isset($_SESSION['username']),$_SESSION["userVerified"])){
                echo '<a href="logout.php"><button class="btn theme-btn mx-2">Logout</button></a>';
            }else{
                echo '<a href="login.php">button class="btn theme-btn mx-2">Login</button></a>';
            }
            ?>
            <button href="dashboard.php" class="btn theme-btn mx-2">Dashboard</button>

        </div>
    </div>
</nav>