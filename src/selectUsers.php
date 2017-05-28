<?php
/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 25.05.17
 * Time: 22:23
 */

class selectUsers
{
    public static function selectAllUsers (mysqli $connection)
    {
        $sql = "SELECT * FROM users";

        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }

        echo '<form action="#" method="post">';
        echo '<select name="selection">';

        foreach ($result as $value) {
            echo '<option value="' . $value['id'] . '">' . $value['surname'] . ' ' . $value['name'] . '</option>';
        }

        echo '</select><br><br>';
        echo 'Tytuł wiadomości:<br>';
        echo '<input type="text" name = "title"><br>';
        echo 'Treść wiadomości:<br>';
        echo '<textarea name="content" cols="30" rows="5"></textarea>';

        echo '<br><br><input type="submit" value="Wyślij"></form>';
    }
}