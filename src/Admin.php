<?php

include_once 'Item.php';


class Admin
{

    protected $name;
    protected $email;
    protected $password;

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
    
    public static function addItem()
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
    
    public static function addGroup($connection, $name, $description)
    {
        $sql = "INSERT INTO groups (`groupName`, `groupDescriptiopn`) VALUES ('$name', '$description')";
        $result = $connection->query($sql);

        if (!$result) {
            die ("error" . $connection->connect_error);
        }

        return true;
    }
    
    public static function modifyGroup($connection, $name, $description, $id)
    {
        $sql = "UPDATE groups SET groupName='$name', groupDescriptiopn='$description' WHERE id=$id";
        $result = $connection->query($sql);

        if(!$result) {
            die ("Error");
        }

        header('Location: groupsOfProducts.php');
    }
    
    public static function removeGroup($connection, $id)
    {
        $sql = "DELETE FROM groups WHERE id=$id";

        $result = $connection->query($sql);

        if (!$result) {
            die ("Error");
        }

        header('Location: groupsOfProducts.php');
    }

}