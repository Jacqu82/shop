<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

//sprawdzenie czy użytkownik jest zalogowany
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
echo "<p><a href='adminPanel.php'><--Powrót</a></p>";
echo "<p><a href='addGroupOfProducts.php'>Dodaj nową grupę produktów</a></p>";

// wykorzystanie metody która wybiera wszystkie grupy produktów z bazy danych
$result = SqlQueries::getGallery($connection);

//wyświetlenie tabeli ze wszystkimi grupami produktów
echo "<div class='tableShow'>";
echo "<table>";
echo "<tr>";
echo "<th>id</th><th>Nazwa</th><th>Opis</th><th>Edytuj</th><th>Usuń</th>";
echo "</tr>";
foreach ($result as $value) {
    $id = $value['id'];
    echo "<tr>";
    echo "<td>" . $value['id'] . "</td><td>" . $value['groupName'] . "</td><td>" . $value['groupDescriptiopn'] . "</td>";
    echo "<td><a href='editGroupOfProducts.php?id=$id'>Edytuj</a></td>";
    echo "<td><a href='deleteGroupOfProducts.php?id=$id'>Usuń</a></td></tr>";
}

echo "</table></div></body></html>";

$connection->close();
