<?php

class User
{
    protected $id;
    protected $name;
    protected $surname;
    protected $email;
    protected $password;
    protected $address;

    public function __construct()

    {
        $this->id = -1;
        $this->name = "";
        $this->surname = "";
        $this->email = "";
        $this->password = "";
        $this->address = "";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
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

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function saveToDB(mysqli $connection)
    {
        if ($this->id == -1) {
            $sql = /** @lang text */
                "INSERT INTO users(name, surname, email, password, address) VALUES ('$this->name', '$this->surname', '$this->email', '$this->password', '$this->address')";
            $result = $connection->query($sql);
            if ($result) {
                $this->id = $connection->insert_id;
                echo "<h3>Cieszymy się że tu jesteś,  " . $this->name . "</h3>";
                echo "  <h3><a href='../web/loginForm.html' class='btn btn - primary btn - block'>Zaloguj się na swoje konto</a></h3>";
            } else {
                echo "Wystąpił błąd podczas rejestracji, spróbuj jeszcze raz!<br/>";
                die("Connection Error! " . $connection->connect_error);
            }
        } else {
            $sql = /** @lang text */
                "UPDATE users SET email = '$this->email',
                                    name = '$this->name',
                                    surname = '$this->surname',
                                    password = '$this->password'
                                    address = '$this->address'
                                    WHERE id = $this->id";
            $result = $connection->query($sql);
            if ($result) {
                return true;
            }
        }
        return false;
    }
}
