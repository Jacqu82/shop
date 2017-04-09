<?php

include_once 'connection.php';
require_once 'src/User.php';
include_once 'config.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');      
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        
        $id = $_GET['id'];
        
        $connection = new mysqli($host, $user, $password, $database);
        
        $sql = "DELETE FROM groups WHERE id=$id";
        
        $result = $connection->query($sql);
        
        if (!$result) {
            die ("Error");
        }
        
        header('Location: groupsOfProducts.php');
    }
}
