<?php

class Message
{
    protected $text;
    
    protected $date;
    
    protected $receiver;
    
    function __construct($text, $date, $receiver)
    {
        $this->text = $text;
        $this->date = $date;
        $this->receiver = $receiver;
    }
    
    function getText()
    {
        return $this->text;
    }

    function getDate()
    {
        return $this->date;
    }

    function getReceiver()
    {
        return $this->receiver;
    }

    function setText($text)
    {
        $this->text = $text;
    }

    function setDate($date)
    {
        $this->date = $date;
    }

    function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }



}