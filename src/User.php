<?php

class User
{
    protected $id;
    protected $name;
    protected $surname;
    protected $email;
    protected $password;
    protected $address;
    protected $history;
    
    public function __construct()
    {
        $this->id = -1;
        $this->name = "";
        $this->surname = "";
        $this->email = "";
        $this->password = "";
        $this->address = "";
        $this->history = [];
    }

    public function getId()
    {
        return $this->id;
    }

    function getAddress()
    {
        return $this->address;
    }

    function setAddress($address)
    {
        $this->address = $address;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    static public function loadUserByName(mysqli $connection, $name)
    {
        $name = $connection->real_escape_string($name);
        $sql = "SELECT * FROM `users` WHERE `name` = '$name'";
        $result = $connection->query($sql);
        if (!$result) {
            die("Error kurwa mać" . $connection->connect_error);
        }
        if ($result->num_rows == 1) {
            $userArray = $result->fetch_assoc();
            $user = new User();
            $user->setName($userArray['name']);
            $user->setSurname($userArray['surname']);
            $user->setEmail($userArray['email']);
            $user->setAddress($userArray['address']);
            $user->setPassword($userArray['password']);
            return $user;
        } else {
            return false;
        }
    }
}