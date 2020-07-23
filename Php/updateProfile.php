<?php
    $Username=$_POST['User'];
    $email=$_POST['email-id'];
    $wallet=$_POST['wallet-name'];
    $Password=$_POST['Pass'];
    session_start();
    $user=$_SESSION['username'];
    $conn=mysqli_connect('localhost','root','');
    mysqli_select_db($conn,'expense_clients') or die("Could connect to the database"); 
    if(isset($_POST['update']))
    {
        $query=mysqli_query($conn,"UPDATE `all_users` SET `Username` = '$Username', `Password` = '$Password', `Email` = '$email', `Wallet Name` = '$wallet' WHERE `all_users`.`Username` = '$user'");
    }
?>