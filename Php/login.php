<?php
    $con=mysqli_connect('localhost','root','');
    mysqli_select_db($con,'expense_clients') or die("Could connect to the database");
    $username=$_POST['Username'];
    $password=$_POST['Password'];
    $query=mysqli_query($con,"SELECT * FROM `All_Users` where `Username`='$username' and `Password`='$password'");
    $row=mysqli_fetch_array($query);
    if($row > 0)
    {
        session_start();
        $_SESSION['username']=$username;
        header("location:../account.php");
    }
    else
    {
        //if login details not present in the database then show message
    }
?>