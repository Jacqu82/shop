<?php

class Order
{
    protected $status;
    
    function __construct($status)
    {
        $this->status = $status;
    }
    
    function getStatus()
    {
        return $this->status;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }
    
    public function showAll()
    {
        
    }
    
}