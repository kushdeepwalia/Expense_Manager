<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Manager</title>
    <link rel="stylesheet" href="CSS/pop-up.css">
    <link rel="stylesheet" href="CSS/loading.css">
    <link rel="stylesheet" href="CSS/custom_scroll.css">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/slideshow.css">
</head>

<body>
    <div class="loader">
        <div class="loading">
            <span>Loading...</span>
        </div>
    </div>
    <div class="content hide">
        <header class="head">
            <a href="index.php">
                <div class="logo-head">
                    <img src="Images/main logo.png" alt="main-logo">
                    <span class="mainhead">Expense Manager</span>
                </div>
            </a>
            <div class="buttons">
                <button data-modal-target="#login" id="loginBtn">Login</button>
                <div class="modal" id="login">
                    <div class="modal-body">
                        <div class="modal-heading">
                            <div class="title">Login</div>
                            <button data-close-button class="close-button">&times;</button>
                        </div>
                        <form action="Php/login.php" method="post" autocomplete="off">
                            <table class="loginTable">
                                <tr>
                                    <td class="box"><input type="text" name="Username" id="Username"
                                            placeholder="Enter your Username"></td>
                                </tr>
                                <tr>
                                    <td class="box"><input type="password" name="Password" id="Password"
                                            placeholder="Enter your Password"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"><input type="submit" value="Login" id="btn"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <button data-modal-target="#register" id="registerBtn">Register</button>
                <div class="modal" id="register">
                    <div class="modal-body">
                        <div class="modal-heading">
                            <div class="title">Register</div>
                            <button data-close-button class="close-button">&times;</button>
                        </div>
                        <form action="Php/register.php" method="post" autocomplete="off">
                            <table class="loginTable">
                                <tr>
                                    <td class="box"><input type="text" name="Username" id="Username"
                                            placeholder="User Name"></td>
                                </tr>
                                <tr>
                                    <td class="box"><input type="email" name="email" id="email"
                                            placeholder="Email Address"></td>
                                </tr>
                                <tr>
                                    <td class="box"><input type="text" name="wallet" id="wallet"
                                            placeholder="Enter wallet name"></td>
                                </tr>
                                <tr>
                                    <td class="box"><input type="password" name="Password" id="Password"
                                            placeholder="Enter Password"></td>
                                </tr>
                                <tr>
                                    <td class="box"><input type="password" name="ConPassword" id="Password"
                                            placeholder="Re-Enter Password"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"><input type="submit" value="Register" name="register"
                                            id="btn"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div id="overlay"></div>
            </div>
        </header>
        <div class="intro">
            <div>
                <span>E</span>
                <h1>track your <br>expense</h1>
            </div>
            <p>
                A complete solution to track your all the expenses bared by your <br> pocket and manage your personal
                finance.
            </p>
            <button data-modal-target="#slider-frame" id="features">Features <img src="Images/right arrow.png"
                    alt="arrow"></button>
            <div class="slider-frame modal" id="slider-frame">
                <div class="slide-images">
                    <div class="img-container">
                        <img src="Images/image1.png" alt="Features">
                    </div>
                    <div class="img-container">
                        <img src="Images/image2.png" alt="Features">
                    </div>
                    <div class="img-container">
                        <img src="Images/image3.png" alt="Features">
                    </div>
                    <div class="img-container">
                        <img src="Images/image4.png" alt="Features">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="Js/pop-up.js"></script>
    <script src="Js/loader.js"></script>
</body>

</html>
<?php
    if(isset($_GET['message']))
    {
        $name_exist=$_GET['message'];
        if(strcmp("Yes",$name_exist))
        {
            echo"<script>alert('Username taken...plz enter another');</script>";
        }
    }
    if(isset($_GET['msg']))
    {
        $pass_match=$_GET['msg'];
        if(strcmp("No",$pass_match))
        {
            echo"<script>alert('Password not matched');</script>";
        }
    }
    if(isset($_GET['login-present']))
    {
        $pass_match=$_GET['login-present'];
        if(strcmp("No",$pass_match))
        {
            echo"<script>alert('No account found...Please try again');</script>";
        }
    }
?>