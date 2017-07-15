<?php

require_once '../../connection.php';
require_once '../../layout/Layout.php';
require_once 'autoload.php';

session_start();

//jeżeli ktoś wpisze z palca w przeglądarce userMessages.php to jeśli nie jest zalogowany zostanie wyrzucony na stronę główną.
if (!isset($_SESSION['id'])) {
    header('Location: web/index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['set_message_as_read']) && isset($_POST['message_id'])) {
        $id = $_POST['message_id'];
        $id = intval($id);
        MessageRepository::setMessageStatus($connection, $id, 1);
    } else if (isset($_POST['set_message_as_unread']) && isset($_POST['message_id'])) {
        $id = $_POST['message_id'];
        $id = intval($id);
        MessageRepository::setMessageStatus($connection, $id, 0);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_message']) && isset($_POST['message_id'])) {
        $messageId = $_POST['message_id'];
        $messageId = intval($messageId);
        $message = MessageRepository::loadMessageById($connection, $messageId);
        $message->deleteMessage($connection);
    }
}
?>
<html>
<?php Layout::showHeadInUser() ?>
<body>
<div class="container">
    <?php
    //górny pasek z podstawowymi funkcjonalnościami użytkownika
    Layout::userTopBar();
    ?>
    <hr>
    <div class="backLink"><a href="userPanel.php"><--Powrót</a></div>
    <div class="wrapper">
        <?php
        $receive = MessageRepository::loadAllReceivedMessagesByUserId($connection, $_SESSION['id']);
        if ($receive->num_rows > 0) {
            echo "<h3>Skrzynka odbiorcza:</h3>";
            foreach ($receive as $row) {
                echo "Od " . $row['admin'] . "<br/>";
                if ($row['status'] == 0) {
                    echo "<form method='POST'>";
                    echo "<b>" . $row['title'] . "<br/>" . $row['content'] . "<br/>" . $row['date'] . "</b><br/>
                            <input type='submit'  name='set_message_as_read' value='Oznacz jako przeczytaną' class='btn btn-success' />
                            <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                            <input type=\"submit\" class=\"btn btn-primary\" name=\"delete_message\" value=\"Usuń wiadomość\"/>
                            <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                        </form>";
                } else {
                    echo "<form method='POST'>";
                    echo $row['title'] . "<br/>" . $row['content'] . "<br/>" . $row['date'] . "<br/>
                            <input type='submit'  name='set_message_as_unread' value='Oznacz jako nie przeczytaną' class='btn btn-success' />
                            <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                            <input type=\"submit\" class=\"btn btn-primary\" name=\"delete_message\" value=\"Usuń wiadomość\"/>
                            <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                        </form>";
                }
                echo "<hr/>";
            }
        } else {
            echo "<h3>Nie masz żadnych wiadomości!</h3>";
        }
        ?>
    </div>
</div>
<?php Layout::jsScriptsInMain() ?>
</body>
</html>