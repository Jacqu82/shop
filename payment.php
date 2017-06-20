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
<?php //uaktualnienie statusu płatności z "nieuregulowany" na "uregulowany"
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "UPDATE orders SET status=1 WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd zapisu w bazie danych" . $connection->connect_errno);
        }
        header("Location: payForProducts.php");
    }
}
