<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');      
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (isset($_GET['photo_id']) && isset($_GET['id'])) {
        
        $id = $_GET['id'];
        $photoId = $_GET['photo_id'];
        
        $connection = new mysqli($host, $user, $password, $database);
        
        $sql = "SELECT * FROM photos WHERE `id` = $photoId";
        $result = $connection->query($sql);
        
        foreach ($result as $value) {
            $path = $value['path'];
        }

        unlink($path);
        
        $sql = "DELETE FROM photos WHERE `id`=$photoId";
        $connection->query($sql);

        header("Location: editItem.php?id=" . $id);
    }
}
