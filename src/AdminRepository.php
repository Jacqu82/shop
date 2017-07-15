<?php

class AdminRepository extends Admin
{
    public static function loadAdminByName(mysqli $connection, $name)
    {
        $name = $connection->real_escape_string($name);
        //$result = AdminRepository::getAdminByName($connection, $name);
        $sql = "SELECT * FROM `admins` WHERE `adminName` = '$name'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączeni z bazą danych " . $connection->connect_error);
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

    public static function loadAdminById(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        //$result = AdminRepository::getAdminById($connection, $id);
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
            die ("Błąd zapisu do bazy danych" . $connection->error);
        }
        header('Location: groupsOfProducts.php');
    }

    public static function removeGroup(mysqli $connection, $id)
    {
        $id = $connection->real_escape_string($id);
        $sql = "DELETE FROM groups WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->error);
        }
        header('Location: groupsOfProducts.php');
    }
}
