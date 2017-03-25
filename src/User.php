<?php


class User
{
    protected $name;
    protected $surname;
    protected $email;
    protected $password;
    protected $address;

    /**
     * User constructor.
     * @param $name
     * @param $surname
     * @param $email
     * @param $password
     */
    public function __construct()
    {
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->password = '';
        $this->address = '';
    }
    function getAddress()
    {
        return $this->address;
    }

    function setAddress($address)
    {
        $this->address = $address;
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
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
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
    function setPassword($password)
    {
        $this->password = $password;
    }

        /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
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