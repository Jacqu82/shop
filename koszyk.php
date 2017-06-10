<?php

include_once 'connection.php';
require_once 'autoload.php';

session_start();

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html">
<head lang="pl">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale = 1">
    <title>Alledrogo-niepoważny sklep</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css?h=1" rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="js/style.js?s3=2132317" type="text/javascript"></script>
    <script src="js/jquery.cookie.js" type="text/javascript"></script>

</head>
<?php
//sprawdzenie czy użytkownik jest zalogowany
if (!isset($_SESSION['user'])) {
    header("location:index.php");
} else {
    ?>
    <body>
    <div class="container">
        <?php //wywołanie metody pokazującej górny pasek opcji
        showLoggedUserOptions::showAllOptions($connection);
        ?>
        <div id="panel" class="row">
            <div col-md-12 col-sm-12 col-xs-12>
                <h1>ALLEDROGO - niepoważny sklep internetowy</h1>
            </div>
        </div>

        <div class="row mainRow">
            <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
                <div class="row rowing">
                    <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                        <a href="index.php" class="btn btn-primary btn-block logo">Alledrogo</a>
                    </div>
                    <?php //wywołanie metody, która ma za zadanie wyświetlić wszystkie nazwy grup produktów
                    photoGallery::showGroupName($connection)
                    ?>
                </div>
            </div>
            <div class="col-md-8 tresc col-sm-6 col-xs-6 productInCart" id="mainContent">
                <?php //wywołanie metody, która pokazuje wszystkie przedmioty dodane do koszyka
                showItemInCart::showItem($connection);
                ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
                <div class="row rowing">
                    <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                        <div id="line">
                            <a href="#" class="btn btn-primary btn-block logo">Bestsellers</a>
                        </div>
                    </div>
                    <div id="productsCarousel" class="carousel slide" data-ride="carousel">
                        <?php //trzy razy wywoływana metoda, której celem jest wylosowanie produktów i wrzucenie ich do karuzeli
                        ?>
                        <div class="carousel-inner">
                            <div class="item active">
                                <?php Carousel::getHTML($connection); ?>
                            </div>
                            <div class="item">
                                <?php Carousel::getHTML($connection); ?>
                            </div>
                            <div class="item">
                                <?php Carousel::getHTML($connection); ?>
                            </div>
                        </div>
                    </div>
                    <div id="productsCarousel" class="carousel slide" data-ride="carousel">
                        <?php //trzy razy wywoływana metoda, której celem jest wylosowanie produktów i wrzucenie ich do karuzeli
                        ?>
                        <div class="carousel-inner">
                            <div class="item active">
                                <?php Carousel::getHTML($connection); ?>
                            </div>
                            <div class="item">
                                <?php Carousel::getHTML($connection); ?>
                            </div>
                            <div class="item">
                                <?php Carousel::getHTML($connection); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row foot">
            <h1>Stopka naszej strony internetowej</h1>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/style.js"></script>
    </body>
    <?php
}
$connection->close();

?>
</html>