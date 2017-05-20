<!DOCTYPE HTML>
<?php
include_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Carousel.php';
require_once 'src/photoGallery.php';
require_once 'src/productGroup.php';

session_start();
?>
<html>
<head lang="pl">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale = 1">

    <title>Alledrogo-niepoważny sklep</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css?h=1" rel="stylesheet">
</head>
<?php
if (!isset($_SESSION['user'])) {
    ?>
    <body>
    <div class="container">
        <div class="row" style="border-bottom: solid">
            <div class="col-md-2 col-sm-3 col-xs-4 witaj row1">
                <a href="loginForm.html" class="btn btn-primary btn-block">Logowanie</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4 rejestracja row1">
                <a href="#" class="btn btn-primary btn-block">Rejestracja</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4 col-md-offset-6 col-sm-offset-3 koszyk row1">
                <a href="koszyk.php" class="btn btn-success disabled btn-block">Koszyk</a>
            </div>
        </div>

    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    </body>
<?php
} else {
    ?>
    <body>
    <div class="container">
        <div class="row" style="border-bottom: solid">
            <div class="col-md-2 col-sm-3 col-xs-3 witaj row1">
                <a href="userPanel.php" class="btn btn-primary btn-block"><?php echo $_SESSION['user']; ?></a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-3 rejestracja row1">
                <a href="logOut.php" class="btn btn-primary btn-block">Wyloguj</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-3 col-md-offset-6 col-sm-offset-3 koszyk row1">
                <a href="koszyk.php" class="btn btn-success btn-block">Koszyk</a>
                <a></a>
            </div>
        </div>

        <div id="panel" class="row">
            <h1>ALLEDROGO - niepoważny sklep internetowy</h1>
        </div>

        <div class="row mainRow">
            <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
                <div class="row rowing">
                    <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                        <a href="index.php" class="btn btn-primary btn-block logo">Alledrogo</a>
                    </div>
                    <?php photoGallery::showGroupName($host, $user, $password, $database) ?>
                </div>
            </div>
            <div class="col-md-8 tresc col-sm-8 col-xs-6" id="mainContent">
                <?php

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    if (isset($_GET['groupId'])) {
                        $groupId = $_GET['groupId'];
                        ?>
                        <div id="content" class="fakeScroll">
                            <?php productGroup::showProductGroup($groupId, $host, $user, $password, $database) ?>
                        </div>
                    <?php
                    }
                }
                ?>

            </div>
            <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
                <div class="row rowing">
                    <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                        <div id="line">
                            <a href="#" class="btn btn-primary btn-block logo">Bestsellers</a>
                        </div>

                    </div>
                    <div id="productsCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 100px">
                        <?php
                        ?>
                        <div class="carousel-inner">
                            <div class="item active">

                                <?php
                                $result = Carousel::parametersReceiver($host, $user, $password, $database);
                                $id = ($result['id']);
                                ?>


                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>" ?><img id="wtf" class="img-responsive"
                                                                                      src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span
                                            style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span
                                                style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = Carousel::parametersReceiver($host, $user, $password, $database);
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>" ?><img id="wtf" class="img-responsive"
                                                                                      src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span
                                            style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span
                                                style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = Carousel::parametersReceiver($host, $user, $password, $database);
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>" ?><img id="wtf" class="img-responsive"
                                                                                      src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span
                                            style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span
                                                style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="productsCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 10px">
                        <?php
                        ?>
                        <div class="carousel-inner">
                            <div class="item active">

                                <?php
                                $result = Carousel::parametersReceiver($host, $user, $password, $database);
                                $id = ($result['id']);
                                ?>


                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>" ?><img id="wtf" class="img-responsive"
                                                                                      src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span
                                            style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span
                                                style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = Carousel::parametersReceiver($host, $user, $password, $database);
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>" ?><img id="wtf" class="img-responsive"
                                                                                      src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span
                                            style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span
                                                style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = Carousel::parametersReceiver($host, $user, $password, $database);
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>" ?><img id="wtf" class="img-responsive"
                                                                                      src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span
                                            style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span
                                                style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
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
    </body>
<?php
};
?>
</html>
