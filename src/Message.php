<?php

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
        $this->adminId = '';
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

            $this->id = MessageRepository::saveMessage($connection, $this->adminId, $this->receiverId, $this->messageTitle, $this->messageContent, $this->creationDate, $this->messageStatus );
            return true;
        } else {

            if (MessageRepository::updateMessageStatus($connection, $this->messageStatus, $this->id)) {
                return true;
            }
        }
        return false;
    }

    public static function loadAllSendMessagesByUserId(mysqli $connection, $userId)
    {
        $userId = $connection->real_escape_string($userId);
        return MessageRepository::getAllSendMessageByUserId($connection, $userId);

    }

    public static function loadAllSendMessagesByAdminId(mysqli $connection, $adminId)
    {
        $adminId = $connection->real_escape_string($adminId);
        $array = MessageRepository::getAllSendMessageByAdminId($connection, $adminId);
        return $array;
    }


    public static function setMessageStatus(mysqli $connection, $messageId, $status)
    {
        $messageId = $connection->real_escape_string($messageId);
        $status = $connection->real_escape_string($status);

        if(MessageRepository::setMessageStatus($connection, $messageId, $status)) {
            return true;
        } else {
            return false;
        }
    }

    public static function loadAllReceivedMessagesByUserId(mysqli $connection, $userId)
    {
        $userId = $connection->real_escape_string($userId);
        $result = MessageRepository::getAllReceiveddMessageByUserId($connection, $userId);
        return $result;
    }

    public static function loadLastSendMessageByUserId(mysqli $connection, $userId)
    {
        $userId = $connection->real_escape_string($userId);
        $result = MessageRepository::getLastSendMessageByUserId($connection, $userId);
        return $result;
    }

    public static function loadMessageById(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $row = MessageRepository::getMessageById($connection, $id);

        $message = new Message();
        $message->setId($row['id']);
        $message->setReceiverId($row['receiverId']);
        $message->setAdminId($row['adminId']);
        $message->setMessageTitle($row['messageTitle']);
        $message->setMessageContent($row['messageContent']);
        $message->setCreationDate();

        return $message;
    }

    public static function getUnreadMessage(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $result = MessageRepository::getUnreadMessage($connection, $id);

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
            $result = MessageRepository::deleteMessage($connection, $this->getId());
            if ($result) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }
}
