<?php

class MessageRepository
{
    public static function saveMessage(mysqli $connection, $adminId, $receiverId, $messageTitle, $messageContent, $creationDate, $messageStatus)
    {
        $sql = /** @lang text */
            "INSERT INTO message (adminId, receiverId, messageTitle, messageContent, creationDate, messageStatus)
                VALUES ('$adminId', '$receiverId', '$messageTitle', '$messageContent', '$creationDate', '$messageStatus')";

        $result = $connection->query($sql);

        if(!$result) {
            die("Błąd zapisu do bazy danych" . $connection->error);
        } else {
            $id = $connection->insert_id;
            return $id;
        }
    }

    public static function updateMessageStatus(mysqli $connection, $messageStatus, $id)
    {
        $sql = /** @lang text */
            "UPDATE message SET messageStatus = '$messageStatus' WHERE id = $id";
        $result = $connection->query($sql);

        if ($result) {
            return true;
        }
    }
}