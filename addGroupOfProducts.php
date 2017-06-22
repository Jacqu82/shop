<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

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
        Layout::AdminTopBar();
        echo "<p><a href='groupsOfProducts.php'><--Powrót</a></p>";
        ?>
        <div class="wrapper">
            <form action="addGroupOfProducts.php" method="post">
                <p>Wprowadź nazwę grupy</p>
                <input type="text" name="name"/><br>
                <p>Wprowadź opis grupy</p>
                <textarea type="text" name="description" rows="5" cols="40"></textarea>
                <br>
                <input type="submit" value="Add"/>
            </form>
        </div>
    </body>
    </html>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['name']) && isset($_POST['description'])) {

        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);

        //wywołujemy metodę addGrouo klasy Admin w celu dodania grupy produktów do bazy danych
        $group = Admin::addGroup($connection, $name, $description);

        if ($group) {
            echo "<div class='wrapper'>";
            echo "Dodano nową grupę produktów.</br><b>" . $name . "</b><br><br>";
            echo "<a href='adminPanel.php'>Panel administratora</a><br>";
            echo "<a href='groupsOfProducts.php'>Grupy produktów</a><br>";
            echo "</div>";
        } else {
            die("Błąd dodawania grupy do bazy danych!" . $connection->errno);
        }
    }
}
