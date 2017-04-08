<?php

include_once 'connection.php';
require_once 'src/User.php';

session_start();

//jeżeli ktoś wpisze z palca w przeglądarce adminPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę głóœną.

if (!isset($_SESSION['admin'])) {
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
                echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a>";
                ?>
                <hr>
                <ul>You are in admin panel. In thi section You can :
                    <li><a href="groupsOfProducts.php">Add, remove or modify a group of items</a></li>
                    <li><a href="itemPanel.php">Add, remove or modify an item</a> </li>
                    <li><a href="">Send a message</a></li>
                </ul>
            </div>
        </body>
    </html>