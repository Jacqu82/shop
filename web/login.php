<?php

require_once 'connection.php';
require_once 'autoload.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];

        $user = User::loadUserByName($connection, $name);

        if ($user == false) {
            echo '<p style="color: red">Niepoprawny login lub hasło!</p>';
            echo '<a href="loginForm.html">Zaloguj się ponownie</a>';
            exit;
        }

        if ($password = $user->getPassword()) {

            $_SESSION['user'] = $user->getName();
            $_SESSION['id'] = $user->getId();

            header('Location: index.php');

        } else {
            echo '<p style="color: red">Niepoprawny login lub hasło!</p>';
            echo '<a href="loginForm.html">Zaloguj się ponownie</a>';
            exit;
        }
    }
}
