<?php

require_once 'newItemCreation.php';
require_once 'SqlQueries.php';
require_once 'ItemRepository.php';

class Item
{
    protected $id;
    protected $name;
    protected $price;
    protected $description;
    protected $availability;
    protected $group;

    public function __construct()
    {
        $this->id = -1;
        $this->name = "";
        $this->price = null;
        $this->description = "";
        $this->availability = null;
    }

    function getGroup()
    {
        return $this->group;
    }

    function setGroup($group)
    {
        $this->group = $group;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getAvailability()
    {
        return $this->availability;
    }

    public function setAvailability($availability)
    {
        $this->availability = $availability;
        return $this;
    }

    public static function loadItemByName(mysqli $connection, $name)
    {
        $name = $connection->real_escape_string($name);
        $result = ItemRepository::getItemByName($connection, $name);

        if ($result) {
            $itemArray = $result->fetch_assoc();

            $item = new Item();
            $item->setName($itemArray['name']);
            $item->setDescription($itemArray['description']);
            $item->setPrice($itemArray['price']);
            $item->setAvailability($itemArray['availability']);
            $item->setId($itemArray['id']);

            return $item;
        } else {
            return false;
        }
    }

    public function save(mysqli $connection)
    {
        if ($this->id != -1) {

            $name = $this->getName();
            $description = $this->getDescription();
            $id = $this->getId();
            $price = $this->getPrice();
            $availability = $this->getAvailability();
            ItemRepository::saveItem($connection, $name, $description, $price, $availability, $id);

        } else {

            $name = $this->getName();
            $description = $this->getDescription();
            $group = $this->getGroup();
            $price = $this->getPrice();
            $availability = $this->getAvailability();
            $this->id = ItemRepository::updateItem($connection, $name, $description, $price, $availability, $group);
        }
    }

    public static function parametersReceiver(mysqli $connection)
    {
        $result = ItemRepository::getItemDataLimitOne($connection);

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];
            $description = $value['description'];
        }

        $result = ItemRepository::getPhotoPathLimitOne($connection, $id);

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

    public function deleteItem(mysqli $connection)
    {
        $id = $this->id;
        $id = intval($id);

        if (ItemRepository::deleteItem($connection, $id)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllData(mysqli $connection, $id)
    {
        $result = ItemRepository::getItemById($connection, $id);

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
        $result = ItemRepository::getPhotoPath($connection, $id);
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
