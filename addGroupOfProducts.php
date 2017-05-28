<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';


session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

?>

    <html>
    <head>
        <title>adding Group of Products</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    <form action="addGroupOfProducts.php" method="post">
        Enter group name:<br>
        <input type="text" name="name"/><br>
        Enter group description:<br>
        <textarea type="text" name="description" rows="5" cols="40"></textarea>
        <br>
        <input type="submit" value="Add"/>
    </form>
    </body>
    </html>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['name']) && isset($_POST['description'])) {

        $name = $_POST['name'];
        $description = $_POST['description'];

        $connection = new mysqli($host, $user, $password, $database);
        $group = Admin::addGroup($connection, $name, $description);

        if ($group) {
            echo "A new group of products <b>" . $name . "</b> has been added<br>";
            echo "<a href='adminPanel.php'>Return to admin panel</a><br>";
            echo "<a href='groupsOfProducts.php'>Return to Group of products options</a><br>";
        } else {
            die("Błąd dodawania grupy do bazy danych!" . $connection->errno);
        }
    }
}
