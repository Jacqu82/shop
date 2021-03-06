<?php

require_once '../../connection.php';
require_once '../../config.php';
require_once '../../layout/Layout.php';
require_once 'autoload.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
}
?>
<html>
<?php Layout::showHeadInUser(); ?>
<body>
<div class="container">
    <?php Layout::adminTopBar(); ?>
    <p><a href='adminPanel.php'><--Powrót</a></p>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_messege']) && isset($_POST['message_id'])) {
            $messageId = mysqli_real_escape_string($connection, $_POST['message_id']);
            $message = MessageRepository::loadMessageById($connection, $messageId);
            $messageRepository = new MessageRepository();
            $messageRepository->deleteMessage($connection, $message);
        }
    }
    ?>
    <h2 style='text-align: center'>Skrzynka Admina</h2>
    <?php
    $send = MessageRepository::loadAllSendMessagesByAdminId($connection, $_SESSION['admin']);
    ?>
    <table border=1 cellpadding=5 align="center">
        <tr>
            <th>Data</th>
            <th>Imię i nazwisko</th>
            <th>Tytuł</th>
            <th>Treść wiadomości</th>
            <th></th>
        </tr>
        <?php
        foreach ($send as $value) {
            ?>
            <tr>
                <td><?php echo $value['creationDate']; ?></td>
                <td><?php echo $value['surname'] . " " . $value['name'] ?></td>
                <td><?php echo $value['messageTitle'] ?></td>
                <td><?php echo $value['messageContent'] ?></td>
                <td>
                    <form method='POST'>
                        <input type="submit" class="btn btn-primary" name="delete_messege" value="Usuń wiadomość">
                        <input type='hidden' name='message_id' value='<?php echo $value['id']; ?>'>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<?php Layout::jsScriptsInMain(); ?>
</body>
</html>