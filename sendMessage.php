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
    <meta charset="utf-8"/>
    <title>Shop</title>
</head>
<body>
<div id="container">
    <?php
    echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a>";
    ?>
    <hr>
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
</body>
</html>