<?php

require_once 'Order.php';

class OrderRepository extends Order
{
    public static function payForProducts(mysqli $connection)
    {
        $userId = $_SESSION['id'];
        $userId = intval($userId);
        $sql = "SELECT * FROM orders WHERE user_id=$userId";
        $result = $connection->query($sql);
        Layout::payForProducts($result);
        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->errno);
        }
        return $result;
    }

    public static function loadOrderById(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $sql = "SELECT * FROM orders WHERE id=$id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd odczytu z bazy danych hej");
        }
        $orderArray = $result->fetch_assoc();
        $order = new Order();
        $order->setUserId($orderArray['user_id']);
        $order->setStatusId($orderArray['status']);
        $order->setId($orderArray['id']);
        $order->setAmount($orderArray['amount']);
        $order->setDate($orderArray['date']);
        return $order;
    }

    public static function saveNewOrder(mysqli $connection, $userId, $sum, $date, $status)
    {
        $sql = "INSERT INTO orders(user_id, amount, date, status) VALUES ('$userId', '$sum', '$date', '$status' )";
        $result = $connection->query($sql);
        if (!$result) {
            die ("Błąd zapisu do bazy danych" . $connection->connect_errno);
        }
    }

    public static function updateOrder(mysqli $connection, $id)
    {
        $sql = "UPDATE orders SET status=1 WHERE id=$id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd zapisu w bazie danych!" . $connection->error);
        }
    }

    public function saveToDb(mysqli $connection, Order $order)
    {
        if ($order->id == -1) {
            self::saveNewOrder($connection, $order->userId, $order->sum, $order->date, $order->statusId);
        } else {
            self::updateOrder($connection, $order->id);
        }
    }
}
