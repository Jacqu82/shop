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

echo "Witaj " . $_SESSION['adminName'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a><hr>";
echo "<p><a href='adminPanel.php'><--Powrót</a></p>";
echo "<div class='wrapper'>";

$result = selectUsers::selectUsersFromDb($connection);
echo "<p>Wybierz użytkownika,<br> którego chcesz usunąć:</p>";
echo "<form method='post' action='#'>";
echo "<select name='userSelection'>";
foreach ($result as $value) {
    echo "<option value='" . $value['id'] . "'>" . $value['name'] . $value['surname'] . "</option>";
}
echo "<input type='submit' value='Usuń'>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['userSelection'])) {
        $id = $_POST['userSelection'];

        $sql = "DELETE FROM message WHERE receiverId='$id'";
        $result = $connection->query($sql);
        if (!$result) {
            die ("Błąd połączenia z bazą danych message" . $connection->connect_error);
        }

        $sql = "DELETE FROM orders WHERE user_id='$id'";
        $result = $connection->query($sql);
        if (!$result) {
            die ("Błąd połączenia z bazą danych orders" . $connection->connect_errno);
        }

        $sql = "DELETE FROM cart WHERE user_id='$id'";
        $result = $connection->query($sql);
        if (!$result) {
            die ("Błąd połączenia z bazą danych cart" . $connection->connect_errno);
        }

        $sql = "DELETE FROM users WHERE id='$id'";
        $result = $connection->query($sql);
        if (!$result) {
            die ("Błąd połączenia z bazą danych cart" . $connection->connect_errno);
        }

        echo "Udało Ci się usunąć użytkownika.";

    }
}
echo "</div></div></body></html>";
