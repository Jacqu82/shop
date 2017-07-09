<?php

class UserRepository
{
    public static function saveUser(mysqli $connection, $name, $surname, $email, $password, $address)
    {
        $sql = /** @lang text */
            "INSERT INTO users(name, surname, email, password, address) VALUES ('$name', '$surname', '$email', '$password', '$address')";
        $result = $connection->query($sql);
        return $result;
    }

    public static function updateUser(mysqli $connection, $name, $surname, $email, $password, $address, $id)
    {
        $sql = /** @lang text */
            "UPDATE users SET email = '$email',
                                    name = '$name',
                                    surname = '$surname',
                                    password = '$password'
                                    address = '$address'
                                    WHERE id = $id";

        $result = $connection->query($sql);
        if ($result) {
            return true;
        } else {
            die("Error" . $connection->error);
        }
    }

    public static function getUserById(mysqli $connection, $name)
    {
        $sql = /** @lang text */
            "SELECT * FROM `users` WHERE `name` = '$name'";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_error);
        }
        return $result;
    }
}