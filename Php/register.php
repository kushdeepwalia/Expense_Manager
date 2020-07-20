<?php
    $con=mysqli_connect('localhost:3306','id14247551_kush','9354752373_Kush');
    mysqli_select_db($con,'expense_clients') or die("Could connect to the database");
    $username=$_POST['Username'];
    $email=$_POST['email'];
    $wallet=$_POST['wallet'];
    $password=$_POST['Password'];
    $conpassword=$_POST['ConPassword'];
    if(strcmp($password,$conpassword)==0)
    {
        $query="SELECT `Username` FROM `all_users` where Username='$username'";
        $ret=mysqli_query($con,$query);
        session_start();
        if(ret > 0)
        {
            header("location:../index.php?message=yes");
        }
        else
        {
            $query1="INSERT INTO `all_users` (`Username`, `Password`, `Email`) VALUES ('$username', '$password', '$email')";
            $query2="CREATE DATABASE `$username`";
            $query3="CREATE TABLE `$username`.`$wallet` ( `S. No.` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `Category` VARCHAR(10) NOT NULL , `Amount` INT NOT NULL, `Sub Category` VARCHAR(20) NOT NULL, `Date` DATE NOT NULL, `Description` VARCHAR(70) NOT NULL, `Mode` VARCHAR(10) NOT NULL )";
            $ins=mysqli_query($con,$query1);
            $credat=mysqli_query($con,$query2);
            $crewal=mysqli_query($con,$query3);
            $_SESSION['username']=$username;
            header("location:../account.php");
        }
    }
    else
    {
        header("location:../index.php?msg=no");
    }

?>