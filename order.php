<?php
require_once 'connection.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

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

    Layout::UserTopBar();
    ?>
    <hr>
    <p><a href='web/koszyk.php'><--Powrót</a></p>

    <div class='wrapper'>
        <span>Kwota do zapłaty:</span>
        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['sum'])) {
                //zapisanie łącznej kwoty zamówienia i id użytkownika, który złożył zamówienie
                $sum = $_GET['sum'];
                $userId = $_GET['userId'];
                $userId = intval($userId);

                echo "<span id='sumInPayment' sum='$sum'>" . $sum . "zł.</span><br>";
                echo "<a href='payForProducts.php'>Zapłać</a>";

                //wykorzystanie pętli, która przebiega tyle razy ile przedmiotów zostało dodanych do koszyka - zmienna i
                for ($i = 0; $i != $_GET['i']; $i++) {
                    if ($i == 0) {

                    } else {
                        //przy każdej iteracji pobieram dane GET-em a następnie uaktualniam bazę danych
                        $quantity = $_GET['quantity' . $i];
                        $quantity = intval($quantity);
                        $id = $_GET['id' . $i];
                        $id = intval($id);

                        //uaktualniam ilośc produktu- odejmuje od ilości bazowej ilośc zakupionego towaru
                        SqlQueries::setAvailability($connection, $quantity, $id);
                        //kasuje zawartośc koszyka - zakup został już dokonany
                        SqlQueries::clearCart($connection, $userId);

                        if ($i == $_GET['i'] - 1) {
                            $date = date('d-m-y');
                            $status = 0;

                            $order = new Order();
                            $order->saveToDB($connection, $userId, $sum, $date, $status);
                        }
                    }
                }
            }
        }
        ?>
    </div>
</div>
</body>
</html>