<?php

require_once 'connection.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

//jeżeli ktoś wpisze z palca w przeglądarce userPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę główną.

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

?>

<html>
<head>
    <title>Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css?h=1" rel="stylesheet">
</head>
<body>
<div class="container">

    <?php
    //górny pasek z podstawowymi funkcjonalnościami użytkownika
        Layout::UserTopBar();
    ?>
    <hr>
    <div class="wrapper">
        <ul><span>Jesteś w panelu użytkownika <br>Masz do wyboru następujące opcje:</span>
            <li><a href="changeUserData.php">Zmień swoje dane</a></li>
            <li><a href="shopHistory.php">Pokaż historię zakupów</a></li>
            <li><a href="userMessages.php">Skrzynka odbiorcza</a></li>
            <li><a href="payForProducts.php">Płatności</a></li>
        </ul>
    </div>
</div>
</body>
</html>