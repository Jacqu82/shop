<?php

require_once 'newItemCreation.php';
require_once 'SqlQueries.php';

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

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup($group)
    {
        $this->group = $group;
    }

    protected function setId($id)
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

    public function save(mysqli $connection)
    {
        if ($this->id != -1) {
            $name = $this->getName();
            $description = $this->getDescription();
            $id = $this->getId();
            $price = $this->getPrice();
            $availability = $this->getAvailability();
            $sql = "INSERT INTO `item` (`name`, `price`, `description`, `availability`, `group_id`) VALUES ('$name', $price, '$description', $availability, $id)";
            $result = $connection->query($sql);
            if (!$result) {
                die("Błąd zpaisu do bazy danych" . $connection->error);
            } else {
                $id = $connection->insert_id;
                return $id;
            }
        } else {
            $name = $this->getName();
            $description = $this->getDescription();
            $group = $this->getGroup();
            $price = $this->getPrice();
            $availability = $this->getAvailability();
            //$this->id = ItemRepository::updateItem($connection, $name, $description, $price, $availability, $group);
            $sql = "UPDATE item SET name='$name', description='$description', price='$price', availability=$availability WHERE id=$group";
            $result = $connection->query($sql);
            if (!$result) {
                die("Błąd zapisu do bazy danych" . $connection->error);
            }
        }
        return false;
    }

    public function deleteItem(mysqli $connection)
    {
        $id = $this->id;
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
