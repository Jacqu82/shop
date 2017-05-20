<?php

require_once 'connection.php';
require_once 'src/User.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        
        $user = User::loadUserByName($connection, $name);
        
        if ($user == false) {
            die("Incorrect user");
        }
        
        if ($password == $user->getPassword()) {
            echo $user->getName() . "<br>";
            echo $user->getSurname() . "<br>";
            echo $user->getAddress() . "<br>";
            echo $user->getPassword();
            
            $_SESSION['user'] = $user->getName();
            
            header('Location: index.php');
        } else {
            die("Incorrect password!!!");
        }
        
    }
}

