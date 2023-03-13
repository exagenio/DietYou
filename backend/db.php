<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connection = mysqli_connect("localhost","root", "root","dietYou");
if (!$connection){
    die("Connection failed: " . mysqli_connect_error());
}
?>