<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';

session_start();

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
echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a><hr>";
echo "<p><a href='adminPanel.php'><--Powrót</a></p>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_messege']) && isset($_POST['message_id'])) {
        $messageId = $_POST['message_id'];
        $message = Message::loadMessageById($connection, $messageId);
        $message->deleteMessage($connection);
    }
}

echo "<h2 style='text-align: center'>Skrzynka Admina</h2>";

$send = Message::loadAllSendMessagesByAdminId($connection, $_SESSION['admin']);
echo "<table border=1 cellpadding=5>";
echo "<tr>";
echo "<th>Date</th><th>User name</th><th>Title</th><th>Content</th>";
echo "</tr>";
foreach ($send as $value) {
    echo "<tr>";
    echo "<td>" . $value['creationDate'] . "</td><td>" . $value['surname'] . " " . $value['name'] . "</td><td>" . $value['messageTitle'] . "</td><td>" . $value['messageContent'] ."</td>";
    echo "<td><form method='POST'>
                            <input type=\"submit\" class=\"btn btn-primary\" name=\"delete_messege\" value=\"Usuń wiadomość\"/>
                            <input type='hidden' name='message_id' value='" . $value['id'] . " '>
                          </form></td>";
    echo '</tr>';

}
echo "</table>";

?>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    </body>
    </html>
