<?php

class Message
{
    protected $id;
    protected $adminId;
    protected $receiverId;
    protected $messageTitle;
    protected $messageContent;
    protected $creationDate;
    protected $messageStatus;


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

    protected function setId($id)
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
