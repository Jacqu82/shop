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

    echo "Witaj " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";
    echo "<p><a href='groupsOfProducts.php'><--Powrót</a></p>";

    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $sql = "SELECT * FROM groups WHERE id=$id";
            $result = $connection->query($sql);

            if (!$result) {
                die ("error" . $connection->connect_error);
            }

            foreach ($result as $value) {
                $name = $value['groupName'];
                $description = $value['groupDescriptiopn'];
            }

            echo "<div class='wrapper'>";
            echo "<form action='editGroupOfProducts.php' method='post'>";
            echo "Edytuj nazwę dla grupy:<b>" . $name . " </b><br>";
            echo "<textarea name='name' rows='1' col='50'>" . $name . "</textarea><br><br>";
            echo "Edytuj nazwę dla grupy:<b>" . $name . "</b><br>";
            echo "<textarea rows='4' cols='50' name='description'>" . $description . "</textarea><br>";
            echo "<input type='hidden' name='id' value=$id>";
            echo "<input type='submit' value='Zmień'/>";
            echo "</form>";
            echo "</div>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['name']) && isset($_POST['description'])) {
            $name = mysqli_real_escape_string($connection, $_POST['name']);
            $description = mysqli_real_escape_string($connection, $_POST['description']);
            $id = mysqli_real_escape_string($connection, $_POST['id']);

            Admin::modifyGroup($connection, $name, $description, $id);
        }
    }
    $connection->close();
    ?>
</div>
</body>
</html>
