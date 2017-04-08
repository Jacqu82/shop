<!DOCTYPE HTML>
<?php
include_once 'connection.php';
require_once 'src/User.php';

session_start();

if (isset($_SESSION['user'])) {
    ?>

    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Shop</title>
        </head>

        <body>
            <div id="container">

                <?php
                echo "Hello " . $_SESSION['user'] . " | " . "<a href='userPanel.php'>Panel</a>" . " | " . "<a href='logOut.php'>wyloguj</a>";
                ?>

                <div id="header">
                    <p><i><b>SHOP</b></i></p> 
                </div>


            </div>
        </body>
    </html>
    <?php
} else {
    ?>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Shop</title>
            <link rel="stylesheet" href="style.css" type="text/css"/>
        </head>

        <body>
            <div id="container">

                <a href="loginForm.html">Login</a>&nbsp;|&nbsp; <a href="registerForm.html">Register</a> 

                <div id="header">
                    <p><i><b>SHOP</b></i></p> 
                </div>

                <div id="main">
                    <p>You need to login to fully enjoy our service.</p>
                    <p>If You haven't register yet, please do that by clicking register option.</p>
                </div>
            </div>
        </body>
    </html>
    <?php
};
?>
