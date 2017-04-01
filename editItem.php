<?php

include_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Item.php';
include_once 'config.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');      
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM item WHERE id=$id";
        
        $connection = new mysqli($host, $user, $password, $database);
        
        $result = $connection->query($sql);
        
        if (!$result) {
            die ("ERROR");
        }
        
        foreach ($result as $value) {
            $name = $value['name'];
            $description = $value['description'];
        }
        
        $item = Item::loadItemByName($connection, $name);
               
        echo $item-> getName();
        echo $item-> getDescription();
        echo $item-> getPrice();
        echo $item-> getAvailability();
        echo $item->getId();
        
        $oldName = $item->getName();
          
        echo "<form action='editItem.php' method='post'>";
        echo "Edit the name for the <b>" . $item->getName() . " </b>item.<br>";
        echo "<input name='name' type='text'  value= " .  $item->getName() . "><br><br>";
        echo "Edit description for the <b>" . $item->getName() . "</b> item<br>";
        echo "<textarea rows='4' cols='50' name='description'>" . $item-> getDescription() . "</textarea><br>";
        echo "Edit the price for the <b>" . $item->getName() . " </b>item.<br>";
        echo "<input name='price' type='text'  value= " .  $item->getPrice() . "><br><br>";
        echo "Edit the availability for the <b>" . $item->getName() . " </b>item.<br>";
        echo "<input name='availability' type='text'  value= " .  $item->getAvailability() . "><br><br>";
        echo "<input type='hidden' name='oldName' value=" . $oldName . ">";
        echo "<input type='submit' value='change'/>";
        echo "</form>";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['description'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price=$_POST['price'];
        $availability=$_POST['availability'];
        $oldName=$_POST['oldName'];
        
        $item = Item::loadItemByName($connection, $oldName);
        
        $item->setName($name);
        $item->setDescription($description);
        $item->setPrice($price);
        $item->setAvailability($availability);
        
        $item->save($connection);
        header('Location: itemPanel.php');
    }
}
