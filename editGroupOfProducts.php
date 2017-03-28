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
        $sql = "SELECT * FROM groups WHERE id=$id";
        $connection = new mysqli($host, $user, $password, $database);
        $result = $connection->query($sql);
        
        if (!$result) {
            die ("error" . $connection->connect_error);
        }
        
        foreach ($result as $value) {
            $name = $value['groupName'];
            $description = $value['group descriptiopn'];
        }
        
        echo $name . " | " . $description;
    }
}

?>