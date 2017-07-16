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

    public static function saveNewUser(mysqli $connection, $name, $surname, $email, $password, $address)
    {
        $sql = /** @lang text */
            "INSERT INTO users(name, surname, email, password, address) VALUES ('$name', '$surname', '$email', '$password', '$address')";
        $result = $connection->query($sql);

        if (!$result) {
            die("Blad zapisu do bazy danych" . $connection->error);
        }
        return $result;
    }

    public static function updateUser(mysqli $connection, $email, $name, $surname, $password, $address, $id)
    {
        $sql = /** @lang text */
            "UPDATE users SET email = '$email',
                                    name = '$name',
                                    surname = '$surname',
                                    password = '$password'
                                    address = '$address'
                                    WHERE id = $id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Blad zapisu do bazy danych" . $connection->error);
        }
    }


    public function saveToDB(User $user, mysqli $connection)
    {
        if ($user->id == -1) {
            $result = self::saveNewUser($connection, $user->name, $user->surname, $user->email, $user->password, $user->address);
            if ($result) {
                $user->id = $connection->insert_id;
                echo "<h3>Cieszymy się że tu jesteś,  " . $user->name . "</h3>";
                echo "  <h3><a href='../web/loginForm.html' class='btn btn - primary btn - block'>Zaloguj się na swoje konto</a></h3>";
            } else {
                echo "Wystąpił błąd podczas rejestracji, spróbuj jeszcze raz!<br/>";
                die("Connection Error! " . $connection->connect_error);
            }
        } else {
            self::updateUser($connection, $user->email, $user->name, $user->surname, $user->password, $user->address, $user->id);
        }
        return false;
    }

}
