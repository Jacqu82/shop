<?php

include_once '../../connection.php';
include_once '../../config.php';
require_once '../../autoload.php';
require_once '../../layout/Layout.php';
require_once '../SqlQueries.php';

session_start();
//sprawdzenie czy admin jest zalogowany
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}
?>
<html>
<?php Layout::showHeadInUser(); ?>
<body>
<div class="container">
    <?php
    Layout::adminTopBar();
    ?>
    <p><a href='../admin/adminPanel.php'><--Powrót</a></p>
    <div class='wrapper'>
        <p><a href='addNewItem.php'>Dodaj nowy przedmiot</a></p>
        <p>Pokaż wszystkie przedmioty:</p>
        <?php

        //wywołanie metody, która pokazuje wszystkie grupy produktów
        $result = SqlQueries::getGallery($connection);

        //Wyświetlenie SELECTa w którym wybieramy interesującą nas grupę przedmiotów
        ?>
        <form action="#" method="post">
            <p>Wybierz grupe przedmiotów</p>
            <select name="selection">
                <option value="all">Wszystkie</option>
                <?php
                foreach ($result as $value) {
                    echo '<option value="' . $value['groupName'] . '">' . $value['groupName'] . '</option>';
                }
                ?>
            </select>
            <input type="submit" value="Pokaż">
        </form>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['selection'])) {
            $selection = mysqli_real_escape_string($connection, $_POST['selection']);

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
            ?>
            <table>
                <tr>
                    <th>Nazwa</th>
                    <th>Grupa</th>
                    <th>Opis</th>
                    <th>Dostępność</th>
                    <th>Cena</th>
                    <th>Edytuj</th>
                    <th>Usuń</th>
                </tr>
                <?php
                foreach ($result as $value) {
                    $id = $value['id'];
                    $name = $value['name'];
                    echo "<tr>";
                    echo "<td>" . $value['name'] . "</td><td>" . $value['groupName'] . "</td><td>" . $value['description'] . "</td>";
                    echo "<td>" . $value['availability'] . "</td><td>" . $value['price'] . "</td>";
                    echo "<td><a href='editItem.php?id=$id'>Edytuj</a></td>";
                    echo "<td><a href='deleteItem.php?name=$name'>Usuń</a></td></tr>";
                } ?>
            </table>
            <?php
        }
    }
    $connection->close();
    ?>
</div>
</body>
</html>