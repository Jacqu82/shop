<?php

include_once 'Item.php';

class Admin
{
    protected $name;
    protected $email;
    protected $password;
    protected $id;

    public function __construct()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    private function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

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
            $admin->setId($adminArray['id']);

            return $admin;
        } else {
            return false;
        }
    }

    static public function loadAdminById(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $sql = "SELECT * FROM `admins` WHERE `id` = $id";
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
            $admin->setId($id);

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

    //trzy metody do obsługi grup przedmiotów

    public static function addGroup(mysqli $connection, $name, $description)
    {
        $name = $connection->real_escape_string($name);
        $description = $connection->real_escape_string($description);

        $sql = "INSERT INTO groups (`groupName`, `groupDescriptiopn`) VALUES ('$name', '$description')";
        $result = $connection->query($sql);

        if (!$result) {
            die ("error" . $connection->connect_error);
        }
        return true;
    }

    public static function modifyGroup(mysqli $connection, $name, $description, $id)
    {
        $name = $connection->real_escape_string($name);
        $description = $connection->real_escape_string($description);
        $id = $connection->real_escape_string($id);

        $sql = "UPDATE groups SET groupName='$name', groupDescriptiopn='$description' WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Error");
        }
        header('Location: groupsOfProducts.php');
    }

    public static function removeGroup(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $sql = "DELETE FROM groups WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Error");
        }
        header('Location: groupsOfProducts.php');
    }
}
