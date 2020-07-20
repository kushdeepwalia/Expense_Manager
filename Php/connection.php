<?php
    session_start();
    $username=$_SESSION['username'];
    $con=mysqli_connect('localhost','root','');
    mysqli_select_db($con,`$username`) or die("Could connect to the database");
?>