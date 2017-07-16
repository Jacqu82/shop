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

    public function saveToDb(mysqli $connection, Item $item)
    {
        if ($item->id == -1) {
            $name = $item->getName();
            $description = $item->getDescription();
            $groupId = $item->getGroup();
            $price = $item->getPrice();
            $availability = $item->getAvailability();
            self::addNewItem($connection, $name, $description, $price, $availability, $groupId);
            $item->id = $connection->insert_id;
        } else {
            $name = $item->name;
            $description = $item->description;
            $id = $item->id;
            $price = $item->price;
            $availability = $item->availability;
            $item->id = self::updateItem($connection, $name, $description, $price, $availability, $id);
        }
    }

    public static function saveItem(mysqli $connection, $name, $description, $price, $availability, $id)
    {
        $sql = "UPDATE item SET name='$name', description='$description', price='$price', availability=$availability WHERE id=$id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd zapisu do bazy danych" . $connection->error);
        }
    }

    public static function addNewItem(mysqli $connection, $name, $description, $price, $availability, $groupId)
    {
        $sql = "INSERT INTO item (name, price, description, availability, group_id) VALUES ('$name', '$price', '$description', '$availability', '$groupId')";
        $result = $connection->query($sql);
        if (!$result) {
            die("Blad zapisu do bazy danych czemuuuuu");
        } else {
            return true;
        }
    }

    public static function updateItem(mysqli $connection, $name, $description, $price, $availability, $id)
    {
        $sql = "UPDATE item SET name='$name', price='$price', description='$description', availability='$availability' WHERE id='$id' ";
        $result = $connection->query($sql);
        if (!$result) {
            die("Blad zapisu do bazy danych");
        } else {
            return $connection->insert_id;
        }
    }

    public function deleteFromDb(mysqli $connection, Item $item)
    {
        $id = $item->id;
        $id = intval($id);
        $sql = "DELETE FROM photos WHERE `item_id`=$id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd zapisu w bazie danych" . $connection->error);
        }
        $sql = "DELETE FROM cart WHERE `item_id`=$id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd zapisu w bazie danych" . $connection->error);
        }
        $sql = "DELETE FROM item WHERE id=$id";
        $result = $connection->query($sql);
        if (!$result) {
            die("Błąd zapisu w bazie danych" . $connection->error);
        }
        return true;
    }
}
