<?php

include_once '../../connection.php';
include_once '../../config.php';
require_once '../../autoload.php';
require_once '../../layout/Layout.php';
require_once '../AdminRepository.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}
?>
<html>
<?php Layout::showHeadInUser(); ?>
<body>
<div class="container">
    <?php Layout::adminTopBar(); ?>
    <p><a href='groupsOfProducts.php'><--Powrót</a></p>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id = intval($id);
            $sql = "SELECT * FROM groups WHERE id=$id";
            $result = $connection->query($sql);

            if (!$result) {
                die ("error" . $connection->connect_error);
            }

            foreach ($result as $value) {
                $name = $value['groupName'];
                $description = $value['groupDescriptiopn'];
            }
            ?>
            <div class='wrapper'>
                <form action='editGroupOfProducts.php' method='post'>
                    <p>Edytuj nazwę dla grupy:<b><?php echo $name; ?></b></p>
                    <textarea name='name' rows='1' col='50'><?php echo $name; ?></textarea><br><br>
                    <p>Edytuj nazwę dla grupy:<b><?php echo $name; ?></b></p>
                    <textarea rows='4' cols='50' name='description'><?php echo $description; ?></textarea><br>
                    <input type='hidden' name='id' value=<?php echo $id ?>>
                    <input type='submit' value='Zmień'/>
                </form>
            </div>
            <?php
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['name']) && isset($_POST['description'])) {
            $name = mysqli_real_escape_string($connection, $_POST['name']);
            $description = mysqli_real_escape_string($connection, $_POST['description']);
            $id = mysqli_real_escape_string($connection, $_POST['id']);
            AdminRepository::modifyGroup($connection, $name, $description, $id);
        }
    }
    $connection->close();
    ?>
</div>
</body>
</html>