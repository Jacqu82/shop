<?php

include_once '../../connection.php';
include_once '../../config.php';
require_once '../../autoload.php';
require_once '../../layout/Layout.php';
require_once '../SqlQueries.php';

session_start();

//sprawdzenie czy użytkownik jest zalogowany
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
    <p><a href='adminPanel.php'><--Powrót</a></p>
    <p><a href='addGroupOfProducts.php'>Dodaj nową grupę produktów</a></p>

    <!--    wykorzystanie metody która wybiera wszystkie grupy produktów z bazy danych-->
    <?php
    $result = SqlQueries::getGallery($connection);
    ?>

    <!--    wyświetlenie tabeli ze wszystkimi grupami produktów-->
    <div class='tableShow'>
        <table>
            <tr>
                <th>id</th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Edytuj</th>
                <th>Usuń</th>
            </tr>
            <?php
            foreach ($result as $value) {
                $id = $value['id'];
                echo "<tr>";
                echo "<td>" . $value['id'] . "</td><td>" . $value['groupName'] . "</td><td>" . $value['groupDescriptiopn'] . "</td>";
                echo "<td><a href='editGroupOfProducts.php?id=$id'>Edytuj</a></td>";
                echo "<td><a href='deleteGroupOfProducts.php?id=$id'>Usuń</a></td></tr>";
            }
            ?>
        </table>
        <?php $connection->close(); ?>
    </div>
</body>
</html>