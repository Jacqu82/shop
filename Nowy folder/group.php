<!DOCTYPE HTML>
<?php
include_once 'connection.php';
require_once 'src/User.php';

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

        $connection = new mysqli('sql.5v.pl', 'db-user21398', 'kc1iq9gg8ab37bip', 'db-user21398');

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na itemie" . $connection->error);
        }

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability =$value['availability'];
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
                <a href="logOut.php" class="btn btn-primary btn-block"><?php echo $_SESSION['user'];?></a>
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
                    <?php  foreach ($result as $value) {
                        $groupId = $value['id'];
                        ?>

                        <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1">
                            <?php echo "<a href='group.php?groupId=$groupId'";?> class="btn btn-primary btn-block"><?php echo $value['groupName']; ?></a>
                        </div>
                    <?php  } ?>
                </div>
            </div>
            <div class="col-md-8 tresc col-sm-8 col-xs-6" id="mainContent">
                <?php

                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        if (isset($_GET['groupId'])) {
                            $groupId = $_GET['groupId'];
                            ?>
                <div id="content" class="fakeScroll">
                    <?php
                        $sql = "SELECT * FROM item WHERE group_id=$groupId";
                        $result = $connection->query($sql);

                        if (!$result) {
                            die ("Błąd połączenia z bazą danych" . $connection->connect_error);
                        }

                        foreach ($result as $value) {
                            $id = $value['id'];
                            $name = $value['name'];
                            $price = $value['price'];
                            $availability =$value['availability'];

                            $sql = "SELECT * FROM photos WHERE item_id=$id LIMIT 1";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die ("Błąd połączenia z bazą danych" . $connection->connect_error);
                            }

                            foreach ($result as $value) {
                                $path = $value['path'];
                            }

                            echo "<div class='col-md-6 col-sm-6 col-xs-12 productElement' >";
                            echo "<div class='col-md-6 col-sm-12 col-xs-12 productPhotoElement'>";
                            echo "<a href='product.php?id=$id'><img id='wtf' class='img-responsive'  src='$path' style='border: solid 2px darkred'></a>";
                            echo "</div>";
                            echo "<div class='col-md-6 col-sm-12 col-xs-12 productPriceElement'>";
                            echo "<p>" . $price . "zł.</p><p>" . $availability . " szt.</p>" . "<a href='koszyk.php?id=$id' class='btn btn-primary btn-block'>Do Koszyka</a>";
                            echo "</div>";
                            echo "<div class='col-md-12 col-sm-12 col-xs-12 productBuyElement' style='margin-bottom: 65px'>";
                            echo "<h3 style='border-bottom: 2px solid darkred'>" . $name . "</h3>";
                            echo "</div>";
                            echo "</div>";
                        }
                    ?>

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
                                $result = parametersReceiver();
                                $id = ($result['id']);
                                ?>


                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>"?><img  id="wtf" class="img-responsive"  src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = parametersReceiver();
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>"?><img id="wtf" class="img-responsive"  src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = parametersReceiver();
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>"?><img id="wtf" class="img-responsive"  src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
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
                                    <?php echo "<a href='product.php?id=$id'>"?><img id="wtf" class="img-responsive"  src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = parametersReceiver();
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>"?><img id="wtf" class="img-responsive"  src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
                                </div>
                            </div>
                            <div class="item">

                                <?php
                                $result = parametersReceiver();
                                $id = ($result['id']);
                                ?>

                                <div class="carousel-caption">
                                    <?php echo "<a href='product.php?id=$id'>"?><img id="wtf" class="img-responsive"  src="<?php echo $result['path']; ?>"></a>
                                    <div id="inner1"><span style="padding-right: 10px">Cena:</span><span style="color: red; font-size: 110% "><?php echo $result['price'] . " zł."; ?></span><br><b><span style="font-size: 110%"><?php echo $result['name']; ?></span></b></div>
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