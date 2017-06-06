<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';

session_start();

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
    echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a><hr>";
    echo "<p><a href='adminPanel.php'><--Powrót</a></p>";
    Message::showAllMEssages($connection);