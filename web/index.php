<?php

include_once 'connection.php';
require_once 'autoload.php';
require_once '../layout/Layout.php'

?>
<!DOCTYPE HTML>
<html>

<?php //metoda wysiwetlająca część Head strony
Layout::showHead();
?>

<body>
<div class="container">
    <?php //wywołanie metody pokazującej górny pasek opcji

    Layout::showAllOptionsIndex($connection);
    ?>
    <div id="panel" class="row">
        <h1>ALLEDROGO - niepoważny sklep internetowy</h1>
    </div>
    <div class="row mainRow">
        <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
            <div class="row rowing">
                <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                    <a href="index.php" class="btn btn-primary btn-block logo">Alledrogo</a>
                </div>
                <?php //wywołanie metody, która ma za zadanie wyświetlić wszystkie nazwy grup produktów(lewy side bar)
                Layout::showGroupName($connection)
                ?>
            </div>
        </div>
        <div class="col-md-8 tresc col-sm-8 col-xs-6" id="mainContent">
            <div id="content">
                <h1>Wyjątkowy sklep internetowy</h1>
                <br/>

                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
            <div class="row rowing">
                <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                    <div id="line">
                        <a href="#" class="btn btn-primary btn-block logo">Bestsellers</a>
                    </div>
                </div>
                <div id="productsCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <?php //trzy razy wywoływana metoda, której celem jest wylosowanie produktów i wrzucenie ich do karuzeli
                            Carousel::getHTML($connection); ?>
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
                    <div class="carousel-inner">
                        <div class="item active">
                            <?php //trzy razy wywoływana metoda, której celem jest wylosowanie produktów i wrzucenie ich do karuzeli
                            Carousel::getHTML($connection); ?>
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
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/style.js"></script>
</body>
<?php
$connection->close();
?>
</html>