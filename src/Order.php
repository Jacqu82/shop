<?php

class Order
{
    protected $id;
    protected $statusId;
    protected $userId;
    protected $amount;
    protected $date;
    protected $sum;

    public function __construct()
    {
        $this->id = -1;
        $this->statusId = 1;
        $this->userId='';
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

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }
}
