<?php

class AdminRepository
{
    public static function getAdminByName(mysqli $connection, $name)
    {
        $sql = "SELECT * FROM `admins` WHERE `adminName` = '$name'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączeni z bazą danych " . $connection->connect_error);
        }

        return $result;
    }

    public static function getAdminById(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM `admins` WHERE `id` = $id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Error " . $connection->connect_error);
        }

        return $result;
    }

    public static function insertGroup(mysqli $connection, $name, $description)
    {
        $sql = "INSERT INTO groups (`groupName`, `groupDescriptiopn`) VALUES ('$name', '$description')";
        $result = $connection->query($sql);

        if (!$result) {
            die ("error" . $connection->connect_error);
        }

        return true;
    }

    public static function mofifyGroup(mysqli $connection, $name, $description, $id)
    {
        $sql = "UPDATE groups SET groupName='$name', groupDescriptiopn='$description' WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd zapisu do bazy danych" . $connection->error);
        }
        header('Location: groupsOfProducts.php');
    }

    public static function deleteGroup(mysqli $connection, $id)
    {
        $sql = "DELETE FROM groups WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->error);
        }
        header('Location: groupsOfProducts.php');
    }

}