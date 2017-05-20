<?php

include_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Item.php';
require_once 'src/showProduct.php';
require_once 'src/dbEdit.php';
include_once 'config.php';

// 1. Tak jak wszędzie sprawdzamy czy użytkownik jest zalogowany, jeśli tak wyświetlamy pasek powitalny

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

        //zapisuje te dane w sesji, ponieważ przy wysyłaniu postem ucina wszystko od spacji - wyskakują blędy przy nazwach rozdzielonych spacją
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
            $first = substr($_SESSION['path'], -3, 3);
            $second = substr($_FILES['file']['name'], -3, 3);

            if (substr($_SESSION['path'], -3, 3) == substr($_FILES['file']['name'], -3, 3)) {
                $path = $_SESSION['path'];
                $photoId = $_POST['photoId'];
                $itemId = $_POST['itemId'];

                dbEdit::delete($connection, $photoId);

                move_uploaded_file($_FILES['file']['tmp_name'], $path);

                dbEdit::insert($connection, $itemId, $path);

            } else {
                $path = $_POST['path'];
                $itemId = $_POST['itemId'];
                $photoId = $_POST['photoId'];
                $path = $_SESSION['path'];
                unlink($path);

                echo "rozne koncowki!";
                $path = str_replace($first, $second, $path);

                move_uploaded_file($_FILES['file']['tmp_name'], $path);

                dbEdit::delete($connection, $photoId);
                dbEdit::insert($connection, $itemId, $path);

            }
        } else {
            $oldName = $_FILES['file']['name'];
            $number = $_POST['number'];
            $itemName = $_SESSION['name'];
            $fileNo = $_POST['fileNo'];
            $ending = substr($oldName, -3, 3);

            $path = "files/" . $number . $itemName;

            if (!file_exists($path)) {
                $dirMode = 0777;
                mkdir($path, $dirMode, true);
            }

            $path = $path . "/" . $fileNo . "_" . $itemName . "." . $ending;

            move_uploaded_file($_FILES['file']['tmp_name'], $path);

            dbEdit::insert($connection, $number, $path);
            
        }
    } else {
        $name = $_SESSION['itemName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $oldName = $_SESSION['oldName'];

        $item = Item::loadItemByName($connection, $oldName);

        $item->setName($oldName);
        $item->setDescription($description);
        $item->setPrice($price);
        $item->setAvailability($availability);

        $id = $item->getId();

//        $path = "files/" . $id . $name;
//
//        if (!file_exists($path)) {
//            $dirMode = 0777;
//            mkdir($path, $dirMode, true);
//        }

        //po zmianie nazwy produktu, musimy również odpowiednio zmienić nazwę folderu, w którym przechowywane są zdjęcia
        //odszukuję rekordy zgodne z item_id

//        $result = showProduct::getPhotoPath($host, $user, $password, $database, $id);

        //dla każdegop rekordu zmieniam ścieżkę na aktualną ale wcześniej kasuje już nieaktualne ścieżki dostepu do zdjęć

//        dbEdit::delete($connection, $id);

//        foreach ($result as $value) {
//            $path = "files/" . $id . $name;
//            preg_match('~[\/][^+]+[\/]([^+]+)~', $value['path'], $matches);
//            $path = $path . "/" . $matches[1];
//            rename($value['path'], $path);
//
//            //zapisuje aktualną ścieżke kolejno dla każdego zdjęcia
//
//            dbEdit::insert($connection, $id, $path);
//        }

        $item->save($connection);
        header('Location: itemPanel.php');
    }
}

