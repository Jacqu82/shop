<?php

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

    static public function loadItemByName(mysqli $connection, $name)
    {
        $sql = "SELECT * FROM `item` WHERE `name` = '$name'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Error" . $connection->connect_error);
        }

        if ($result->num_rows == 1) {

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

            $sql = "UPDATE item SET name='$name', description='$description', price='$price', availability=$availability WHERE id=$id";
            $result = $connection->query($sql);

            if (!$result) {
                die("Error");
            }
        } else {

            $name = $this->getName();
            $description = $this->getDescription();
            $group = $this->getGroup();
            $price = $this->getPrice();
            $availability = $this->getAvailability();

            $sql = "INSERT INTO `item` (`name`, `price`, `description`, `availability`, `group_id`) VALUES ('$name', $price, '$description', $availability, $group)";

            $result = $connection->query($sql);

            if ($result) {
                $this->id = $connection->insert_id;  //id ostatnio wstawionego wiersza.
            } else {
                die("Error: item not saved: " . $connection->error);
            }
        }
    }

}
