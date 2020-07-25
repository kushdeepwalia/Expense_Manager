<?php
    $Username=$_POST['User'];
    $email=$_POST['email-id'];
    $wallet=$_POST['wallet-name'];
    $Password=$_POST['Pass'];
    session_start();
    $user=$_SESSION['username'];
    $oldWallet=$_SESSION['wallet'];
    $conn=mysqli_connect('localhost','root','');
    mysqli_select_db($conn,'expense_clients') or die("Could connect to the database"); 
    if(isset($_POST['update']))
    {
        $query1=mysqli_query($conn,"UPDATE `all_users` SET `Username` = '$Username', `Password` = '$Password', `Email` = '$email', `Wallet Name` = '$wallet' WHERE `all_users`.`Username` = '$user'");
        $query2=mysqli_query($conn,"CREATE DATABASE `$Username`");
        $query3=mysqli_query($conn,"USE `$Username`");
        $query4=mysqli_query($conn,"CREATE TABLE `$wallet` LIKE `$user`.`$oldWallet`");
        $query5=mysqli_query($conn,"INSERT INTO `$wallet` SELECT * FROM `$user`.`$oldWallet`");
        $query6=mysqli_query($conn,"DROP DATABASE `$user`");
        if($query1>0)
        {
            echo"Done 1<br>";
        }
        else
        {
            echo"Not Done 1<br>";
        }
        if($query6>0)
        {
            echo"Done 6<br>";
        }
        else
        {
            echo"Not Done 6<br>";
        }
        if($query2>0)
        {
            echo"Done 2<br>";
        }
        else
        {
            echo"Not Done 2<br>";
        }
        if($query3>0)
        {
            echo"Done 3<br>";
        }
        else
        {
            echo"Not Done 3<br>";
        }
        if($query4>0)
        {
            echo"Done 4<br>";
        }
        else
        {
            echo"Not Done 4<br>";
        }
        if($query5>0)
        {
            echo"Done 5<br>";
        }
        else
        {
            echo"Not Done 5<br>";
        }
        $_SESSION['username']=$Username;
        echo$_SESSION['username'];
        header("location:../account.php");
    }
?>