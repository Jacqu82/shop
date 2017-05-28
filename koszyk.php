<!DOCTYPE HTML>
<?php
include_once 'connection.php';
require_once 'autoload.php';

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
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="js/style.js?s3=213237" type="text/javascript"></script>

</head>
<?php
if (!isset($_SESSION['user'])) {
    header("location:index.php");
} else {

    $connection = new mysqli($host, $user, $password, $database);
    $sql = "SELECT * FROM groups";
    $result = $connection->query($sql);

    if (!$result) {
        die ("Error - błąd połączenia z bazą danych" . $connection->error);
    }
    ?>
    <body>
    <?php
    function parametersReceiver()
    {
        $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1 ";

        $connection = new mysqli('localhost', 'root', 'coderslab', 'shop');

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na itemie" . $connection->error);
        }

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];
            $description = $value['description'];
        }


        $sql = "SELECT * FROM photos WHERE item_id = $id LIMIT 1";

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na photosie" . $connection->error);
        }

        foreach ($result as $value) {
            $path = $value['path'];
        }

        $array = [
            'id' => $id,
            'path' => $path,
            'name' => $name,
            'price' => $price,
            'availability' => $availability,
            'description' => $description
        ];

        return $array;
    }

    ?>
    <div class="container">
        <div class="row" style="border-bottom: solid">
            <div class="col-md-2 col-sm-3 col-xs-3 witaj row1">
                <a href="web/logOut.php" class="btn btn-primary btn-block"><?php echo $_SESSION['user']; ?></a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-3 rejestracja row1">
                <a href="web/logOut.php" class="btn btn-primary btn-block">Wyloguj</a>
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
            <div class="col-md-2 col-sm-3 col-xs-3 witaj row1">
                <div class="row rowing">
                    <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                        <a href="web/logOut.php" class="btn btn-primary btn-block logo">Alledrogo</a>
                    </div>
                    <?php foreach ($result as $value) {
                        $groupId = $value['id'];
                        ?>

                        <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1">
                            <?php echo "<a href='group.php?groupId=$groupId'"; ?> class="btn btn-primary
                            btn-block"><?php echo $value['groupName']; ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-8 tresc col-sm-6 col-xs-6 productInCart">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['name'])) {
                echo "<div class='col-md-2' style='color:white'>";
                $name = $_GET['name'];
                $item = Item::loadItemByName($connection, $name);
                $id = $item->getId();
                $result = Carousel::getPhotoPath($host, $user, $password, $database, $id);
                $availability = $item->getAvailability();

                foreach ($result as $value) {
                    $path = $value['path'];
                }
                echo "<img src='$path' class='img-responsive'>";
                ?>
            </div>
            <div class="col-md-4" style="color:white">
                <?php
                    echo "<br/>$name";
                ?>
            </div>
            <div class="col-md-2" style="color:white">
                <form action="#" method="post">
                    <label>
                        Ilość:
                        <input type="number" name="quantity" class="form-control input-md" max='<?php echo $availability;?>'>
                        z <?php
                        echo $item->getAvailability();
                        ?>
                    </label>
                </form>
            </div>
            <div class="col-md-2" style="color:white">
                Cena: <?php echo $item->getPrice();?>
            </div>
            <div class="col-md-2" style="color:white">
                <br/><button class="btn-danger" id="deleteItemInBasket">Usuń</button>
            </div>
            <?php

                }
            }
            ?>

        </div>
        <div class="col-md-2 col-sm-3 col-xs-3 witaj row1">
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
                            $result = parametersReceiver();
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
                            $result = parametersReceiver();
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
                            $result = parametersReceiver();
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
                            $result = parametersReceiver();
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
                            $result = parametersReceiver();
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
                            $result = parametersReceiver();
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
    <script src="js/style.js"></script>
    </body>
    <?php
};
?>
</html>
