<?php

require_once 'connection.php';
require_once 'autoload.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        
        $admin = Admin::loadAdminByName($connection, $name);

        var_dump($admin);
        
        if ($admin == false) {
            die("Incorrect admin name");
        }
        
        if ($password == $admin->getPassword()) {
            echo $admin->getName() . "<br>";
            echo $admin->getEmail();
            echo $admin->getPassword();
            
            $_SESSION['admin'] = $admin->getName();
            var_dump($_SESSION);
            
            header('Location: adminPanel.php');
        } else {
            die("Incorrect password!!!");
        }
        
    }
}

