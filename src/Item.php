<?php

class Item
{
    protected $name;
    
    protected $price;
    
    protected $description;
    
    protected $availability;
    
    public function __construct($name, $price, $description, $availability)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->availability = $availability;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param mixed $availability
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }



}

