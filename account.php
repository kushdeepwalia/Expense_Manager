<?php
    session_start();
    $username=$_SESSION['username'];
    $con=mysqli_connect('localhost','root','');
    mysqli_select_db($con,$username) or die("Could connect to the database");
    if(isset($_POST['submit-wallet']))
    {    
        $wallet=$_POST['wallet'];
        $total_income = Array();
        $query_income=mysqli_query($con,"SELECT * FROM `$wallet` Where `Category`='Income'");
        $query_expense=mysqli_query($con,"SELECT * FROM `$wallet` Where `Category`='Expense'");
        for($i=0;$i<mysqli_num_rows($query_income);$i++)
        {
            $income=mysqli_query($con,"SELECT SUM(Amount) FROM `$wallet` Where `Category`='Income'");
            $total_income[$i]=mysqli_fetch_array($income);
        }
        // print_r($total_income);
        $total_expense = Array();
        for($i=0;$i<mysqli_num_rows($query_expense);$i++)
        {
            $expense=mysqli_query($con,"SELECT SUM(Amount) FROM `$wallet` Where `Category`='Expense'");
            $total_expense[$i]=mysqli_fetch_array($expense);
        }
        // print_r($total_expense);
        $total_save = Array();
        $total_save[0][0] = $total_income[0][0] - $total_expense[0][0];
        // print_r($total_save);
        $total_percent_expense = Array();
        $total_percent_expense[0][0]=( $total_expense[0][0] / $total_income[0][0]) *100;
        // print_r($total_percent_expense);
        $total_percent_save = Array();
        $total_percent_save[0][0]=( $total_save[0][0] / $total_income[0][0]) *100;
        // print_r($total_percent_save);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hey <?php echo$username; ?></title>
        <link rel="stylesheet" href="CSS/pop-up.css">
        <link rel="stylesheet" href="CSS/loading.css">
        <link rel="stylesheet" href="CSS/account.css">
        <link rel="stylesheet" href="CSS/custom_scroll.css">
        <link rel="stylesheet" href="CSS/progresscircle.css">
        <style>
            .card:nth-child(1) svg circle:nth-child(2)
            {
                stroke-dashoffset: calc(440 - (440 * <?php echo $total_percent_expense[0][0]; ?>) /100);
                stroke: red;
            }
            .card:nth-child(2) svg circle:nth-child(2)
            {
                stroke-dashoffset: calc(-1 * (440 * <?php echo $total_percent_expense[0][0]; ?>) /100);
                stroke: blue;
            }
        </style>
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
                        <img src="Images/main logo.png" alt="Wallet" id="web-logo">
                    </span>
                    <span id="web-name">
                        Expense Manager
                    </span>
                </div>
                <div class="wallet-dropdown-div">
                    <form method="POST">
                        <select name="wallet" id="wallet-dropdown">
                            <?php
                                $result = mysqli_query($con,"show tables");
                                while($table = mysqli_fetch_array($result))
                                {
                            ?>
                                <option value="<?php echo $table[0]; ?>"><?php echo$table[0]; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <input type="submit" value="Submit" name="submit-wallet">
                    </form>
                </div>
                <div class="logout">
                    <a href="index.php"><button id="logout">Logout</button></a>
                </div>
            </header>
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
                                    <h2><?php echo $total_percent_expense[0][0]; ?><span>%</span></h2>
                                </div>
                            </div>
                            <div class="text">Expenses <br><?php echo $total_expense[0][0]; ?> </div>
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
                                    <h2><?php echo $total_percent_save[0][0]; ?><span>%</span></h2>
                                </div>
                            </div>
                            <div class="text">Savings <br> <?php echo $total_save[0][0]; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sixoptions">
                <div class="upperthree">
                    <div class="first option">Income</div>
                    <div class="second option">Expense</div>
                    <div class="third option"> Records</div>
                </div>
                <div class="lowerthree">
                    <div class="fourth option">Reports</div>
                    <div class="fifth option">Settings</div>
                    <div class="sixth option">Share</div>
                </div>
            </div>
        </div>
        <script src="Js/pop-up.js"></script>
        <script src="Js/loader.js"></script>
    </body>
</html>