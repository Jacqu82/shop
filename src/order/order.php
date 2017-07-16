<?php

require_once '../../connection.php';
require_once '../../config.php';
require_once '../../layout/Layout.php';
require_once 'autoload.php';

session_start();

//jeżeli ktoś wpisze z palca w przeglądarce userPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę głóœną.
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}
?>
<html>
<?php Layout::showHeadInUser(); ?>
<body>
<div class="container">
    <?php
    Layout::userTopBar();
    ?>
    <hr>
    <p><a href='../../web/koszyk.php'><--Powrót</a></p>
    <div class='wrapper'>
        <span>Kwota do zapłaty:</span>
        <?php /**/
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['sum'])) {
                //zapisanie łącznej kwoty zamówienia i id użytkownika, który złożył zamówienie
                $sum = $_GET['sum'];
                $userId = $_GET['userId'];
                $sum = floatval($sum);
                $userId = intval($userId);

                echo "<span id='sumInPayment' sum='$sum'>" . $sum . " zł</span><br>";
                echo "<h3><a href='../user/payForProducts.php'>Przejdź do płatności</a> </h3>";

                //wykorzystanie pętli, która przebiega tyle razy ile przedmiotów zostało dodanych do koszyka - zmienna i
                for ($i = 1; $i != $_GET['i']; $i++) {
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
                        $date = date('d-m-Y');
                        $status = 0;
                        $order = new Order();
                        $order->setUserId($userId);
                        $order->setSum($sum);
                        $order->setDate($date);
                        $order->setStatusId($status);
//                        $order->saveToDB($connection, $userId, $sum, $date, $status);
                        $orderRepository = new OrderRepository();
                        $orderRepository->saveToDb($connection, $order);
                    }
                }
            }
        }
        ?>
    </div>
</div>
</body>
</html>