<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
}

Layout::adminTopBar();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id']) || isset($_GET['name'])) {
        $name = $_GET['name'];
        $item = Item::loadItemByName($connection, $name);

        if (!$item->deleteItem($connection)) {
            die ("Błąd usuwania przedmiotu z bazy danych");
        }
        header('Location: itemPanel.php');
    }
}
