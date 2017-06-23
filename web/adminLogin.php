<?php

require_once '../connection.php';
require_once 'autoload.php';

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        $admin = Admin::loadAdminByName($connection, $name);

        if ($admin == false) {
            die("Incorrect admin name");
        }

        if ($password == $admin->getPassword()) {

            $_SESSION['admin'] = $admin->getId();
            $_SESSION['adminName'] = $admin->getName();

            header('Location: ../adminPanel.php');
        } else {
            die("Incorrect password!!!");
        }
    }
}
