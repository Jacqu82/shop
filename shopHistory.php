<?php

require_once 'connection.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();
//
////jeżeli ktoś wpisze z palca w przeglądarce userPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę głóœną.
//
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
    Layout::UserTopBar();
    ?>
    <hr>
    <p><a href='userPanel.php'><--Powrót</a></p>
    <?php

    //tabela wyświetlajaca wszystkie zamówienia i ich status oraz datę złożenia

    Order::payForProducts($connection);
    ?>
</div>
</body>
</html>

