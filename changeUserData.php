<?php

require_once 'connection.php';
require_once 'src/User.php';
require_once 'login.php';
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');      
}

?>

<html>
        <head>
            <meta charset="utf-8"/>
            <title>Shop</title>
            <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
            <script src="app.js?s3=213237" type="text/javascript"></script>
            <link href="style.css" type="text/css" rel="stylesheet"/>
        </head>

        <body>
            <div id="container">
                

                <?php
                echo "Hello " . $_SESSION['user'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a>";
                ?>
                <hr>
                <p>Change Your personal data:</p>
                <div id='changeName'>
                    <?php
                    
                    //paskudnie to wygląda ale zdaje egzamin - przycisk pokazuje/ukrywa formularz do zmiany danych
                    
                    $name = $_SESSION['user'];
                    $user = User::loadUserByName($connection, $name);
                    echo "Name: " . "<br><b>" . $user->getName() . "</b> &nbsp &nbsp" . "<input class='button' type='button' value='Change'/><br>";
                    echo "<form action='#' method='post'><input type='text' name='name'/><input type='submit' value='Confirm'/></form>";
                    
                    echo "Surname: " . "<br><b>" . $user->getSurname() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Change'/><br>";
                    echo "<form action='#' method='post'><input type='text' name='surname'/><input type='submit' value='Confirm'/></form>";
                    
                    echo "E-mail: " . "<br><b>" . $user->getEmail() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Change'/><br>";
                    echo "<form action='#' method='post'><input type='text' name='mail'/><input type='submit' value='Confirm'/></form>";
                    
                    echo "Password: " . "<br><b>" . $user->getPassword() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Change'/><br>";
                    echo "<form action='#' method='post'><input type='text' name='password'/><input type='submit' value='Confirm'/></form>";
                    
                    echo "Address: " . "<br><b>" . $user->getAddress() . "</b>&nbsp &nbsp" . "<input class='button' type='button' value='Change'/><br>";
                    echo "<form action='#' method='post'><input type='text' name='address'/><input type='submit' value='Confirm'/></form>";
                    
                    //pewnie da się to zrobic lepiej ale ja wpadłem na taki pomysł aktualizowania danych w bazie
                    //po zaktualizowaniu danych w bazie zmieniam również dane aktualnie zalogowanego usera
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $mail = $user->getEmail();
                        if (isset($_POST['name'])) {
                            $name = $_POST['name'];                                                     
                            $sql = "UPDATE users SET name='$name' WHERE email='$mail'";
                            $user->setName($name);
                            $_SESSION['user'] = $user->getName();
                            
                        } else if (isset ($_POST['surname'])) {
                            $surname = $_POST['surname'];                                                     
                            $sql = "UPDATE users SET surname='$surname' WHERE email='$mail'";
                            $user->setSurname($surname);
                            
                        } else if (isset($_POST['mail'])) {
                            $maill = $_POST['mail'];                                                     
                            $sql = "UPDATE users SET email='$maill' WHERE email='$mail'";
                            $user->setEmail($maill);
                            
                        } else if (isset($_POST['password'])) {
                            $password = $_POST['password'];                                                     
                            $sql = "UPDATE users SET password='$password' WHERE email='$mail'";
                            $user->setPassword($password);
                            
                        } else {
                            $address = $_POST['address'];                                                     
                            $sql = "UPDATE users SET address='$address' WHERE email='$mail'";
                            $user->setAddress($address);
                        }
                        
                        //nie mam pojęcia dlaczego, ale nie mog ę się połączyć w tym miejscu za pomocą require_once z connection.php
                        //dlatego wprowadziłem takie rozwiązanie, gdyby CI się udało wpaść na jakieś rozwiązanie to byłoby super
                        
                        $host = 'localhost'; 
                        $usser = 'root'; 
                        $password = 'coderslab';
                        $database = 'shop';

                        $connection = new mysqli($host, $usser, $password, $database);
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
        </body>
    </html>