<?php

require_once 'User.php';

class UserRepository extends User
{
    public static function loadUserByName(mysqli $connection, $name)
    {
        $name = $connection->real_escape_string($name);
        $sql = /** @lang text */
            "SELECT * FROM `users` WHERE `name` = '$name'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_error);
        }
        if ($result->num_rows == 1) {
            $userArray = $result->fetch_assoc();
            $user = new User();
            $user->setName($userArray['name']);
            $user->setSurname($userArray['surname']);
            $user->setEmail($userArray['email']);
            $user->setAddress($userArray['address']);
            $user->setPassword($userArray['password']);
            $user->setId($userArray['id']);
            return $user;
        } else {
            return false;
        }
    }
}
