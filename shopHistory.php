<?php

require_once 'connection.php';
require_once 'autoload.php';

session_start();
//
////jeżeli ktoś wpisze z palca w przeglądarce userPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę głóœną.
//
if (!isset($_SESSION['user'])) {
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
echo "Witaj " . $_SESSION['user'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a>";
?>
    <hr>
    <p><a href='userPanel.php'><--Powrót</a></p>
<?php

$userId = $_SESSION['id'];

$sql = "SELECT * FROM orders WHERE user_id=$userId";

$result = $connection->query($sql);

if (!$result) {
    die ("Błąd połączenia z bazą danych" . $connection->errno);
}

//tabela wyświetlajaca wszystkie zamówienia i ich status oraz datę złożenia
echo "<table>";
echo "<tr>";
echo "<th>Autor zamówienia</th><th>Data zamówienia</th><th>Kwota zamówienia</th><th>Status zamówienia</th><th>Realizuj płatność</th>";
echo "</tr>";
foreach ($result as $value) {
    $status = $value['status'];
    if ($status != 0) {
        $status = 'Zapłacono';
    } else {
        $status = "<span style='color: red'>Do zapłaty!</span>";
    }
    $amount = $value['amount'];
    $date = $value['date'];
    $id = $value['id'];
    echo "<tr>";
    echo "<td>" . $_SESSION['user'] . "</td><td>" . $date . "</td><td>" . $amount . "</td><td>" . $status;
    if ($status == 'Zapłacono') {
        echo "</td><td>--------</td></tr>";
    } else {
        echo "</td><td><a href='payment.php?id=$id'>Zapłać</a>" . "</td></tr>";
    }
}

echo "</table>";
