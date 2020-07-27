<?php
    session_start();
    $username=$_SESSION['username'];
    if(!($username))
        header("location:index.php");
    $conn=mysqli_connect('localhost','root','');
    mysqli_select_db($conn,'expense_clients') or die("Could connect to the database"); 
    $profile_query=mysqli_query($conn,"SELECT * FROM `all_users` WHERE `Username`='$username'");
    $profile_result=mysqli_fetch_array($profile_query);
    $email=$profile_result[3];
    $_SESSION['email']=$email;
    mysqli_close($conn);

    $con=mysqli_connect('localhost','root','');
    mysqli_select_db($con,$username) or die("Could connect to the database"); 
    $result = mysqli_query($con,"show tables");
    $table = mysqli_fetch_array($result);
    $wallet=$table[0];

    $total_expense = Array();
    $total_save = Array();
    $total_percent_save = Array();
    $total_percent_expense = Array();
    $total_income = Array();
    $num_row=0;
    $zero=[0,0,0,0];
    
    $_SESSION['wallet']=$wallet;
    $query=mysqli_query($con,"SELECT * FROM `$wallet`");
    if(mysqli_num_rows($query)!=0)
    {
        $queryIncome="SELECT * FROM `$wallet` Where `Category`='Income'";
        $query_income=mysqli_query($con,$queryIncome);
        $queryExpense="SELECT * FROM `$wallet` Where `Category`='Expense'";
        $query_expense=mysqli_query($con,$queryExpense);
        for($i=0;$i<mysqli_num_rows($query_income);$i++)
        {
            $income=mysqli_query($con,"SELECT SUM(Amount) FROM `$wallet` Where `Category`='Income'");
            $total_income[$i]=mysqli_fetch_array($income);
        }
        for($i=0;$i<mysqli_num_rows($query_expense);$i++)
        {
            $expense=mysqli_query($con,"SELECT SUM(Amount) FROM `$wallet` Where `Category`='Expense'");
            $total_expense[$i]=mysqli_fetch_array($expense);
        }
        $num_row=mysqli_num_rows($query_income);
        if(mysqli_num_rows($query_income)>0 && mysqli_num_rows($query_expense)>0)
        {
            $total_percent_expense[0][0]=( $total_expense[0][0] / $total_income[0][0]) *100;
            $total_percent_expense[0][0]=round($total_percent_expense[0][0],1);
            if($total_percent_expense[0][0]== 0) 
                $zero[0]=0;
            else
            {
                $zero[0]=$total_percent_expense[0][0];
                $zero[2]=$total_expense[0][0];
            }
            $total_save[0][0] = $total_income[0][0]-$total_expense[0][0];
            $total_percent_save[0][0]=( $total_save[0][0] / $total_income[0][0]) *100;
            $total_percent_save[0][0]=round($total_percent_save[0][0],1);
            if($total_percent_save[0][0]== 0) 
                $zero[1]=0;
            else 
            {
                $zero[1]=$total_percent_save[0][0];
                $zero[3]=$total_save[0][0];
            }
        }
        if(mysqli_num_rows($query_income)>0 && mysqli_num_rows($query_expense)<=0)
        {
            $total_save[0][0] = $total_income[0][0];
            $total_percent_save[0][0]=( $total_save[0][0] / $total_income[0][0]) *100;
            $total_percent_save[0][0]=round($total_percent_save[0][0],1);
            if($total_percent_save[0][0]== 0) 
                $zero[1]=0;
            else 
            {
                $zero[1]=$total_percent_save[0][0];
                $zero[3]=$total_save[0][0];
            }
        }
    }
    else
    {
        $zero=[0,0,0,0];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            .card:nth-child(1) svg circle:nth-child(2) {
                stroke-dashoffset: calc(440 - (440 * <?php echo$zero[0]; ?>) /100);
                stroke: rgb(245,41,61);
            }
            .card:nth-child(2) svg circle:nth-child(2) {
                <?php 
                    if($zero[0]==0)
                    { 
                        $zeroStroke=0;
                    }  
                    else
                    {
                        $zeroStroke=$zero[0];
                    } 
                ?>
                stroke-dashoffset: calc(-1 * (440 * <?php echo$zeroStroke; ?>) /100);
                stroke: black;
            }
        </style>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hey <?php echo$username; ?></title>
        <link rel="stylesheet" href="CSS/pop-up.css">
        <link rel="stylesheet" href="CSS/loading.css">
        <link rel="stylesheet" href="CSS/account.css">
        <link rel="stylesheet" href="CSS/custom_scroll.css">
        <link rel="stylesheet" href="CSS/progresscircle.css">
        <link rel="shortcut icon" href="Images/main-logo.png" type="image/x-icon">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>

    <body>
        <div class="loader">
            <div class="loading">
                <span>Loading...</span>
            </div>
        </div>
        <div class="content-box">
            <header class="header">
                <div class="logo_head">
                    <span id="web-image">
                        <img src="Images/main-logo.png" alt="Wallet" id="web-logo">
                    </span>
                    <span id="web-name">
                        Expense Manager
                    </span>
                </div>
                <div class="wallet-name">
                    <span id="wallet-name">wallet name: </span>
                    <span><?php echo$wallet;?></span>
                </div>
                <div class="logout">
                    <a href="Php/logout.php"><button id="logout">Logout</button></a>
                </div>
            </header>
            <div class="content">
                <div class="containerbody">
                    <div class="container">
                        <div class="card">
                            <div class="box">
                                <div class="percent">
                                    <svg>
                                        <circle cx="70" cy="70" r="70"></circle>
                                        <circle cx="70" cy="70" r="70"></circle>
                                    </svg>
                                    <div class="number">
                                        <h2><?php echo$zero[0]; ?><span>%</span></h2>
                                    </div>
                                </div>
                                <div class="text">Expense <br><span>&#8377; <?php echo$zero[2]; ?></span> </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="box">
                                <div class="percent">
                                    <svg>
                                        <circle cx="70" cy="70" r="70"></circle>
                                        <circle cx="70" cy="70" r="70"></circle>
                                    </svg>
                                    <div class="number">
                                        <h2><?php echo $zero[1]; ?><span>%</span></h2>
                                    </div>
                                </div>
                                <div class="text">Balance <br> <span>&#8377; <?php echo$zero[3]; ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content">
                    <nav class="nav">
                        <ul>
                            <a data-tab-target="#add-income">
                                <li>Add Income</li>
                            </a>
                            <a data-tab-target="#add-expense">
                                <li>Add Expense</li>
                            </a>
                            <a data-tab-target="#all-transac">
                                <li>All Transcations</li>
                            </a>
                            <a data-tab-target="#reports">
                                <li>Reports</li>
                            </a>
                            <a data-tab-target="#pro">
                                <li class="br-1">Profile Settings</li>
                            </a>
                        </ul>
                    </nav>
                    <section id="add-income" class="add-income inactive">
                        <div class="income-left">
                            <img src="Images/income-symbol.png" alt="income-symbol-image" id="income-symbol">
                            <br>
                            <span>Add Income</span>
                        </div>
                        <div class="income-right">
                            <div class="form">
                                <div id="errorAddingIncome"></div>
                                <form action="Php/inserttowallet.php" method="post" id="incomeForm" autocomplete="off">
                                    <table align="center">
                                        <tr>
                                            <td>
                                                <span class="field">Amount: </span><input type="number" name="income-amount" min="1" id="income-amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Source: </span>
                                                <select name="income-sub-category" id="income-sub-category">
                                                    <option value="none">--select--</option>
                                                    <option value="Award">Award</option>
                                                    <option value="Gifts">Gifts</option>
                                                    <option value="Interest Money">Interest Money</option>
                                                    <option value="Others">Others</option>
                                                    <option value="Salary">Salary</option>
                                                    <option value="Selling">Selling</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Date: </span>
                                                <input type="date" name="income-date" id="income-date">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Description: </span><input type="text"
                                                    name="income-desc" id="income-desc">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Mode: </span>
                                                <select name="income-mode" id="income-mode">
                                                    <option value="none">--select--</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Debit Card">Debit Card</option>
                                                    <option value="Net Banking">Net Banking</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <input type="submit" value="Submit" name="submit-income" id="submit-income">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </section>
                    <section id="add-expense" class="add-expense inactive">
                        <div class="expense-left">
                            <img src="Images/expense-symbol.png" alt="expense-symbol-image" id="expense-symbol">
                            <br>
                            <span>Add expense</span>
                        </div>
                        <div class="expense-right">
                            <div class="form">
                                <?php
                                    if($num_row<=0)
                                    {
                                        echo"<div class='error'>Please Add Income First</div>";
                                    }
                                ?>
                                <div id="errorAddingExpense"></div>
                                <form action="Php/inserttowallet.php" method="post" id="expenseForm" autocomplete="off">
                                    <table align="center">
                                        <tr>
                                            <td>
                                                <span class="field">Amount: </span><input type="text" name="expense-amount"  min="1" id="expense-amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Source: </span>
                                                <select name="expense-sub-category" id="expense-sub-category">
                                                    <option value="none">--select--</option>
                                                    <option value="Bills">Bills</option>
                                                    <option value="Business">Business</option>
                                                    <option value="Education">Education</option>
                                                    <option value="Entertainment">Entertainment</option>
                                                    <option value="Family">Family</option>
                                                    <option value="Fees">Fees</option>
                                                    <option value="Food & Drinks">Food & Drinks</option>
                                                    <option value="Friends & Lover">Friends & Lover</option>
                                                    <option value="Gifts">Gifts</option>
                                                    <option value="Health">Health</option>
                                                    <option value="Insurance">Insurance</option>
                                                    <option value="Investment">Investment</option>
                                                    <option value="Others">Others</option>
                                                    <option value="Shopping">Shopping</option>
                                                    <option value="Transportation">Transportation</option>
                                                    <option value="Travel">Travel</option>
                                                    <option value="Withdrawal">Withdrawal</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Date: </span>
                                                <input type="date" name="expense-date" id="expense-date" max=>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Description: </span><input type="text"
                                                    name="expense-desc" id="expense-desc">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="field">Mode: </span>
                                                <select name="expense-mode" id="expense-mode">
                                                    <option value="none">--select--</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Debit Card">Debit Card</option>
                                                    <option value="Net Banking">Net Banking</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <input type="submit" value="Submit" name="submit-expense"
                                                    id="submit-expense">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </section>
                    <section id="all-transac" class="all-transac active">
                        <div class="categoryselect">
                            <form method="post">
                                <span>Category: </span>
                                <select name="transac-category" id="transac-category">
                                    <option value="All">ALL</option>
                                    <option value="Income">Income</option>
                                    <option value="Expense">Expense</option>
                                </select>
                                <input type="submit" value="Submit" name="cat-submit" id="cat-submit">
                            </form>
                        </div>
                        <div class="transac-table">
                            <table class="table">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Sub-category</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Mode</th>
                                </tr>                                                  
                                <?php
                                    if(isset($_POST['cat-submit']))
                                    {
                                        $transac_cat=$_POST['transac-category'];
                                        switch($transac_cat)
                                        {
                                            case "All": $query=mysqli_query($con,"SELECT * FROM `$wallet`");
                                                        break;
                                            case "Income": $query=mysqli_query($con,"SELECT * FROM `$wallet` Where `Category`='Income'");
                                                        break;
                                            case "Expense": $query=mysqli_query($con,"SELECT * FROM `$wallet` Where `Category`='Expense'");
                                                        break;
                                        }
                                        if(mysqli_num_rows($query) == 0)
                                        {
                                           echo"<div class='TransactionError'><script>swal({title:'No Transaction',text:'Please add one in income or expense tab',icon:'warning'});</script></div>";
                                        }
                                        if(mysqli_num_rows($query) > 0)
                                        {
                                            $i=1;
                                            while($result=mysqli_fetch_array($query))
                                            {

                                        ?>
                                                <tr>
                                                    <td><?php echo$i++;?></td>
                                                    <td><?php echo$result[1];?></td>
                                                    <td><?php echo$result[2];?></td>
                                                    <td><?php echo$result[3];?></td>
                                                    <td><?php echo$result[4];?></td>
                                                    <td><?php echo$result[5];?></td>
                                                    <td><?php echo$result[6];?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                    </section>
                    <section id="reports" class="reports inactive">
                        <div class="report-left">
                            <img src="Images/report-symbol.png" alt="reports-image" id="report-symbol">
                            <br>
                            <span>Reports</span>
                        </div>
                        <div class="report-right">
                            <?php 
                                if(isset($_SESSION['all-total-error'])) 
                                {
                                    echo"<div class='loginFormError'><script>swal({title:'Cant Generate Report',text:'No Transaction Record in your Wallet',icon:'warning'});</script></div>";
                                    unset($_SESSION['all-total-error']);
                                }
                                if(isset($_SESSION['range-total-error'])) 
                                {
                                    echo"<div class='loginFormError'><script>swal({title:'Cant Generate Report',text:'No Transaction Record under the range entered in your Wallet',icon:'warning'});</script></div>";
                                    unset($_SESSION['range-total-error']);
                                }
                                if(isset($_SESSION['date-total-error'])) 
                                {
                                    echo"<div class='loginFormError'><script>swal({title:'Cant Generate Report',text:'No Transaction Record of entered Date in your Wallet',icon:'warning'});</script></div>";
                                    unset($_SESSION['date-total-error']);
                                }
                            ?>
                            <form action="Php/dateCreatePDF.php" method="post">
                                <div class="dates">
                                    <span class="date">Date Wise</span>
                                    <input type="date" name="date" id="dates">
                                </div>
                                <input type="submit" value="View Online" id="date-view-online" name="date-view-online">
                                <input type="submit" value="Download"  id="date-download" name="date-download" formtarget="_blank">
                            </form>
                            <br>
                            <form action="Php/rangeCreatePDF.php" method="post">
                                <div class="dates">
                                    <span class="date">Specific Range</span><br>
                                </div>
                                <span class="date">Start Date</span>
                                <input type="date" name="startDate" id="dates"><br>
                                <span class="date">End Date</span>
                                <input type="date" name="endDate" id="dates"><br>
                                <input type="submit" value="View Online" id="date-view-online" name="range-view-online">
                                <input type="submit" value="Download"  id="date-download" name="range-download" formtarget="_blank">
                            </form>
                            <form action="Php/allCreatePDF.php" method="post">
                                <div class="months">
                                    <span class="month">All Transaction</span>
                                </div>
                                <input type="submit" value="View Online" name="all-view-online" id="month-view-online">
                                <input type="submit" value="Download" name="all-download" id="month-download" formtarget="_blank">
                            </form>
                        </div>
                        
                    </section>
                    <section id="pro" class="pro inactive">
                        <div class="pro-left">
                            <img src="Images/profile-symbol.png" alt="profile-symbol-image" id="profile-symbol">
                            <br>
                            <span>Profile Settings</span>
                        </div>
                        <div class="pro-right">
                            <div class="form">
                                <table align="center">
                                    <tr>
                                        <td>
                                            <span class="field">Username: </span>
                                            <input type="text" value="<?php echo$profile_result[1] ?>" id="User" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="field">Password: </span>
                                            <input type="text" id="Pass" value="<?php echo$profile_result[2] ?>" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="field">Email: </span>
                                            <input type="email" value="<?php echo$profile_result[3] ?>" id="mail" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="field">Wallet Name: </span><input type="text" value="<?php echo$profile_result[4] ?>" id="Wallet_name" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <button id="Btn" data-modal-target="#Update">Update</button>
                                            <div class="modal" id="Update">
                                                <div class="modal-body">
                                                    <div class="modal-heading">
                                                        <div class="title">Update</div>
                                                        <button data-close-button class="close-button">&times;</button>
                                                    </div>
                                                    <div id="profileUpdateError"></div>
                                                    <form id="profileForm" action="Php/updateProfile.php" method="POST" autocomplete="off" >
                                                        <table class="loginTable">
                                                            <tr>
                                                                <td class="box"><input type="text" name="User" id="updateUser" placeholder="<?php echo$profile_result[1] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="box"><input type="email" name="email-id" id="updateEmail" placeholder="<?php echo$profile_result[3] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="box"><input type="text" name="wallet-name" id="updateWallet" placeholder="<?php echo$profile_result[4] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="box"><input type="password" name="Pass" id="updatePassword" placeholder="<?php echo$profile_result[2] ?>"></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td colspan="2" align="center"><input type="submit" value="Update" name="update" id="btn"></td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="overlay"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <script src="Js/pop-up.js"></script>
        <script src="Js/account-nav.js"></script>
        <script src="Js/loader.js"></script>
        <script src="Js/account-income-validation.js"></script>
        <script src="Js/account-expense-validation.js"></script>
        <script src="Js/account-profile-validation.js"></script>
    </body>
</html>