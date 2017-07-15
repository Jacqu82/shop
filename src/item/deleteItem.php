<?php

require_once '../../connection.php';
require_once '../../config.php';
require_once '../../layout/Layout.php';
require_once 'autoload.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
}

Layout::adminTopBar();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id']) || isset($_GET['name'])) {
        $name = $_GET['name'];
        $item = ItemRepository::loadItemByName($connection, $name);

        if (!$item->deleteItem($connection)) {
            die ("Błąd usuwania przedmiotu z bazy danych");
        }
        header('Location: itemPanel.php');
    }
}
