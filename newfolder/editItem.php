<?php

include_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Item.php';
require_once 'src/showProduct.php';
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

        $result = showProduct::getItem($host, $user, $password, $database, $id);

        foreach ($result as $value) {
            $name = $value['name'];
        }

        $item = Item::loadItemByName($connection, $name);

        $oldName = $item->getName();
        $id = $item->getId();
        $description = $item->getDescription();
        $price = $item->getPrice();
        $availability = $item->getAvailability();

        $_SESSION['itemId'] = $id;
        $_SESSION['oldName'] = $oldName;

        // 3. Wyświtlamy formularz w którym wstawiamy wykorzystując gettery dane , które można edytować

        newItemCreation::showEditItem($name, $description, $price, $availability);
        
        //4. Tworze formularz do edycji i dodawania zdjęć do przedmiotu, ale najpierw  odszukuje go poprzed item_id w tabeli photos
        
        echo "<p>Edit Photos</p>";

        $result = showProduct::getPhotoPath($host, $user, $password, $database, $id);

        foreach ($result as $value) {
            $tab[] = array($value);
        }

        newItemCreation::editPhoto($tab, $item);
    }
}

// 8. Sprawdzamy czy przesłany został jakiś plik, jeśli tak to uruchamiamy ifa w którym modyfikujemy zdjęcia, jeśli nie to uruchamiamy ifa z edycją danych

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        if (isset($_POST['path'])) {
            echo $_POST['path'] . "<br>";
            echo $_FILES['file']['name'];
            $first = substr($_POST['path'], -3, 3);
            $second = substr($_FILES['file']['name'], -3, 3);

            if (substr($_POST['path'], -3, 3) == substr($_FILES['file']['name'], -3, 3)) {
                $path = $_POST['path'];
                $photoId = $_POST['photoId'];
                $itemId = $_POST['itemId'];

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

            $path = $path . "/" . $fileNo . "_" . $itemName . "." . $ending;

            move_uploaded_file($_FILES['file']['tmp_name'], $path);
            
            $sql = "INSERT INTO photos (`item_id`, `path`) VALUES('$number', '$path')";

            $connection->query($sql);
            
        }
    } else {
        setcookie("idCookie", $itemId, time()+2);
//    if ((isset($_POST['name']) && isset($_POST['description'])) || isset($_POST['file'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $oldName = $_SESSION['oldName'];


        var_dump($oldName);

        $item = Item::loadItemByName($connection, $oldName);

        var_dump($item);

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

