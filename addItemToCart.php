<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: web/index.php');
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
    <div class="wrapper">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            if (isset($_GET['name']) && isset($_GET['path'])) {

                $name = $_GET['name'];
                $path = $_GET['path'];

                $item = Item::loadItemByName($connection, $name);

                $id = $item->getId();
                $availability = $item->getAvailability();
                if ($availability == 0) {
                    echo "Brak produktu. Prosze spróbować później.<br>";
                    echo "<a style='margin-left: 130px' href='web/product.php?id=" . $id . "'><button>OK</button></a>";

                } else {
                    $price = $item->getPrice();

                    $userName = $_SESSION['user'];

                    $user = User::loadUserByName($connection, $userName);
                    $userId = $user->getId();

                    $sql = "INSERT INTO cart(path, user_id, item_id) VALUES('$path', '$userId', '$id' )";

                    $result = $connection->query($sql);

                    if (!$result) {
                        die ("Błąd zapisu do bazy danych - Cart" . $connection->connect_errno);
                    }
                    header("Location: web/koszyk.php");
                }
            }
        }
        ?>
    </div>
</div>
</body>
</html>
