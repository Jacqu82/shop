<?php

require_once '../connection.php';
require_once 'autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['address'])) {

        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $surname = mysqli_real_escape_string($connection, $_POST['surname']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $address = mysqli_real_escape_string($connection, $_POST['address']);

        $user = new User();
        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setAddress($address);
        $userRepository = new UserRepository();
        $userRepository->saveToDB($user, $connection);
    }
}
