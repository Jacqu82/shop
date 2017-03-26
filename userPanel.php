<?php
require_once 'connection.php';
require_once 'src/User.php';

session_start();

//jeżeli ktoś wpisze z palca w przeglądarce userPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę głóœną.

if (!isset($_SESSION['user'])) {
    header('Location: index.php');      
}

?>

 <html>
        <head>
            <meta charset="utf-8"/>
            <title>Shop</title>
        </head>

        <body>
            <div id="container">
                

                <?php
                echo "Hello " . $_SESSION['user'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a>";
                ?>
                <hr>
                <ul>You are in users panel. In thi section You can :
                    <li><a href="changeUserData.php">Change Your data</a></li>
                    <li><a href="">Show shopping history</a> </li>
                    <li><a href="">Read messages</a></li>
                </ul>
            </div>
        </body>
    </html>