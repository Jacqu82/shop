<?php

class ItemRepository
{


    public static function getItemByName(mysqli $connection, $name)
    {
        $sql = "SELECT * FROM `item` WHERE `name` = '$name'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Error" . $connection->connect_error);
        }

        return $result;
    }

    public static function saveItem(mysqli $connection, $name, $description, $price, $availability, $id)
    {
        $sql = "UPDATE item SET name='$name', description='$description', price='$price', availability=$availability WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd zapisu do bazy danych" . $connection->error);
        }
    }

    public static function updateItem(mysqli $connection, $name, $description, $price, $availability, $group)
    {
        $sql = "INSERT INTO `item` (`name`, `price`, `description`, `availability`, `group_id`) VALUES ('$name', $price, '$description', $availability, $group)";
        $result = $connection->query($sql);

        if(!$result) {
            die("Błąd zpaisu do bazy danych" . $connection->error);
        } else {
            $id = $connection->insert_id;
            return $id;
        }
    }

    public static function getItemDataLimitOne(mysqli $connection)
    {
        $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1 ";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczytu z bazy danych" . $connection->error);
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

    public static function deleteItem(mysqli $connection, $id)
    {
        $sql = "DELETE FROM photos WHERE `item_id`=$id";
        $result = $connection->query($sql);

        if(!$result) {
            die("Błąd zapisu w bazie danych" . $connection->error);
        }

        $sql = "DELETE FROM cart WHERE `item_id`=$id";
        $result = $connection->query($sql);

        if(!$result) {
            die("Błąd zapisu w bazie danych" . $connection->error);
        }

        $sql = "DELETE FROM item WHERE id=$id";
        $result = $connection->query($sql);

        if(!$result) {
            die("Błąd zapisu w bazie danych" . $connection->error);
        }

        return true;
    }

    public static function getItemById(mysqli $connection, $id)
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
}