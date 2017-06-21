<?php

include_once 'connection.php';
require_once 'autoload.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['name']) && isset($_GET['path'])) {

        $name = $_GET['name'];
        $path = $_GET['path'];

        $item = Item::loadItemByName($connection, $name);

        $id = $item->getId();
        $availability = $item->getAvailability();
        $price = $item->getPrice();

        $userName = $_SESSION['user'];

        $user = User::loadUserByName($connection, $userName);
        var_dump($user);
        $userId = $user->getId();

        echo $name . " | " . $path . " | " . $id . " | " . $availability . " | " . $price . " | " . $userName . " | " . $userId;

        $sql = "INSERT INTO cart(path, user_id, item_id) VALUES('$path', '$userId', '$id' )";

        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd zapisu do bazy danych - Cart" . $connection->connect_errno);
        }
        header("Location: web/koszyk.php");
    }
}
