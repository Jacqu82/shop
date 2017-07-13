<?php

include_once '../../connection.php';
include_once '../../config.php';
require_once '../../autoload.php';
require_once '../../layout/Layout.php';
require_once '../AdminRepository.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
}
echo "Witaj " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = intval($id);
        AdminRepository::removeGroup($connection, $id);
    }
}
