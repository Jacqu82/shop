<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';

session_start();
//sprawdzenie czy admin jest zalogowany
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
    echo "Witaj " . $_SESSION['adminName'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a><hr>";
    echo "<p><a href='adminPanel.php'><--Powrót</a></p>";
    echo "<div class='wrapper'>";
    echo "<p><a href='addNewItem.php'>Dodaj nowy przedmiot</a></p>";
    echo "<p>Pokaż wszystkie przedmioty:</p>";
    //wywołanie metody, która pokazuje wszystkie grupy produktów
    $result = photoGallery::getGallery($connection);

    //Wyświetlenie SELECTa w którym wybieramy interesującą nas grupę przedmiotów
    echo '<form action="#" method="post">';
    echo '<p>Wybierz grupe przedmiotów</p>';
    echo '<select name="selection">';
    echo '<option value="all">Wszystkie</option>';

    foreach ($result as $value) {
        echo '<option value="' . $value['groupName'] . '">' . $value['groupName'] . '</option>';
    }

    echo '</select>
    <input type="submit" value="Pokaż">
</form></div>';

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['selection'])) {
            $selection = $_POST['selection'];

            //jeśli wybralismy wszystko wysyłamy zapytanie wybierające wszystkie rekordy
            if ($selection == 'all') {
                $sql = "SELECT * FROM groups g RIGHT JOIN item i ON i.group_id = g.id";
            } else {
                //w tym przypadku wybieramy rekordy odpowiadajace warunkowi - nazwie grupy
                $sql = "SELECT * from groups g RIGHT JOIN item i ON i.group_id = g.id WHERE groupName='$selection'";
            }

            $result = $connection->query($sql);

            if (!$result) {
                die ("Error");
            }

            //wyświetlamy tablice z wynikami zapytania - tj. wszystkie przedmioty z danej grupy
            echo "<table>";
            echo "<tr>";
            echo "<th>Nazwa</th><th>Grupa</th><th>Opis</th><th>Dostępność</th><th>Cena</th><th>Edytuj</th><th>Usuń</th>";
            echo "</tr>";
            foreach ($result as $value) {
                $id = $value['id'];
                echo "<tr>";
                echo "<td>" . $value['name'] . "</td><td>" . $value['groupName'] . "</td><td>" . $value['description'] . "</td>";
                echo "<td>" . $value['availability'] . "</td><td>" . $value['price'] . "</td>";
                echo "<td><a href='editItem.php?id=$id'>Edytuj</a></td>";
                echo "<td><a href='deleteItem.php?id=$id'>Usuń</a></td></tr>";
            }

            echo "</table>";
        }
    }
    $connection->close();
    ?>

</body>
</html>