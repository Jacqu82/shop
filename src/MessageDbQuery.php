<?php
/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 28.05.17
 * Time: 09:26
 */

class MessageDbQuery
{
    static public function selectAllFromUsersAndMessage(mysqli $connection)
    {
        $sql = "SELECT * FROM users u LEFT JOIN message m ON u.id = m.user_id";

        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }
        return $result;
    }

    static public function selectFromUsersAndMessageById(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM message m LEFT JOIN users u ON m.user_id = u.id WHERE m.id = $id";

        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }
        return $result;
    }

    static public function deleteMessage ($connection, $id)
    {
        $sql = "DELETE FROM message WHERE id=$id";

        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }
    }

    static public function send (mysqli $connection, $title, $content, $id, $date)
    {
        $sql = "INSERT INTO message(user_id, title, content, date) VALUES ('$id', '$title', '$content', '$date')";

        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }
        return $result;
    }
}