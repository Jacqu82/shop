<?php

require_once '../../connection.php';
require_once '../../config.php';
require_once '../../layout/Layout.php';
require_once 'autoload.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['photo_id']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = intval($id);
        $photoId = $_GET['photo_id'];
        $photoId = intval($photoId);
        $path = SqlQueries::selectAllFromPhotosById($connection, $photoId);
        unlink($path);
        $sql = "DELETE FROM photos WHERE `id`=$photoId";
        $connection->query($sql);
        header("Location: editItem.php?id=" . $id);
    }
}
