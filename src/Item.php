<?php

include_once "../connection.php";

class Item
{
    protected $id;
    protected $name;
    protected $price;
    protected $description;
    protected $availability;

    public function __construct()
    {
        $this->id = -1;
        $this->name = "";
        $this->price = null;
        $this->description = "";
        $this->availability = null;
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

}

