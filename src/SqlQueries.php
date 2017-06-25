<?php

class SqlQueries
{
    public static function getItemDataLimitOne(mysqli $connection)
    {
        $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1 ";
        $result = $connection->query($sql);

        if (!$result) {
            die("Error na itemie" . $connection->error);
        }
        return $result;
    }

    public static function getPhotoPathLimitOne(mysqli $connection, $id)
    {
        $id = intval($id);
        $sql = "SELECT * FROM photos WHERE item_id = $id LIMIT 1";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczyu z bazy danych" . $connection->error);
        }
        return $result;
    }

    public static function setAvailability($connection, $quantity, $id)
    {
        $quantity = intval($quantity);
        $id = intval($id);
        $sql = "UPDATE item SET availability = availability - $quantity WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd zapisu do bazy danych" . $connection->connect_errno);
        }
    }

    public static function clearCart($connection, $userId)
    {
        $userId = intval($userId);
        $sql = "DELETE from cart WHERE user_id=$userId";
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

    public static function getItem(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM item WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_error);
        }
        return $result;
    }

    public static function getPhotoPath(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM photos WHERE item_id = $id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Error na photosie" . $connection->error);
        }
        return $result;
    }

    public static function getItemInCart(mysqli $connection)
    {

        $sql = "SELECT * FROM cart c LEFT JOIN users u ON c.user_id=u.id LEFT JOIN item i ON c.item_id=i.id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczytu z bazy danych - Cart" . $connection->connect_errno);
        }
        return $result;
    }

    public static function selectUsersFromDb(mysqli $connection)
    {
        $sql = "SELECT * FROM users";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_errno);
        }
        return $result;
    }

    public static function selectGroup($groupId, mysqli $connection, $selection, $orderSelection)
    {
        $sql = "SELECT * FROM item WHERE group_id=$groupId AND name LIKE '%$selection%' ORDER BY $orderSelection";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych selectgrup" . $connection->connect_error);
        }
        return $result;
    }

    public static function getGallery(mysqli $connection)
    {
        $sql = "SELECT * FROM groups";
        $result = $connection->query($sql);
        if (!$result) {
            die ("Error - błąd połączenia z bazą danych" . $connection->error);
        }
        return $result;
    }

    public static function delete($connection, $photoId)
    {
        $sql = "DELETE FROM photos WHERE id=$photoId";
        $result = $connection->query($sql);

        if (!$result) {
            die("Nie udało się usunąć zdjęcia z bazy danych!");
        }
    }

    public static function insert($connection, $itemId, $path)
    {
        $sql = "INSERT INTO photos (`item_id`, `path`) VALUES('$itemId', '$path')";
        $result = $connection->query($sql);

        if (!$result) {
            die("Nie udało się zapisać zdjęcia do bazy danych!");
        }
    }

    public static function showAllOrdersByUserId(mysqli $connection)
    {
        $userId = $_SESSION['id'];
        $sql = "SELECT * FROM orders WHERE user_id=$userId";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->errno);
        }
    }

    public static function selectAllFromPhotosById($connection, $photoId)
    {
        $sql = "SELECT * FROM photos WHERE `id` = $photoId";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczytu z bazy danych");
        }

        foreach ($result as $value) {
            $path = $value['path'];
        }
        return $path;
    }
}
