<?php

include_once 'connection.php';
require_once 'autoload.php';
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

            newItemCreation::newFolder($path);

            $path = $path . "/" . $fileNo . "_" . $itemName . "." . $ending;

            move_uploaded_file($_FILES['file']['tmp_name'], $path);

            dbEdit::insert($connection, $number, $path);

        }
    } else {
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $oldName = $_SESSION['oldName'];

        $item = Item::loadItemByName($connection, $oldName);

        $item->setName($oldName);
        $item->setDescription($description);
        $item->setPrice($price);
        $item->setAvailability($availability);

        $item->save($connection);
        header('Location: itemPanel.php');
    }
}

