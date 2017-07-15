<?php

class ItemRepository extends Item
{
    public static function loadItemByName(mysqli $connection, $name)
    {
        $name = $connection->real_escape_string($name);
        $sql = "SELECT * FROM `item` WHERE `name` = '$name'";
        $result = $connection->query($sql);
        if (!$result) {
            die("Error" . $connection->connect_error);
        } else {
            $itemArray = $result->fetch_assoc();
            $item = new Item();
            $item->setName($itemArray['name']);
            $item->setDescription($itemArray['description']);
            $item->setPrice($itemArray['price']);
            $item->setAvailability($itemArray['availability']);
            $item->setId($itemArray['id']);
            return $item;
        }
    }

    public static function parametersReceiver(mysqli $connection)
    {
        $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1 ";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd odczytu z bazy danych" . $connection->error);
        }
        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];
            $description = $value['description'];
        }
        $id = intval($id);
        $sql = "SELECT * FROM photos WHERE item_id = $id LIMIT 1";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd odczyu z bazy danych" . $connection->error);
        }
        foreach ($result as $value) {
            $path = '../' . $value['path'];
        }
        $array = [
            'id' => $id,
            'path' => $path,
            'name' => $name,
            'price' => $price,
            'availability' => $availability,
            'description' => $description
        ];
        return $array;
    }

    public static function getAllData(mysqli $connection, $id)
    {
        //$result = ItemRepository::getItemById($connection, $id);
        $sql = "SELECT * FROM item WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_error);
        }
        foreach ($result as $value) {
            $name = $value['name'];
            $price = $value['price'];
            $description = $value['description'];
            $availability = $value['availability'];
        }
        $array = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'availability' => $availability,
            'description' => $description
        ];
        return $array;
    }

    public static function getAllPhotos(mysqli $connection, $id)
    {
        //$result = ItemRepository::getPhotoPath($connection, $id);
        $sql = "SELECT * FROM photos WHERE item_id = $id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Error na photosie" . $connection->error);
        }
        $paths = [0 => '', 1 => '', 2 => '', 3 => ''];
        $i = 0;
        foreach ($result as $value) {
            $paths[$i] = '../' . $value['path'];
            $i++;
        }
        for ($i = 0; $i != 4; $i++) {
            if ($paths[$i] == '') {
                $paths[$i] = $paths[$i - 1];
            }
        }
        return $paths;
    }
}
