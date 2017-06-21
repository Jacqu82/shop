<?php

include_once 'connection.php';
require_once 'autoload.php';
include_once 'config.php';
require_once 'layout/Layout.php';

// 1. Tak jak wszędzie sprawdzamy czy użytkownik jest zalogowany, jeśli tak wyświetlamy pasek powitalny

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}
?>

    <html>
    <head>
        <title>Shop</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css?h=1" rel="stylesheet">
    </head>

    <body>
    <div class="container">

<?php
Layout::AdminTopBar();
echo "<p><a href='itemPanel.php'><--Powrót</a></p>";

// 2. Sprawdzamy czy udało się przesłać getem  informacje, a następnie na podstawie id odszukujemy nazwe przedmiotu i tworzymy obiekt

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        //wykorzystujemy metodę, która wyciąga dane o przedmiocie o podanym id
        $result = showProduct::getItem($connection, $id);

        foreach ($result as $value) {
            $name = $value['name'];
        }

        //tworzymy obiekt na podstawie uzyskanej nazwy oraz przypisujemy zmiennym wartości
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

        $result = showProduct::getPhotoPath($connection, $id);

        foreach ($result as $value) {
            $tab[] = array($value);
        }

        newItemCreation::editPhoto($tab, $item);
    }
}

// 8. Sprawdzamy czy przesłany został jakiś plik, jeśli tak to uruchamiamy ifa w którym modyfikujemy zdjęcia, jeśli nie to uruchamiamy ifa z edycją danych

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        //gdy zdjęcia były już wcześniej dodane do przedmiotu
        if (isset($_POST['path'])) {
            $first = substr($_SESSION['path'], -3, 3);
            $second = substr($_FILES['file']['name'], -3, 3);

            $itemId = $_POST['itemId'];
            $photoId = $_POST['photoId'];
            $path = $_SESSION['path'];
            unlink($path);

            $path = str_replace($first, $second, $path);

            move_uploaded_file($_FILES['file']['tmp_name'], $path);

            dbEdit::delete($connection, $photoId);
            dbEdit::insert($connection, $itemId, $path);


            //gdy nie było wcześniej dodanych  żadnych zdjęć do przedmiotu
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
        $description = mysqli_real_escape_string($connection, $_POST['description']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);
        $availability = mysqli_real_escape_string($connection, $_POST['availability']);
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
echo $connection->close();
echo "</body></html>";

