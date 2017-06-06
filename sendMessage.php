<?php
require_once 'connection.php';
require_once 'autoload.php';

session_start();
//
////jeżeli ktoś wpisze z palca w przeglądarce userPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę głóœną.
//
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
    echo "Witaj " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a>";
    ?>
    <hr>
    <p><a href='itemPanel.php'><--Powrót</a></p>
    <div class="wrapper">
        <p>Wysyłanie wiadomości:</p>

        <p>Wybierz odbiorcę:</p>
        <?php

            $result = selectUsers::selectAllUsers($connection);

            if ($_SERVER['REQUEST_METHOD'] === "POST") {

                echo" hej";
                if (isset ($_POST['title']) && isset ($_POST['content'])) {

                    $title = $_POST['title'];
                    $content = $_POST['content'];
                    $id = $_POST['selection'];

                    $message = new Message();

                    $message->setTitle($_POST['title']);
                    $message->setContent($_POST['content']);
                    $message->setReceiverId($_POST['selection']);

                    $message->sendMessage($connection, $title, $content, $id);
                }
            }
        ?>
    </div>
</div>
</body>
</html>