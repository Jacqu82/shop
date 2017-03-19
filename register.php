<?php

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        
        $sql = "INSERT INTO users (`name`, `surname`, `email`, `password`) VALUES ('$name', '$surname', '$email', '$password')";
        
        //$sql = "SELECT * FROM user";
        
        $ready = $connection->query($sql);
        
        if (!$ready) {
            die($connection->connect_error);
        }
        
//        foreach ($ready as $value) {
//            echo $value['name'] . $value['surname'] . $value['email'] . $value['password'];
//        }
    }
}