<?php
    session_start();
    $username=$_SESSION['username'];
    $wallet=$_SESSION['wallet'];
    $con=mysqli_connect('localhost','root','');
    mysqli_select_db($con,$username) or die("Could connect to the database");
    if(isset($_POST['submit-income']))
    {
        $income_amount=$_POST['income-amount'];
        $income_sub_category=$_POST['income-sub-category'];
        $income_date=$_POST['income-date'];
        $income_desc=$_POST['income-desc'];
        $income_mode=$_POST['income-mode'];
        $query=mysqli_query($con,"INSERT INTO `$wallet` (`S. No.`, `Category`, `Amount`, `Sub Category`, `Date`, `Description`, `Mode`) VALUES (NULL, 'Income', '$income_amount', '$income_sub_category', '$income_date', '$income_desc', '$income_mode');");
        header("location:../account.php");
    }
    if(isset($_POST['submit-expense']))
    {
        $expense_amount=$_POST['expense-amount'];
        $expense_sub_category=$_POST['expense-sub-category'];
        $expense_date=$_POST['expense-date'];
        $expense_desc=$_POST['expense-desc'];
        $expense_mode=$_POST['expense-mode'];
        $query=mysqli_query($con,"INSERT INTO `$wallet` (`S. No.`, `Category`, `Amount`, `Sub Category`, `Date`, `Description`, `Mode`) VALUES (NULL, 'Expense', '$expense_amount', '$expense_sub_category', '$expense_date', '$expense_desc', '$expense_mode');");
        header("location:../account.php");
    }

?>