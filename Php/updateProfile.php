<?php
    $Username=$_POST['User'];
    $email=$_POST['email-id'];
    $wallet=$_POST['wallet-name'];
    $Password=$_POST['Pass'];
    $new_wallet_name = $Username."-".$wallet;
    session_start();
    $wallet_name=$_SESSION['wallet_name'];
    $var = explode("-",$wallet_name);
    $user = $var[0];
    $walletName = $var[1];
    $conn=mysqli_connect('localhost','root','');
    mysqli_select_db($conn,'expense_clients') or die("Could connect to the database"); 
    if(isset($_POST['update']))
    {
        $query1=mysqli_query($conn,"UPDATE `all_users` SET `Username` = '$Username', `Password` = '$Password', `Email` = '$email', `Wallet Name` = '$wallet' WHERE `all_users`.`Username` = '$user'");
        $query4=mysqli_query($conn,"CREATE TABLE `wallets`.`$new_wallet_name` LIKE `wallets`.`$wallet_name`");
        $query5=mysqli_query($conn,"INSERT INTO `wallets`.`$new_wallet_name` SELECT * FROM `wallets`.`$wallet_name`");
        $query6=mysqli_query($conn,"DROP TABLE `wallets`.`$wallet_name`");
        $_SESSION['wallet_name']=$new_wallet_name;
        header("location:../account.php");
    }
?>