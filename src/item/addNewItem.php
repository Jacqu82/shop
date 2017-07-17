<?php

require_once '../../connection.php';
require_once '../../config.php';
require_once '../../layout/Layout.php';
require_once 'autoload.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}
?>
    <html>
    <?php Layout::showHeadInUser() ?>
    <body>
    <div class="container">
        <?php
        Layout::adminTopBar();
        echo "<p><a href='itemPanel.php'><--Powrót</a></p>";
        ?>
        <div class="itemShow">
            <form action="#" method="post" enctype="multipart/form-data">
                Podaj nazwę:<br>
                <input type="text" name="name"/><br>
                Wybierz grupę lub stwórz <a href="../admin/addGroupOfProducts.php"><b>nową grupę:</b></a><br>
                <?php
                //wybieramy z listy rozwijalnej grupę produktów do której dodamy przedmiot
                $result = SqlQueries::getGallery($connection);
                ?>
                <select name="selection">
                    <?php
                    foreach ($result as $value) {
                        echo '<option value="' . $value['id'] . '">' . $value['groupName'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                Opis:<br>
                <textarea rows='4' cols='50' name='description'></textarea><br>
                Cena:<br>
                <input type="text" name="price"/><br>
                Dostępność:<br>
                <input type="text" name="availability"/><br>
                Dodaj zdjęcie:<br>
                <input type="file" name="file1"/><br>
                Dodaj zdjęcie:<br>
                <input type="file" name="file2"/><br>
                Dodaj zdjęcie:<br>
                <input type="file" name="file3"/><br>
                Dodaj zdjęcie:<br>
                <input type="file" name="file4"/><br>
                <input type="submit" value="Dodaj"/>
            </form>
        </div>
    </div>
    </body>
    </html>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['selection']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['availability'])) {

        //przypisujemy wszystkie dane z formularza do zmiennych

        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $selection = mysqli_real_escape_string($connection, $_POST['selection']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);
        $availability = mysqli_real_escape_string($connection, $_POST['availability']);

        //tworzymy obiekt typu Item i ustawiamy setery zmiennymi otrzymanymiz formularza

        $item = new Item();
        $item->setName($name);
        $item->setAvailability($availability);
        $item->setDescription($description);
        $item->setGroup($selection);
        $item->setPrice($price);
        $itemRepository = new ItemRepository();
        $itemRepository->saveToDb($connection, $item);
        $id = $item->getId();

        //tworze folder z id pliku a nastepnie z jego nazwą

        $path = "../../files/" . $id;
        newItemCreation::newFolder($path);

        if ($_FILES['file1']['size'] == 0) {
            for ($i = 0; $i != 4; $i++) {
                $path = '';
                $path = '../../files/' . $id . '/' . ($i + 1) . '_' . $id . '.jpg';
                $pathtoDB = 'files/' . $id . '/' . ($i + 1) . '_' . $id . '.jpg';
                copy('../../files/question.jpg', $path);
                SqlQueries::insert($connection, $id, $pathtoDB);
                var_dump($path);
            }
            header('Location: itemPanel.php');
        } else {
            //sposób okreslam ile zdjęć zostało załadowanych - wartość tą wykorzystam w pętli

            if ($_FILES['file2']['size'] == 0) {
                $flag = 1;
            } else if ($_FILES['file3']['size'] == 0) {
                $flag = 2;
            } else if ($_FILES['file4']['size'] == 0) {
                $flag = 3;
            } else {
                $flag = 4;
            }

            for ($i = 0; $i < $flag; $i++) {
                // sprawdzam z którym plikiem pracuję a następnie wyszukuje końcówki pliku
                if ($i == 0) {
                    $fileNo = 'file1';
                    $fileName = $_FILES['file1']['name'];
                    preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                    $ending = $matches[0];
                } else if ($i == 1) {
                    $fileNo = 'file2';
                    $fileName = $_FILES['file2']['name'];
                    preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                    $ending = $matches[0];
                } else if ($i == 2) {
                    $fileNo = 'file3';
                    $fileName = $_FILES['file3']['name'];
                    preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                    $ending = $matches[0];
                } else {
                    $fileNo = 'file4';
                    $fileName = $_FILES['file4']['name'];
                    preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                    $ending = $matches[0];
                }
                //przy każdej iteracji resetuje zmiane scieżki dostepu do ustawien poczatkowych
                $pathtoDB = "files/" . $id;
                $path = "../../files/" . $id;
                //nastepnie zmieniam nazwe elementu na liczbe porzadkowa + nazwe przedmiotu + koncowka odpowiednia

                $_FILES[$i]['name'] = $i + 1 . "_" . $id . $ending;
                $path = $path . "/" . $_FILES[$i]['name'];
                $pathtoDB = $pathtoDB . "/" . $_FILES[$i]['name'];
                SqlQueries::insert($connection, $id, $pathtoDB);
                move_uploaded_file($_FILES[$fileNo]['tmp_name'], $path);

                if ($flag == 1) {
                    for ($j = 1; $j != 4; $j++) {
                        $path = '';
                        $path = '../../files/' . $id . '/' . ($j + 1) . '_' . $id . '.jpg';
                        $pathtoDB = 'files/' . $id . '/' . ($j + 1) . '_' . $id . '.jpg';
                        copy('../../files/question.jpg', $path);
                        SqlQueries::insert($connection, $id, $pathtoDB);
                    }
                } else if ($flag == 2 && $i == 1) {
                    for ($j = 2; $j != 4; $j++) {
                        $path = '';
                        $path = '../../files/' . $id . '/' . ($j + 1) . '_' . $id . '.jpg';
                        $pathtoDB = 'files/' . $id . '/' . ($j + 1) . '_' . $id . '.jpg';
                        copy('../../files/question.jpg', $path);
                        SqlQueries::insert($connection, $id, $pathtoDB);
                    }
                } else if ($flag == 3 && $i ==2) {
                    for ($j = 3; $j != 4; $j++) {
                        $path = '';
                        $path = '../../files/' . $id . '/' . ($j + 1) . '_' . $id . '.jpg';
                        $pathtoDB = 'files/' . $id . '/' . ($j + 1) . '_' . $id . '.jpg';
                        copy('../../files/question.jpg', $path);
                        SqlQueries::insert($connection, $id, $pathtoDB);
                    }
                }
            }
            header('Location: itemPanel.php');
        }
    }
}
$connection->close();
