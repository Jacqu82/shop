<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: web/index.php');
}
?>
<html>
<?php Layout::showHeadInMain(); ?>
<body>
<div class="container">
    <?php Layout::AdminTopBar(); ?>
    <p><a href='adminPanel.php'><--Powrót</a></p>
    <div class='wrapper'>
        <?php
        $result = SqlQueries::selectUsersFromDb($connection);
        ?>
        <p>Wybierz użytkownika<br> którego chcesz usunąć:</p>
        <form method='post' action='#'>
            <select name='userSelection'>
                <?php
                foreach ($result as $value) {
                    echo "<option value='" . $value['id'] . "'>" . $value['name'] . $value['surname'] . "</option>";
                }
                ?>
                <input type='submit' value='Usuń'>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['userSelection'])) {
                $id = mysqli_real_escape_string($connection, $_POST['userSelection']);

                $sql = "DELETE FROM message WHERE receiverId='$id'";
                $result = $connection->query($sql);
                if (!$result) {
                    die ("Błąd połączenia z bazą danych" . $connection->connect_error);
                }

                $sql = "DELETE FROM orders WHERE user_id='$id'";
                $result = $connection->query($sql);
                if (!$result) {
                    die ("Błąd połączenia z bazą danych" . $connection->connect_errno);
                }

                $sql = "DELETE FROM cart WHERE user_id='$id'";
                $result = $connection->query($sql);
                if (!$result) {
                    die ("Błąd połączenia z bazą danych" . $connection->connect_errno);
                }

                $sql = "DELETE FROM users WHERE id='$id'";
                $result = $connection->query($sql);
                if (!$result) {
                    die ("Błąd połączenia z bazą danych" . $connection->connect_errno);
                }
                echo "Udało Ci się usunąć użytkownika.";
            }
        }
        ?>
    </div>
</div>
</body>
</html>