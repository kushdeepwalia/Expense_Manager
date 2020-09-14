<?php
    session_start();
?>
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
        <link rel="shortcut icon" href="Images/main-logo.png" type="image/x-icon">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <div class="loader">
            <div class="loading">
                <span>Loading...</span>
            </div>
        </div>
        <img src="Images/home-pg-bg.jpg" alt="Background image" style="height: 100vh; width: 100vw; position: fixed;">
        <div class="content hide">
            <?php 
                if(isset($_SESSION['errorUsername'])) 
                    echo"<div class='loginFormError'><script>swal({title:'Username not Exist',text:'Please Enter the Correct One',icon:'warning'});</script></div>";
                if(isset($_SESSION['errorPassword'])) 
                    echo"<div class='loginFormError'><script>swal({title:'Password not Matched with this Username',text:'Please Enter the Correct One',icon:'warning'});</script></div>";
            ?>
            <header class="head">
                <a href="index.php">
                    <div class="logo-head">
                        <img src="Images/main-logo.png" alt="main-logo">
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
                            <div id="error_login"></div>
                            <form id="loginForm" action="Php/login.php" method="post" autocomplete="off">
                                <table class="loginTable">
                                    <tr>
                                        <td class="box"><input type="text" name="Username" id="login-Username" placeholder="Enter your Username"></td>
                                    </tr>
                                    <tr>
                                        <td class="box"><input type="password" name="Password" id="login-Password" placeholder="Enter your Password"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center"><input type="submit" name="submit" value="Login" id="btn"></td>
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
                            <div id="error_register"></div>
                            <form id="registerForm" action="Php/register.php" method="post" autocomplete="off">
                                <table class="loginTable">
                                    <tr>
                                        <td class="box"><input type="text" name="Username" id="register-Username" placeholder="User Name"></td>
                                    </tr>
                                    <tr>
                                        <td class="box"><input type="email" name="email" id="email" placeholder="Email Address"></td>
                                    </tr>
                                    <tr>
                                        <td class="box"><input type="text" name="wallet" id="wallet" placeholder="Enter wallet name"></td>
                                    </tr>
                                    <tr>
                                        <td class="box"><input type="password" name="Password" id="register-Password" placeholder="Enter Password"></td>
                                    </tr>
                                    <tr>
                                        <td class="box"><input type="password" name="ConPassword" id="ConPassword" placeholder="Re-Enter Password"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center"><input type="submit" value="Register" name="register" id="btn"></td>
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
                <p>A complete solution to track your all the expenses bared by your <br> pocket and manage your personal finance.</p>
                
                <button data-modal-target="#slider-frame" id="features">Features <img src="Images/right arrow.png" alt="arrow"></button>
                <div class="slider-frame modal" id="slider-frame">
                    <div class="slide-images">
                        <div class="img-container">
                            <img src="Images/features-1.jpg" alt="Features">
                        </div>
                        <div class="img-container">
                            <img src="Images/features-2.jpg" alt="Features">
                        </div>
                        <div class="img-container">
                            <img src="Images/features-3.jpg" alt="Features">
                        </div>
                        <div class="img-container">
                            <img src="Images/features-5.jpg" alt="Features">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="Js/pop-up.js"></script>
        <script src="Js/loader.js"></script>
        <script src="Js/index-login-validation.js"></script>
        <script src="Js/index-register-validation.js"></script>
    </body>
</html>