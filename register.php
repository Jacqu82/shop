<?php

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        
        
        $sql = "INSERT INTO users (`name`, `surname`, `email`, `password`, `address`) VALUES ('$name', '$surname', '$email', '$password', '$address')";
        
        //$sql = "SELECT * FROM user";
        
        $ready = $connection->query($sql);
        
        if (!$ready) {
            die($connection->connect_error);
        }
    }
}