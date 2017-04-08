<?php

include_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Item.php';
include_once 'config.php';

// 1. Tak jak wszędzie sprawdzamy czy u żytkownik jest zalogowany, jeśli tak wyświetlamy pasek powitalny

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

// 2. Sprawdzamy czy udało się przesłać getem  informacje, a następnie na podstawie id odszukujemy nazwe przedmiotu i tworzymy obiekt

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM item WHERE id=$id";

        $connection = new mysqli($host, $user, $password, $database);

        $result = $connection->query($sql);

        if (!$result) {
            die("ERROR");
        }

        foreach ($result as $value) {
            $name = $value['name'];
            $description = $value['description'];
        }

        $item = Item::loadItemByName($connection, $name);

        $oldName = $item->getName();

        // 3. Wyświtlamy formularz w którym wstawiamy wykorzystując gettery dane , które można edytować
        
        echo "<form action='editItem.php' method='post'>";
        echo "Edit the name for the <b>" . $item->getName() . " </b>item.<br>";
        echo "<input name='name' type='text'  value= " . $item->getName() . "><br><br>";
        echo "Edit description for the <b>" . $item->getName() . "</b> item<br>";
        echo "<textarea rows='4' cols='50' name='description'>" . $item->getDescription() . "</textarea><br>";
        echo "Edit the price for the <b>" . $item->getName() . " </b>item.<br>";
        echo "<input name='price' type='text'  value= " . $item->getPrice() . "><br><br>";
        echo "Edit the availability for the <b>" . $item->getName() . " </b>item.<br>";
        echo "<input name='availability' type='text'  value= " . $item->getAvailability() . "><br><br>";
        echo "<input type='hidden' name='oldName' value=" . $oldName . ">";
        echo "<input type='submit' value='change'/>";
        echo "</form>";
        echo "<hr>";
        
        //4. Tworze formularz do edycji i dodawania zdjęć do przedmiotu, ale najpierw  odszukuje go poprzed item_id w tabeli photos
        
        echo "<p>Edit Photos</p>";

        $sql = "SELECT * FROM photos WHERE `item_id`=$id";

        $result = $connection->query($sql);

        foreach ($result as $value) {
            $tab[] = array($value);
        }

        $i = 0;
        
        // 5. Pętla przebiega 4 razy, ponieważ tyle można maksymalnie oddać zdjęć.
        
        for ($i = 0; $i < 4; $i++) {

            // 6. Jeśli są juz jakieś zdjęcia dodane do danego przedmiotu uruchomi się ten if
            if (isset($tab[$i][0])) {

                echo "<form action='#' method='post' enctype='multipart/form-data'>";

                $fileNo = ($i + 1);
                $name = 'file' . $i + 1;
                $path = $tab[$i][0]['path'];
                $photoId = $tab[$i][0]['id'];
                $itemId = $tab[$i][0]['item_id'];
                $itemName = $item->getName();

                echo "<br>Zdjęcie nr " . ($i + 1) . "<br>";
                echo "<img src='" . $path . "' height='120' width='120'><br>";
                echo "Change | <a href='deletePhoto.php?photo_id=$photoId&id=$id'>Delete</a><br>";
                echo "<input type='file' name='file'><br>";
                echo "<input type='hidden' name='path' value=$path>";
                echo "<input type='hidden' name='photoId' value=$photoId>";
                echo "<input type='hidden' name='itemId' value=$itemId>";
                echo "<input type='submit' value='Add'/>";
                echo "</form>";
                
                //7. Jesli nie to uruchomi się ten else
            } else {
                echo "<form action='#' method='post' enctype='multipart/form-data'>";
                $fileNo = ($i + 1);
                echo "<br>Zdjęcie nr " . ($i + 1) . "<br>";
                echo "Brak załadowanego zdjęcia.<br>";
                echo "<input type='file' name='file'><br>";
                echo "<input type='hidden' name='number' value=$itemId>";
                echo "<input type='hidden' name='name' value=$itemName>";
                echo "<input type='hidden' name='fileNo' value=$fileNo>";
                echo "<input type='submit' value='Add'/>";
                echo "</form>";
            }
        }
    }
}

// 8. Sprawdzamy czy przesłany został jakiś plik, jeśli tak to uruchamiamy ifa w którym modyfikujemy zdjęcia, jeśli nie to uruchamiamy ifa z edycją danych

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES)) {

        if (isset($_POST['path'])) {
            echo $_POST['path'] . "<br>";
            echo $_FILES['file']['name'];
            $first = substr($_POST['path'], -3, 3);
            $second = substr($_FILES['file']['name'], -3, 3);

            var_dump($first);
            var_dump($second);

            if (substr($_POST['path'], -3, 3) == substr($_FILES['file']['name'], -3, 3)) {
                $path = $_POST['path'];
                $photoId = $_POST['photoId'];
                $itemId = $_POST['itemId'];

                var_dump($path);

                $sql = "DELETE FROM photos WHERE id=$photoId";

                $result = $connection->query($sql);

                if (!$result) {
                    die("Nie udało się usunąć zdjęcia z bazy danych!");
                }

                move_uploaded_file($_FILES['file']['tmp_name'], $path);

                $sql = "INSERT INTO photos (`item_id`, `path`) VALUES('$itemId', '$path')";

                $connection->query($sql);
            } else {
                $path = $_POST['path'];
                $itemId = $_POST['itemId'];
                $photoId = $_POST['photoId'];

                unlink($path);

                echo "rozne koncowki!";
                $path = str_replace($first, $second, $path);
                var_dump($path);

                move_uploaded_file($_FILES['file']['tmp_name'], $path);

                $sql = "DELETE FROM photos WHERE id=$photoId";

                $result = $connection->query($sql);

                if (!$result) {
                    die("Nie udało się usunąć zdjęcia z bazy danych!");
                }

                $sql = "INSERT INTO photos (`item_id`, `path`) VALUES('$itemId', '$path')";

                $connection->query($sql);
            }
        } else {
            var_dump($_FILES);
            $oldName = $_FILES['file']['name'];
            $number = $_POST['number'];
            $itemName = $_POST['name'];
            $fileNo = $_POST['fileNo'];
            $ending = substr($oldName, -3, 3);
            
            echo $number . "<br>";
            echo $itemName . "<br>";
            echo $fileNo . "<br>";
            echo $oldName . "<br>";
            echo $ending . "<br>";

            $path = "files/" . $number . $itemName;

            if (!file_exists($path)) {
                $dirMode = 0777;
                mkdir($path, $dirMode, true);
            }

            var_dump($path);
            
            $path = $path . "/" . $fileNo . "_" . $itemName . "." . $ending;
            
            var_dump($path);
            
            move_uploaded_file($_FILES['file']['tmp_name'], $path);
            
            $sql = "INSERT INTO photos (`item_id`, `path`) VALUES('$number', '$path')";

            $connection->query($sql);
            
        }
    } else {

//    if ((isset($_POST['name']) && isset($_POST['description'])) || isset($_POST['file'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $oldName = $_POST['oldName'];

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
        $result = $connection->query($sql);

        if (!$result) {
            die("Error, błąd odczytu z bazy danych");
        }

        //dla każdegop rekordu zmieniam ścieżkę na aktualną ale wcześniej kasuje już nieaktualne ścieżki dostepu do zdjęć

        $sql = "DELETE FROM photos WHERE item_id=$id";
        $result2 = $connection->query($sql);

        if (!$result2) {
            die("Error - couldn't change path of photos unfortunatelly");
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
                die("Error - couldn't change path of photos");
            }
        }

        $item->save($connection);
        header('Location: itemPanel.php');
    }
}


