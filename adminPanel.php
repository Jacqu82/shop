<?php

include_once 'connection.php';
require_once 'autoload.php';

session_start();

//jeżeli ktoś wpisze z palca w przeglądarce adminPanel.php to jeśli nie jest zalogowany zostanie przeniesiony na stronę główną.

if (!isset($_SESSION['admin'])) {
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
    echo "Witaj " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a>";
    ?>
    <hr>
    <div class="wrapper">
        <ul>Jesteś w panelu administratora <br>Masz do wyboru następujące opcje:
            <li><a href="groupsOfProducts.php">Dodaj, usuń lub modyfikuj grupę przedmiotów.</a></li>
            <li><a href="itemPanel.php">Dodaj, usuń lub modyfikuj przedmiot</a></li>
            <li><a href="deleteUser.php">Usuń użytkownika</a></li>
            <li><a href="sendMessage.php">Wyślij wiadomość</a></li>
            <li><a href="adminMessages.php">Pokaż wysłane wiadomości</a></li>
        </ul>
    </div>
</div>
</body>
</html>