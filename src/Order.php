<?php


include_once "../connection.php";
include_once "Item.php";

class Order
{
    protected $id;
    protected $statusId;
    protected $userId;

    function __construct($userId)
    {
        $this->id = -1;
        $this->statusId = 1;
        $this->setUserId($userId);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }


    function getStatusId()
    {
        return $this->statusId;
    }

    function setStatusId($statusId)
    {
        $this->statusId = $statusId;
        return $this;
    }

    public function showAll()
    {

    }

}