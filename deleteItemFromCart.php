<?php
include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

echo "Witaj " . $_SESSION['user'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {

        $id = $_GET['id'];
        $sql = "DELETE FROM cart WHERE `item_id`=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }
        header('Location: koszyk.php');
    }
}
