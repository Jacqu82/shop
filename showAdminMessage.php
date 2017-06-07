<?php

include_once 'connection.php';
include_once 'autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset ($_GET['id']) && isset ($_GET['i'])) {

        $id = $_GET['id'];

        if ($_GET['i'] == 0) {

            Message::deleteMessage($connection, $id);

            header("Location: adminMessages.php");
        } else {

            Message::showMessage($connection, $id);
        }
    }
}