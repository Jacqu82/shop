<?php
include_once '../../connection.php';
include_once '../../config.php';
require_once '../../autoload.php';
require_once '../../layout/Layout.php';
require_once '../Item.php';
require_once '../UserRepository.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: web/index.php');
}

Layout::userTopBar();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = intval($id);

        $sql = "DELETE FROM cart WHERE `item_id`=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }
        header('Location: ../../web/koszyk.php');
    }
}
