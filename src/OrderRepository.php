<?php

class OrderRepository
{
    public static function saveOrder(mysqli $connection, $userId, $sum, $date, $status)
    {
        $sql = "INSERT INTO orders(user_id, amount, date, status) VALUES ('$userId', '$sum', '$date', '$status' )";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd zapisu do bazy danych" . $connection->connect_errno);
        }
    }

    public static function selectAllFromOrderByUserId(mysqli $connection)
    {
        $userId = $_SESSION['id'];
        $userId = intval($userId);
        $sql = "SELECT * FROM orders WHERE user_id=$userId";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->errno);
        }
        return $result;
    }

    public static function getOrderById(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM orders WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczytu z bazy danych hej");
        }

        $orderArray = $result->fetch_assoc();
        return $orderArray;
    }

    public static function updateStatus(mysqli $connection, $id)
    {
        $sql = "UPDATE orders SET status=1 WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd zapisu w bazie danych" . $connection->connect_errno);
        }
    }
}
