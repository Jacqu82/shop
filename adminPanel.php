<?php

include_once 'connection.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

//jeżeli ktoś wpisze z palca w przeglądarce adminPanel.php to jeśli nie jest zalogowany zostanie przeniesiony na stronę główną.

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}
?>
<html>
<?php Layout::showHeadInMain(); ?>
<body>
<div class="container">
    <?php
    Layout::AdminTopBar();
    ?>
    <hr>
    <div class="wrapper">
        <ul>Jesteś w panelu administratora <br>Masz do wyboru następujące opcje:
            <li><a href="groupsOfProducts.php">Dodaj, usuń lub modyfikuj grupę przedmiotów.</a></li>
            <li><a href="itemPanel.php">Dodaj, usuń lub modyfikuj przedmiot</a></li>
            <li><a href="deleteUser.php">Usuń użytkownika</a></li>
            <li><a href="sendMessage.php">Wyślij wiadomość</a></li>
            <li><a href="adminMessages.php">Pokaż wysłane wiadomości</a></li>
        </ul>
    </div>
</div>
</body>
</html>