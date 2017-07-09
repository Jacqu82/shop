<?php

class Order
{
    protected $id;
    protected $statusId;
    protected $userId;
    protected $amount;
    protected $date;

    function __construct()
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

    function getStatusId()
    {
        return $this->statusId;
    }

    function setStatusId($statusId)
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

    public function saveToDB(mysqli $connection, $userId, $sum, $date, $status)
    {
        $userId = $connection->real_escape_string($userId);
        $sum = $connection->real_escape_string($sum);
        $date = $connection->real_escape_string($date);
        $status = $connection->real_escape_string($status);
        OrderRepository::saveOrder($connection, $userId, $sum, $date, $status);
    }

    public static function payForProducts($connection)
    {
        $result = OrderRepository::selectAllFromOrderByUserId($connection);
        Layout::payForProducts($result);
    }

    public static function loadOrderById(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $orderArray = OrderRepository::getOrderById($connection, $id);
        $order = new Order();

        $order->setUserId($orderArray['user_id']);
        $order->setStatusId($orderArray['status']);
        $order->setId($orderArray['id']);
        $order->setAmount($orderArray['amount']);
        $order->setDate($orderArray['date']);

        return $order;

    }

    public function updateStatus($connection)
    {
        $id =   $this->id;
        OrderRepository::updateStatus($connection, $id);
    }
}
