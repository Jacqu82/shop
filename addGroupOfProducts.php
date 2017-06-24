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
    <?php Layout::showHeadInMain(); ?>
    <body>
    <div class="container">
        <?php Layout::AdminTopBar(); ?>
        <p><a href='groupsOfProducts.php'><--Powrót</a></p>

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

        //wywołujemy metodę addGroup klasy Admin w celu dodania grupy produktów do bazy danych
        $group = Admin::addGroup($connection, $name, $description);

        if ($group) {
            ?>
            <div class='wrapper'>
                Dodano nową grupę produktów.</br><b><?php echo $name ?></b><br><br>
                <a href='adminPanel.php'>Panel administratora</a><br>
                <a href='groupsOfProducts.php'>Grupy produktów</a><br>
            </div>
        <?php
        } else {
            die("Błąd dodawania grupy do bazy danych!" . $connection->errno);
        }
    }
}
