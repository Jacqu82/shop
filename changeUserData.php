<?php

require_once 'connection.php';
require_once 'web/login.php';
require_once 'autoload.php';
require_once 'layout/Layout.php';

if (!isset($_SESSION['user'])) {
    header('Location: web/index.php');
}
?>
<html>
<?php Layout::showHeadInMain(); ?>
<body>
<div class="container">
    <?php
    Layout::userTopBar();
    ?>
    <hr>
    <div class="backLink"><a href="userPanel.php"><--Powrót</a></div>
    <div class="wrapper">
        <p>Zmień swoje dane:</p>
        <div id='changeName'>
            <?php
            //przycisk pokazuje/ukrywa formularz do zmiany danych
            $name = $_SESSION['user'];
            $user = UserRepository::loadUserByName($connection, $name);

            echo "Imię: " . "<br><b>" . $user->getName() . "</b> &nbsp &nbsp" . "<input class='button' type='button' value='Zmień'/><br>";
            echo "<form action='#' method='post'><input type='text' name='name'/><input type='submit' value='Confirm'/></form>";
            echo "Nazwisko: " . "<br><b>" . $user->getSurname() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Zmień'/><br>";
            echo "<form action='#' method='post'><input type='text' name='surname'/><input type='submit' value='Confirm'/></form>";
            echo "E-mail: " . "<br><b>" . $user->getEmail() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Zmień'/><br>";
            echo "<form action='#' method='post'><input type='text' name='mail'/><input type='submit' value='Confirm'/></form>";
            echo "Hasło: " . "<br><b>" . $user->getPassword() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Zmień'/><br>";
            echo "<form action='#' method='post'><input type='text' name='password'/><input type='submit' value='Confirm'/></form>";
            echo "Adres: " . "<br><b>" . $user->getAddress() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Zmień'/><br>";
            echo "<form action='#' method='post'><input type='text' name='address'/><input type='submit' value='Confirm'/></form>";

            //po zaktualizowaniu danych w bazie zmieniam również dane aktualnie zalogowanego usera
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $mail = $user->getEmail();
                if (isset($_POST['name'])) {
                    $name = mysqli_real_escape_string($connection, $_POST['name']);
                    $sql = "UPDATE users SET name='$name' WHERE email='$mail'";
                    $user->setName($name);
                    $_SESSION['user'] = $user->getName();
                } else if (isset ($_POST['surname'])) {
                    $surname = mysqli_real_escape_string($connection, $_POST['surname']);
                    $sql = "UPDATE users SET surname='$surname' WHERE email='$mail'";
                    $user->setSurname($surname);
                } else if (isset($_POST['mail'])) {
                    $maill = mysqli_real_escape_string($connection, $_POST['mail']);
                    $sql = "UPDATE users SET email='$maill' WHERE email='$mail'";
                    $user->setEmail($maill);
                } else if (isset($_POST['password'])) {
                    $password = mysqli_real_escape_string($connection, $_POST['password']);
                    $sql = "UPDATE users SET password='$password' WHERE email='$mail'";
                    $user->setPassword($password);
                } else {
                    $address = mysqli_real_escape_string($connection, $_POST['address']);
                    $sql = "UPDATE users SET address='$address' WHERE email='$mail'";
                    $user->setAddress($address);
                }
                $ready = $connection->query($sql);
                if (!$ready) {
                    die("Bład zapisu w bazie danych");
                }
                //tutaj przycisk do odświeżenia, tak żeby przekonać się czy dane zaktualizowały się.
                echo "Udało Ci się zmienić dane<br>";
                echo "<a href='changeUserData.php'>Odśwież</a>";
            }
            ?>
        </div>
    </div>
</div>
<?php Layout::jsScriptsInMain(); ?>
</body>
</html>