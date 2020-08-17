<?php
    $con=mysqli_connect('localhost','root','');
    mysqli_select_db($con,'expense_clients') or die("Could connect to the database");
    $username=$_POST['Username'];
    $password=$_POST['Password'];
    $query=mysqli_query($con,"SELECT * FROM `All_Users` where `Username`='$username'");
    $row=mysqli_fetch_array($query);
    session_start();
    if($row>0 && strcmp($row['Password'],$password)!=0)
    {
        $_SESSION['errorPassword']="Password Not Matched with this Username";
        header("location:../index.php");
    }
    else if($row > 0)
    {
        $_SESSION['username']=$username;
        header("location:../account.php");
    }
    else
    {   
        $_SESSION['errorUsername']="Username doesn't exist";
        header("location:../index.php");
    }
?>
