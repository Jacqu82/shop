<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}

Layout::AdminTopBar();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {

        $id = $_GET['id'];
        $sql = "DELETE FROM photos WHERE `item_id`=$id";
        $connection->query($sql);

        $sql = "DELETE FROM cart WHERE `item_id`=$id";
        $connection->query($sql);

        $sql = "DELETE FROM orders WHERE `item_id`=$id";
        $connection->query($sql);

        $sql = "DELETE FROM item WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Error");
        }
        header('Location: itemPanel.php');
    }
}
