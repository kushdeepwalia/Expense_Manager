<?php
    session_start();
    $username=$_SESSION['username'];
    $con=mysqli_connect('localhost:3306','id14247551_kush','9354752373_Kush');
    mysqli_select_db($con,$username) or die("Could connect to the database");   
    $result = mysqli_query($con,"show tables");
    $table = mysqli_fetch_array($result);
    $wallet=$table[0];
    $_SESSION['wallet']=$wallet;
    $query=mysqli_query($con,"SELECT * FROM `$wallet`");
    if(mysqli_num_rows($query)!=0)
    {
        $total_income = Array();
        $query_income=mysqli_query($con,"SELECT * FROM `$wallet` Where `Category`='Income'");
        $query_expense=mysqli_query($con,"SELECT * FROM `$wallet` Where `Category`='Expense'");
        for($i=0;$i<mysqli_num_rows($query_income);$i++)
        {
            $income=mysqli_query($con,"SELECT SUM(Amount) FROM `$wallet` Where `Category`='Income'");
            $total_income[$i]=mysqli_fetch_array($income);
        }
        $total_expense = Array();
        for($i=0;$i<mysqli_num_rows($query_expense);$i++)
        {
            $expense=mysqli_query($con,"SELECT SUM(Amount) FROM `$wallet` Where `Category`='Expense'");
            $total_expense[$i]=mysqli_fetch_array($expense);
        }
        $total_save = Array();
        $total_save[0][0] = $total_income[0][0] - $total_expense[0][0];
        $total_percent_expense = Array();
        $total_percent_expense[0][0]=( $total_expense[0][0] / $total_income[0][0]) *100;
        $total_percent_expense[0][0]=round($total_percent_expense[0][0],1);
        $total_percent_save = Array();
        $total_percent_save[0][0]=( $total_save[0][0] / $total_income[0][0]) *100;
        $total_percent_save[0][0]=round($total_percent_save[0][0],1);
        $zero[0]=0;
        $zero[1]=0;
        if($total_percent_expense[0][0]== 0) 
            $zero[0]=0;
        else
        {
            $zero[0]=$total_percent_expense[0][0];
            $zero[2]=$total_expense[0][0];
        }
        if($total_percent_save[0][0]== 0) 
            $zero[1]=0;
        else 
        {
            $zero[1]=$total_percent_save[0][0];
            $zero[3]=$total_save[0][0];
        }
    }
    else
    {
        $zero[0]=0;
        $zero[1]=0;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .card:nth-child(1) svg circle:nth-child(2) {
            stroke-dashoffset: calc(440 - (440 * <?php echo$zero[0]; ?>) /100);
            stroke: red;
        }

        .card:nth-child(2) svg circle:nth-child(2) {
            stroke-dashoffset: calc(-1 * (440 * <?php echo$zero[0]; ?>) /100);
                stroke: blue;
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
</head>

<body>
    <!-- <div class="loader">
        <div class="loading">
            <span>Loading...</span>
        </div>
    </div> -->
    <div class="content-box">
        <header class="header">
            <div class="logo_head">
                <span id="web-image">
                    <img src="Images/main logo.png" alt="Wallet" id="web-logo">
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
                <a href="index.php"><button id="logout">Logout</button></a>
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
                            <div class="text">Expenses <br><?php echo$zero[2]; ?> </div>
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
                            <div class="text">Savings <br> <?php echo$zero[3]; ?></div>
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
                            <form action="Php/inserttowallet.php" method="post">
                                <table align="center">
                                    <tr>
                                        <td>
                                            <span class="field">Amount: </span><input type="number" name="income-amount"
                                                id="income-amount">
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
                        <span>Add Income</span>
                    </div>
                    <div class="expense-right">
                        <div class="form">
                            <form action="Php/inserttowallet.php" method="post">
                                <table align="center">
                                    <tr>
                                        <td>
                                            <span class="field">Amount: </span><input type="text" name="expense-amount"
                                                id="expense-amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="field">Source: </span>
                                            <select name="expense-sub-category" id="expense-sub-category">
                                                <option value="none">--select--</option>
                                                <option value="Bills & Utilities">Bills & Utilities</option>
                                                <option value="Business">Business</option>
                                                <option value="Education">Education</option>
                                                <option value="Entertainment">Entertainment</option>
                                                <option value="Family">Family</option>
                                                <option value="Fees & Charges">Fees & Charges</option>
                                                <option value="Food & Beverages">Food & Beverages</option>
                                                <option value="Friends & Lover">Friends & Lover</option>
                                                <option value="Gifts & Donations">Gifts & Donations</option>
                                                <option value="Health & Fitness">Health & Fitness</option>
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
                                            <input type="date" name="expense-date" id="expense-date">
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
                <section id="all-transac" class="all-transac inactive">
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
                <section id="reports" class="reports active" style="margin-top:20px;margin-left:20px;font-size:100px;">
                    <form action="Php/createpdf.php" method="post">
                        <input type="submit" value="View Online" name="view-online">
                        <input type="submit" value="Download" name="download">
                    </form>
                    
                </section>
                <section id="pro" class="pro inactive">
                    e
                </section>
            </div>
        </div>
    </div>
    <script src="Js/pop-up.js"></script>
    <script src="Js/account-nav.js"></script>
    <script src="Js/loader.js"></script>
</body>

</html>
<?php
    if(isset($_GET['income-added']))
    {
        $income_added=$_GET['income-added'];
        if(strcmp("Yes",$income_added))
        {
            echo"<script>alert('Income Report Added to Your Wallet');</script>";
        }
        else if(strcmp("No",$income_added))
        {
            echo"<script>alert('Income Report <strong>NOT</strong> Added to Your Wallet');</script>";
        }
    }
    if(isset($_GET['expense-added']))
    {
        $expense_added=$_GET['expense-added'];
        if(strcmp("Yes",$expense_added))
        {
            echo"<script>alert('Expense Report Added to Your Wallet');</script>";
        }
        else if(strcmp("No",$expense_added))
        {
            echo"<script>alert('Expense Report <strong>NOT</strong> Added to Your Wallet');</script>";
        }
    }
?>