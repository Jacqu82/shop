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

    public static function getAllSendMessageByUserId(mysqli $connection, $userId)
    {
        $sql = /** @lang text */
            "SELECT user.username,
            message.id,
            message.messageTitle as title,
            message.messageContent as content,
            message.creationDate as date
            FROM message
            JOIN user ON message.receiverId = users.id
            WHERE message.senderId = $userId
            ORDER BY creationDate DESC";

        $result = $connection->query($sql);

        if ($result == false) {
            die("Connection Error" . $connection->error);
        }
        return $result;
    }

    public static function getAllSendMessageByAdminId(mysqli $connection, $adminId)
    {
        $sql = /** @lang text */
            "SELECT
            message.id as id,
            message.messageTitle,
            message.messageContent,
            message.creationDate,
            message.messageStatus,
            u.name,
            u.surname
            FROM message
            LEFT JOIN admins
            ON admins.id = message.adminId
            LEFT JOIN users u
            ON u.id = message.receiverId
            WHERE message.adminId = $adminId
            ORDER BY creationDate DESC";

        $result = $connection->query($sql);

        if ($result == false) {
            die("Connection Error" . $connection->error);
        }

        $arrResult = [];
        while ($row = $result->fetch_assoc()) {
            $arrResult[] = $row;
        }
        return $arrResult;
    }

    public static function setMessageStatus(mysqli $connection, $messageId, $status)
    {
        $sql = /** @lang text */
            "UPDATE message SET messageStatus = '$status' WHERE id = $messageId";
        $result = $connection->query($sql);

        if ($result == false) {
            die("Connection Error" . $connection->error);
        }
        return true;
    }

    public static function getAllReceiveddMessageByUserId(mysqli $connection, $userId)
    {
        $sql = /** @lang text */
            "SELECT
            message.id as id,
            message.messageTitle as title,
            message.messageContent as content,
            message.creationDate as date,
            message.messageStatus as status,
            a.adminName as admin,
            u.name,
            u.surname
            FROM message
            LEFT JOIN admins a
            ON a.id = message.adminId
            LEFT JOIN users u
            ON u.id = message.receiverId
            WHERE message.receiverId = $userId
            ORDER BY creationDate DESC";

        $result = $connection->query($sql);

        if ($result == false) {
            die("Connection Error" . $connection->error);
        }
        return $result;
    }

    public static function getLastSendMessageByUserId(mysqli $connection, $userId)
    {
        $sql = /** @lang text */
            "SELECT users.name,
            users.surname,
            message.adminId,
            messageTitle as title,
            message.messageContent as content,
            message.creationDate as date
            FROM message
            JOIN users ON message.receiverId = users.id
            WHERE message.adminId = $userId
            ORDER BY creationDate DESC LIMIT 1";

        $result = $connection->query($sql);

        if ($result == false) {
            die("Connection Error" . $connection->error);
        }
        return $result;
    }

    public static function getMessageById(mysqli $connection, $id)
    {
        $sql = /** @lang text */
            "SELECT * FROM `message` WHERE `id` = $id";
        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public static function getUnreadMessage(mysqli $connection, $id)
    {
        $sql = "SELECT messageStatus FROM message WHERE receiverId=$id AND messageStatus=0";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczytu z bazy danych" . $connection->connect_errno);
        }

        return $result;
    }

    public static function deleteMessage(mysqli $connection, $id)
    {
        $sql = /** @lang text */
            "DELETE FROM message WHERE id = $id";
        $result = $connection->query($sql);

        return $result;
    }
}