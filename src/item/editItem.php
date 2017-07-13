<?php

include_once '../../connection.php';
include_once '../../config.php';
require_once '../../autoload.php';
require_once '../../layout/Layout.php';
require_once '../SqlQueries.php';
require_once '../Item.php';
require_once '../ItemRepository.php';
require_once '../ItemRepository.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
}
?>
<html>
<?php Layout::showHeadInUser(); ?>
<body>
<div class="container">
    <?php
    Layout::adminTopBar();
    ?>
    <p><a href='itemPanel.php'><--Powrót</a></p>
    <?php
    // 2. Sprawdzamy czy udało się przesłać getem  informacje, a następnie na podstawie id odszukujemy nazwe przedmiotu i tworzymy obiekt
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id = intval($id);
            //wykorzystujemy metodę, która wyciąga dane o przedmiocie o podanym id
            $result = SqlQueries::getItem($connection, $id);

            foreach ($result as $value) {
                $name = $value['name'];
            }

            //tworzymy obiekt na podstawie uzyskanej nazwy oraz przypisujemy zmiennym wartości
            $item = Item::loadItemByName($connection, $name);

            $oldName = $item->getName();  //1. nie ma takiej potrzeby juz - nazwa to id!!!
            $id = $item->getId();
            $description = $item->getDescription();
            $price = $item->getPrice();
            $availability = $item->getAvailability();

            //zapisuje te dane w sesji, ponieważ przy wysyłaniu postem ucina wszystko od spacji - wyskakują blędy przy nazwach rozdzielonych spacją
            $_SESSION['itemId'] = $id;

            // 3. Wyświtlamy formularz w którym wstawiamy wykorzystując gettery dane , które można edytować

            newItemCreation::showEditItem($name, $description, $price, $availability);

            //4. Tworze formularz do edycji i dodawania zdjęć do przedmiotu, ale najpierw  odszukuje go poprzed item_id w tabeli photos

            echo "<p>Edytuj zdjęcia</p>";

            $result = SqlQueries::getPhotoPath($connection, $id);
            $tab = [];

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

                $itemId = mysqli_real_escape_string($connection, $_POST['itemId']);
                $photoId = mysqli_real_escape_string($connection, $_POST['photoId']);
                $path = $_SESSION['path'];
                $path = str_replace($first, $second, $path);
                $pathDB = substr($path, 6);
                move_uploaded_file($_FILES['file']['tmp_name'], $path);
                SqlQueries::delete($connection, $photoId);
                SqlQueries::insert($connection, $itemId, $pathDB);
                header('Location: itemPanel.php');

                //gdy nie było wcześniej dodanych  żadnych zdjęć do przedmiotu
            } else {
                $oldName = $_FILES['file']['name'];
                $itemId = mysqli_real_escape_string($connection, $_POST['number']);
                $fileNo = $_POST['fileNo'];
                $ending = substr($oldName, -3, 3);
                $path = "files/"  . $itemId;
                var_dump($path);
                $path = "../../" . $path . "/" . $fileNo . "_" . $itemId . "." . $ending;
                newItemCreation::newFolder($path);
                $pathDB = substr($path, 6);
                var_dump($path);
                var_dump($pathDB);
                move_uploaded_file($_FILES['file']['tmp_name'], $path);
                SqlQueries::insert($connection, $itemId, $pathDB);
                //header('Location: itemPanel.php');
            }
        } else {
            $description = mysqli_real_escape_string($connection, $_POST['description']);
            $price = mysqli_real_escape_string($connection, $_POST['price']);
            $availability = mysqli_real_escape_string($connection, $_POST['availability']);
            $oldName = $_SESSION['oldName'];
            $name = mysqli_real_escape_string($connection, $_POST['name']);

            $item = Item::loadItemByName($connection, $oldName);
            $item->setName($name);
            $item->setDescription($description);
            $item->setPrice($price);
            $item->setAvailability($availability);
            $item->save($connection);
            header('Location: itemPanel.php');
        }
    }
    $connection->close();
    ?>
</body>
</html>