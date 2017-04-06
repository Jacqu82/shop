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
        echo "<hr>";
        
        echo "<p>Edit Photos</p>";
        
        $sql = "SELECT * FROM photos WHERE `item_id`=$id";
        
        $result = $connection->query($sql);
        
        foreach ($result as $value) {
            $tab[] = array($value);
        }
        
        var_dump($tab);
        $i = 0;
        
        echo "<form action='#' method='POST'enctype='multipart/form-data'>";
        
        for ($i = 0; $i < 4; $i++) {
            if (isset($tab[$i][0])) {
                
                $path = $tab[$i][0]['path'];
                echo "<br>Zdjęcie nr " . ($i+1). "<br>";
                echo "<img src='" . $path . "' height='120' width='120'><br>";           
                echo "Change | <a href='#'>Delete</a><br>";
                echo "<input type='file' name='file'><br>";
            } else {
                echo "<br>Zdjęcie nr " . $i . "<br>";
                echo "Brak załadowanego zdjęcia.<br>";
                echo "<input type='file' name='file'><br>";
            }
        }
        echo "<input type='submit' value='Add'/>";
        echo "</form>";
       
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    if ((isset($_POST['name']) && isset($_POST['description'])) || isset($_POST['file'])) {
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
        
        $id = $item->getId();
        
        $path = "files/" . $id . $name;
        
        if (!file_exists($path)) {
            $dirMode = 0777;
            mkdir($path, $dirMode, true);
        }
        
        //po zmianie nazwy produktu, musimy również odpowiednio zmienić nazwę folderu, w którym przechowywane są zdjęcia
        //odszukuję rekordy zgodne z item_id
        
        $sql = "SELECT * FROM photos WHERE item_id=$id";
        $result=$connection->query($sql);
        
        if (!$result) {
            die ("Error, błąd odczytu z bazy danych");
        }
        
        //dla każdegop rekordu zmieniam ścieżkę na aktualną ale wcześniej kasuje już nieaktualne ścieżki dostepu do zdjęć
        
        $sql = "DELETE FROM photos WHERE item_id=$id";
        $result2 = $connection->query($sql);
            
            if (!$result2) {
                die ("Error - couldn't change path of photos unfortunatelly");
            }
        
        foreach ($result as $value) {
            $path = "files/" . $id . $name;
            preg_match('~[\/][^+]+[\/]([^+]+)~', $value['path'], $matches);
            $path = $path . "/" . $matches[1];
            rename($value['path'], $path);      
            
            //zapisuje aktualną ścieżke kolejno dla każdego zdjęcia
            
            $sql = "INSERT INTO photos (`item_id`, `path`) VALUES ('$id', '$path')";
            $result = $connection->query($sql);
            
            if (!$result) {
                die ("Error - couldn't change path of photos");
            }
        }

        $item->save($connection);
        header('Location: itemPanel.php');
//    }
}
