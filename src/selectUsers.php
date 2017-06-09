<?php

class selectUsers
{
    public static function selectAllUsers(mysqli $connection)
    {
        $result = self::selectUsersFromDb($connection);

        echo '<form action="#" method="post">';
        echo '<select name="receiverId">';

        foreach ($result as $value) {
            echo '<option value="' . $value['id'] . '">' . $value['surname'] . ' ' . $value['name'] . '</option>';
        }

        echo '</select><br><br>';
        echo 'Tytuł wiadomości:<br>';
        echo '<input type="text" name = "messageTitle"><br>';
        echo 'Treść wiadomości:<br>';
        echo '<textarea name="messageContent" cols="30" rows="5"></textarea>';

        echo '<br><br><input type="submit" value="Wyślij"></form>';
    }

    public static function selectUsersFromDb(mysqli $connection)
    {
        $sql = "SELECT * FROM users";

        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }

        return $result;
    }
}