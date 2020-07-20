<?php
    session_start();
    $username=$_SESSION['username'];
    $con=mysqli_connect('localhost:3306','id14247551_kush','9354752373_Kush');
    mysqli_select_db($con,`$username`) or die("Could connect to the database");
?>