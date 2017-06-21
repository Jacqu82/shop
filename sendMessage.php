<?php

require_once 'connection.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

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
    Layout::AdminTopBar();
    ?>
    <hr>
    <p><a href='adminPanel.php'><--Powrót</a></p>
    <div class="wrapper">
        <p>Wysyłanie wiadomości:</p>

        <p>Wybierz odbiorcę:</p>
        <?php

        $result = selectUsers::selectAllUsers($connection);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['receiverId']) && isset($_POST['messageTitle']) && isset($_POST['messageContent'])) {
                $receiverId = $_POST['receiverId'];
                $messageTitle = $_POST['messageTitle'];
                $messageContent = $_POST['messageContent'];

                $message = new Message();
                $message->setAdminId($_SESSION['admin']);
                $message->setReceiverId($receiverId);
                $message->setMessageTitle($messageTitle);
                $message->setMessageContent($messageContent);
                $message->setCreationDate();
                $message->setMessageStatus($connection, $message->getId(), 0);
                $message->saveToDB($connection);
                $send = Message::loadLastSendMessageByUserId($connection, $_SESSION['admin']);
                foreach ($send as $value) {
                    echo '<div class="flash-message alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <strong>Wysłałeś wiadomość do ' . $value["name"] . '</strong>
                    </div>';
                }
            }
        }
        ?>
    </div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/style.js"></script>
</body>
</html>