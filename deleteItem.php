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
    if (isset($_GET['id'])) {
        
        $id = $_GET['id'];
        
        $sql = "DELETE FROM photos WHERE `item_id`=$id";
  
        $connection = new mysqli($host, $user, $password, $database);
        
        $connection->query($sql);
        
        $sql = "DELETE FROM item WHERE id=$id";
        
        $result = $connection->query($sql);
        
        if (!$result) {
            die ("Error");
        }
        
        header('Location: itemPanel.php');
    }
}