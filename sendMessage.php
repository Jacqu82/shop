<?php

require_once 'connection.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

////jeżeli ktoś wpisze z palca w przeglądarce userPanel.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę głóœną.
if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
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
    <p><a href='adminPanel.php'><--Powrót</a></p>

    <div class="wrapper">
        <p>Wysyłanie wiadomości:</p>

        <p>Wybierz odbiorcę:</p>
        <?php
        $result = Layout::selectAllUsers($connection);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['receiverId']) && isset($_POST['messageTitle']) && isset($_POST['messageContent'])) {
                $receiverId = mysqli_real_escape_string($connection, $_POST['receiverId']);
                $messageTitle = mysqli_real_escape_string($connection, $_POST['messageTitle']);
                $messageContent = mysqli_real_escape_string($connection, $_POST['messageContent']);

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
                    echo '  <div class="flash-message alert alert-success alert-dismissible" role="alert">
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
<?php Layout::jsScriptsInMain() ?>
</body>
</html>