<?php

include_once 'Item.php';

class Admin
{

    protected $name;
    protected $email;
    protected $password;

    /**
     * Admin constructor.
     * @param $name
     * @param $email
     * @param $password
     */
    public function __construct()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    function setPassword($password)
    {
        $this->password = $password;
    }

        
    public function getPassword()
    {
        return $this->password;
    }
    
    static public function loadAdminByName(mysqli $connection, $name)
    {   
        $name = $connection->real_escape_string($name);
        
        $sql = "SELECT * FROM `admins` WHERE `adminName` = '$name'";

        $result = $connection->query($sql);

        if (!$result) {
            die("Error " . $connection->connect_error);
        }
        
        if ($result->num_rows == 1) {
            $adminArray = $result->fetch_assoc();

            $admin = new Admin();
            
            $admin->setName($adminArray['adminName']);
            $admin->setEmail($adminArray['adminMail']);
            $admin->setPassword($adminArray['adminPassword']);
            
            return $admin;
            
        } else {
            return false;
        }
    }
    
    // trzy metody do obsługi przedmiotów
    
    public function addItem()
    {
        $item = new Item();
        $item->setName($item);
    }
    
    public function removeItem()
    {
        
    }
    
    public function modifyItem()
    {
        
    }
    
    //trzy metody do obsługi grup przedmiotów
    
    public function addGroup()
    {
        
    }
    
    public function removeGroup()
    {
        
    }
    
    public function modifyGroup()
    {
        
    }

}