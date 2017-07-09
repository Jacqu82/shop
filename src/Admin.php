<?php

include_once 'Item.php';
include_once 'AdminRepository.php';

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

    public static function loadAdminByName(mysqli $connection, $name)
    {
        $name = $connection->real_escape_string($name);
        $result = AdminRepository::getAdminByName($connection, $name);

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

    public static function loadAdminById(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $result = AdminRepository::getAdminById($connection, $id);

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

    public static function addItem()
    {
        $item = new Item();
        $item->setName($item);
    }

    public static function addGroup(mysqli $connection, $name, $description)
    {
        $name = $connection->real_escape_string($name);
        $description = $connection->real_escape_string($description);
        AdminRepository::insertGroup($connection, $name, $description);
        return true;
    }

    public static function modifyGroup(mysqli $connection, $name, $description, $id)
    {
        $name = $connection->real_escape_string($name);
        $description = $connection->real_escape_string($description);
        $id = $connection->real_escape_string($id);
        AdminRepository::mofifyGroup($connection, $name, $description, $id);
        return true;
    }

    public static function removeGroup(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        AdminRepository::deleteGroup($connection, $id);
        return true;
    }
}
