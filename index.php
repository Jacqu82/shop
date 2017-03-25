<!DOCTYPE HTML>
<?php
require_once 'connection.php';
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
                echo "Witaj " . $_SESSION['user'] . " | " . "<a href='logOut.php'>wyloguj</a>";
                ?>

                <div id="header">
                    <p><i><b>TWITEREK</b></i></p> 
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

                <a href="loginForm.html">Zaloguj</a>&nbsp;|&nbsp; <a href="registerForm.html">Zarejestruj</a> 

                <div id="header">
                    <p><i><b>SHOP</b></i></p> 
                </div>

                <div id="main">
                    <p>Zaloguj się aby korzystać z naszego serwisu.</p>
                    <p>Jeżeli nie masz u nas konta zarejestruj się!</p>
                </div>
            </div>
        </body>
    </html>
    <?php
};
?>
