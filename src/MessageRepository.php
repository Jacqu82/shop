<?php

require_once 'Message.php';

class MessageRepository extends Message
{

    public static function loadAllSendMessagesByAdminId(mysqli $connection, $adminId)
    {
        $adminId = $connection->real_escape_string($adminId);
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

    public static function loadAllReceivedMessagesByUserId(mysqli $connection, $userId)
    {
        $userId = $connection->real_escape_string($userId);
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

    public static function loadLastSendMessageByAdminId(mysqli $connection, $userId)
    {
        $userId = $connection->real_escape_string($userId);
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

    public static function loadMessageById(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $sql = /** @lang text */
            "SELECT * FROM `message` WHERE `id` = $id";
        $result = $connection->query($sql);

        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

        $message = new Message();
        $message->setId($row['id']);
        $message->setReceiverId($row['receiverId']);
        $message->setAdminId($row['adminId']);
        $message->setMessageTitle($row['messageTitle']);
        $message->setMessageContent($row['messageContent']);
        $message->setCreationDate();


            return $message;
        }
        return null;
    }

    public static function getUnreadMessage(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $sql = "SELECT messageStatus FROM message WHERE receiverId=$id AND messageStatus=0";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczytu z bazy danych" . $connection->connect_errno);
        }

        $i = 0;
        foreach ($result as $value) {
            $i++;
        }

        if ($i < 1) {
            echo '0';
        } else {
            echo $i;
        }
    }
}
