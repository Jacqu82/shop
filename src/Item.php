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

}

