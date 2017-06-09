<?php

//class Message
//{
//    protected $content;
//
//    protected $date;
//
//    protected $title;
//
//    protected $receiverId;
//
//    protected $senderId;
//
//
//    public function getSenderId()
//    {
//        return $this->senderId;
//    }
//
//    public function setSenderId($senderId)
//    {
//        $this->senderId = $senderId;
//    }
//
//    public function getContent()
//    {
//        return $this->content;
//    }
//
//    public function setContent($content)
//    {
//        $this->content = $content;
//    }
//
//    public function getDate()
//    {
//        return $this->date;
//    }
//
//    public function setDate($date)
//    {
//        $this->date = $date;
//    }
//
//    public function getTitle()
//    {
//        return $this->title;
//    }
//
//    public function setTitle($title)
//    {
//        $this->title = $title;
//    }
//
//    public function getReceiverId()
//    {
//        return $this->receiverId;
//    }
//
//    public function setReceiverId($receiverId)
//    {
//        $this->receiverId = $receiverId;
//    }
//
//    public static function showAllMessages(mysqli $connection)
//    {
//        $result = MessageDbQuery::selectAllFromUsersAndMessage($connection);
//
//        echo "<div style='margin-left: 350px; margin-right: auto; margin-top: 50px' >";
//        echo "<p>Sortowanie wg.:</p>";
//
//        echo "<table border=1 cellpadding=5>";
//        echo "<tr>";
//        echo "<th>Date</th><th>User name</th><th>Title</th><th></th>";
//        echo "</tr>";
//        foreach ($result as $value) {
//            if (isset($value['id'])) {
//                $id = $value['id'];
//                echo "<tr>";
//                echo "<td>" . $value['date'] . "</td><td>" . $value['surname'] . " " . $value['name'] . "</td><td>" . $value['title'] . "</td>";
//                echo "<td><a href='showAdminMessage.php?id=$id&i=1'>Pokaż</a></td>";
//                echo "<td><a href='showAdminMessage.php?id=$id&i=0'>Usuń</a></td>";
//            }
//
//        }
//        echo "</table>";
//        echo "</div>";
//    }
//
//    public static function deleteMessage(mysqli $connection, $id)
//    {
//        $result = MessageDbQuery::deleteMessage($connection, $id);
//    }
//
//    public static function showMessage(mysqli $connection, $id)
//    {
//        $result = MessageDbQuery::selectFromUsersAndMessageById($connection, $id);
//
//        foreach ($result as $value) {
//            echo "Tytuł: " . $value['title'] . "<br>";
//            echo "Data: " . $value['date'] . "<br>";
//            echo "Odbiorca: " . $value['surname'] . $value['name'] . "<br>";
//            echo "Treść: <b>" . $value['content'] . "</b>";
//        }
//    }
//
//    public function sendMessage(mysqli $connection, $title, $content, $id)
//    {
//        $date = date('y-m-d');
//        MessageDbQuery::send($connection, $title, $content, $id, $date);
//
//    }
//
//    public static function getUnreadMessage(mysqli $connection, $id)
//    {
//        $sql = "SELECT status FROM message WHERE user_id=$id AND status=0";
//
//        $result = $connection->query($sql);
//
//        if (!$result) {
//            die("Błąd odczytu z bazy danych" . $connection->connect_errno);
//        }
//
//        $i = 0;
//
//        foreach ($result as $value) {
//            $i++;
//        }
//
//        if ($i < 1) {
//            echo '0';
//        } else {
//            echo $i;
//        }
//    }
//}


class Message
{
    private $id;
    private $adminId;
    private $receiverId;
    private $messageTitle;
    private $messageContent;
    private $creationDate;
    private $messageStatus;


    public function __construct()
    {
        $this->id = -1;
        $this->sadminId = '';
        $this->receiverId = '';
        $this->messageTitle = '';
        $this->messageContent = '';
        $this->creationDate = '';
        $this->messageStatus = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function getAdminId()
    {
        return $this->adminId;
    }


    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    }


    public function getReceiverId()
    {
        return $this->receiverId;
    }


    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    public function getMessageTitle()
    {
        return $this->messageTitle;
    }

    public function setMessageTitle($messageTitle)
    {
        $this->messageTitle = $messageTitle;
    }

    public function getMessageContent()
    {
        return $this->messageContent;
    }


    public function setMessageContent($messageContent)
    {
        $this->messageContent = $messageContent;
    }


    public function getCreationDate()
    {
        return $this->creationDate;
    }


    public function setCreationDate()
    {
        $this->creationDate = date('Y-m-d H:i:s');
        return $this;
    }


    public function getMessageStatus()
    {
        return $this->messageStatus;
    }


    public function _setMessageStatus($messageStatus)
    {
        $this->messageStatus = $messageStatus;
    }

    public function saveToDB(mysqli $connection)
    {
        if ($this->id == -1) {
            $sql = /** @lang text */
                "INSERT INTO message (adminId, receiverId, messageTitle, messageContent, creationDate, messageStatus) 
                VALUES ('$this->adminId', '$this->receiverId', '$this->messageTitle', '$this->messageContent', '$this->creationDate', '$this->messageStatus')";

            $result = $connection->query($sql);

            if ($result) {
                $this->id = $connection->insert_id;
            } else {
                die("Connection Error" . $connection->connect_error);
            }
        } else {
            $sql = /** @lang text */
                "UPDATE message SET messageStatus = '$this->messageStatus' WHERE id = $this->id";

            $result = $connection->query($sql);
            if ($result) {
                return true;
            }
        }
        return false;
    }

    static public function loadAllSendMessagesByUserId(mysqli $connection, $userId)
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

    static public function loadAllSendMessagesByAdminId(mysqli $connection, $adminId)
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

        $arrResult =[];
        while ($row = $result->fetch_assoc()) {
            $arrResult[] = $row;
        }

        return $arrResult;
    }


    static public function setMessageStatus(mysqli $connection, $messageId, $status)
    {
        $sql = /** @lang text */
            "UPDATE message SET messageStatus = '$status' WHERE id = $messageId";

        $result = $connection->query($sql);

        if ($result == false) {
            die("Connection Error" . $connection->error);
        }
        return true;
    }

    static public function loadAllReceivedMessagesByUserId(mysqli $connection, $userId)
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

    static public function loadLastSendMessageByUserId(mysqli $connection, $userId)
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

    static public function loadMessageById(mysqli $connection, $id)
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


    public function deleteMessage(mysqli $connection)
    {
        if ($this->id != -1) {
            $sql = /** @lang text */
                "DELETE FROM message WHERE id = $this->id";
            $result = $connection->query($sql);
            if ($result) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }
}
