<?php

require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        
        $sql = "INSERT INTO users (`name`, `surname`, `email`, `password`, `address`) VALUES ('$name', '$surname', '$email', '$password', '$address')";

        $ready = $connection->query($sql);
        
        if ($ready) {
            echo "Poprawnie utworzyłeś swoje konto na Aledrogo.pl!<br/>";
            echo "<a href='loginForm.html'>Zaloguj się na swoje konto</a>";
        } else {
            echo "Wystąpił błąd podczas rejestracji, spróbuj jeszcze raz!";
            die("Connection Error! " . $connection->connect_error);
        }
    }
}