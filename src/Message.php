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

    public function setMessageStatus($messageStatus)
    {
        $this->messageStatus = $messageStatus;
    }
}
