<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');      
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        
        $id = $_GET['id'];
        $sql = "SELECT * FROM groups WHERE id=$id";
        $connection = new mysqli($host, $user, $password, $database);
        $result = $connection->query($sql);

        if (!$result) {
            die ("error" . $connection->connect_error);
        }
        
        foreach ($result as $value) {
            $name = $value['groupName'];
            $description = $value['groupDescriptiopn'];
        }

        echo "<form action='editGroupOfProducts.php' method='post'>";
        echo "Edit the name for the <b>" . $name . " </b>group.<br>";
        echo "<textarea name='name' rows='1' col='50'>" . $name . "</textarea><br><br>";
        echo "Edit description for the <b>" . $name . "</b> group<br>";
        echo "<textarea rows='4' cols='50' name='description'>" . $description . "</textarea><br>";
        echo "<input type='hidden' name='id' value=$id>";
        echo "<input type='submit' value='change'/>";
        echo "</form>";  
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['description'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $id= $_POST['id'];
        
        Admin::modifyGroup($connection, $name, $description, $id);
    }
}

?>
