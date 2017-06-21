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

                echo "<span id='sumInPayment' sum='$sum'>" . $sum . "zł.</span><br>";
                echo "<a href='payForProducts.php'>Zapłać</a>";

                //wykorzystanie pętli, która przebiega tyle razy ile przedmiotów zostało dodanych do koszyka - zmienna i
                for ($i = 0; $i != $_GET['i']; $i++) {
                    if ($i == 0) {

                    } else {
                        //przy każdej iteracji pobieram dane GET-em a następnie uaktualniam bazę danych
                        $quantity = $_GET['quantity' . $i];
                        $id = $_GET['id' . $i];

                        //uaktualniam ilośc produktu- odejmuje od ilości bazowej ilośc zakupionego towaru
                        $sql = "UPDATE item SET availability = availability - $quantity WHERE id=$id";

                        $result = $connection->query($sql);

                        if (!$result) {
                            die ("Błąd zapisu do bazy danych" . $connection->connect_errno);
                        }
                        //kasuje zawartośc koszyka - zakup został już dokonany
                        $sql = "DELETE from cart WHERE user_id=$userId";

                        $result = $connection->query($sql);

                        if (!$result) {
                            die ("Błąd zapisu do bazy danych" . $connection->connect_errno);
                        }

                        if ($i == $_GET['i'] - 1) {
                            $date = date('d-m-y');
                            $status = 0;

                            //zapisuje do tabeli z zamowieniami szczegółhy danego zamówienia
                            $sql = "INSERT INTO orders(user_id, amount, date, status) VALUES ('$userId', '$sum', '$date', '$status' )";

                            $result = $connection->query($sql);

                            if (!$result) {
                                die ("Błąd zapisu do bazy danych" . $connection->connect_errno);
                            }
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