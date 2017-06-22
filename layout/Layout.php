<?php

require_once 'connection.php';

class Layout
{
    public static function showHead()
    {
        echo '
        <head lang="pl">
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale = 1">

            <title>Alledrogo-niepoważny sklep</title>
            <link href="../css/bootstrap.css" rel="stylesheet">
            <link href="../css/style.css?h=1" rel="stylesheet">
            <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
            <script src="../js/style.js?s3=213235517" type="text/javascript"></script>
            <script src="../js/jquery.cookie.js" type="text/javascript"></script>
        </head>
        ';
    }

    //metoda sprawdzająca czy użytkownik jest zalogowany
    static public function showAllOptionsIndex($connection)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['user'])) {

            $id = $_SESSION['id'];
            $id = intval($id);

            echo '<div class="row" id="topMenu">';
            echo '<div class="col-md-2 col-sm-3 col-xs-3 witaj row1">';
            echo '<a href="../userPanel.php" class="btn btn-primary btn-block">' . $_SESSION['user'];
            echo '<span class="glyphicon glyphicon-envelope" style="margin-top: 2px"></span>';
            echo '<span style="padding-left: 4px">';

            Message::getUnreadMessage($connection, $id);

            echo '</span>';
            echo '</a>';
            echo '</div>';
            echo '<div class="col-md-2 col-sm-3 col-xs-3 rejestracja row1">';
            echo '<a href="logOut.php" class="btn btn-primary btn-block">Wyloguj</a>';
            echo '</div>';
            echo '<div class="col-md-2 col-sm-3 col-xs-3 col-md-offset-6 col-sm-offset-3 koszyk row1">';
            echo '<a href="koszyk.php" class="btn btn-success btn-block">Koszyk</a>';
            echo "</div>";
            echo "</div>";
        } else {
            echo '
        <div class="row" id="topMenu">
            <div class="col-md-2 col-sm-3 col-xs-4 witaj row1">
                <a href="loginForm.html" class="btn btn-primary btn-block">Logowanie</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4 rejestracja row1">
                <a href="registerForm.html" class="btn btn-primary btn-block">Rejestracja</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4 col-md-offset-6 col-sm-offset-3 koszyk row1">
                <a href="koszyk.php" class="btn btn-success disabled btn-block">Koszyk</a>
            </div>
        </div>';
        }
    }

    public static function showGroupName(mysqli $connection)
    {
        $result = SqlQueries::getGallery($connection);

        foreach ($result as $value) {
            echo '<div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1">';
            echo "<a href='group.php?groupId=" . $value['id'] . "' class='btn btn-primary btn-block'>" . $value['groupName'] . "</a>";
            echo '</div>';
        }
    }

    public static function showProductCarousel(mysqli $connection)
    {

    }

    public static function UserTopBar()
    {
        echo "Witaj " . $_SESSION['user'] . " | " . "<a href='web/index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a>";
    }

    public static function AdminTopBar()
    {
        echo "Witaj " . $_SESSION['adminName'] . " | " . "<a href='web/index.php'>Start</a>" . " | " . "<a href='web/logOut.php'>wyloguj</a>";
    }

    public static function getHTML(mysqli $connection)
    {
        $result = Item::parametersReceiver($connection);

        $id = ($result['id']);

        echo "  <div class='carousel-caption'>
                    <a href='product.php?id=" . $id . "'>
                        <img id='wtf' class='img-responsive' src='" . $result['path'] . "'>
                    </a>
                    <div id='inner1'>
                        <span id='priceCarousel'>Cena:</span>
                        <span  id='amountCarousel'>" . $result['price'] . " zł." . "</span><br>
                        <b><span id='carouselName'>" . $result['name'] . "</span></b>
                    </div>
                </div>";
    }

    public static function payForProducts($result)
    {
        echo "<table>";
        echo "<tr>";
        echo "<th>Autor zamówienia</th><th>Data zamówienia</th><th>Kwota zamówienia</th><th>Status zamówienia</th><th>Realizuj płatność</th>";
        echo "</tr>";
        foreach ($result as $value) {
            $status = $value['status'];
            if ($status != 0) {
                $status = 'Zapłacono';
            } else {
                $status = "<span style='color: red'>Do zapłaty!</span>";
            }
            $amount = $value['amount'];
            $date = $value['date'];
            $id = $value['id'];
            echo "<tr>";
            echo "<td>" . $_SESSION['user'] . "</td><td>" . $date . "</td><td>" . $amount . "</td><td>" . $status;
            if ($status == 'Zapłacono') {
                echo "</td><td>--------</td></tr>";
            } else {
                echo "</td><td><a href='payForProducts.php?id=$id'>Zapłać</a>" . "</td></tr>";
            }
        }

        echo "</table>";
    }

    public static function showProductDetail(mysqli $connection, $id)
    {
        $result = Item::getAllData($connection, $id);
        $itemName = $result['name'];
        $paths = Item::getAllPhotos($connection, $id);
        $path = $paths[0];

        echo "
            <div class='col-md-8 tresc col-sm-8 col-xs-6'>
                <div id='photoSpace' class='col-md-6 col-sm-6 col-xs-12'>
                    <img id='mainPhoto' class='img-responsive' src='" . $paths[0] . "' style='border: solid 2px red'>
                    <div id='smallPhotos' class='col-md-12 col-sm-12 col-xs-12' style='position: relative; left: -0.5em ;top: 0.25em'>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='firstThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[0] . "' style='border: solid 2px red'></a>
                        </div>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='secondThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[1] . "' style='border: solid 2px red'></a>
                        </div>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='secondThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[2] . "' style='border: solid 2px red'></a>
                        </div>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='secondThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[3] . "' style='border: solid 2px red'></a>
                        </div>
                    </div>
                </div>
                <div id='priceSpace' class='col-md-6 col-sm-6 col-xs-12' >
                    <h2>" . $result['name'] . "</h2>
                    <div class='col-md-6 col-sm-6 col-xs-6'><h3>Cena:</h3><h3>Dostepny:</h3></div>
                    <div class='col-md-6 col-sm-6 col-xs-6'>
                        <h3>" . $result['price'] . "zł.</h3>
                        <h3>" . $result['availability'] . " szt.</h3>
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12'>
                        <a href='../addItemToCart.php?name=$itemName&path=$path' class='btn btn-success btn-block'>Do Koszyka</a>
                    </div>
                </div>
                <div id='descriptionSpace' class='col-md-12 col-sm-12 col-xs-12'>
                    <p style='padding-top: 30px; font-size: 1.3em'>" . $result['description'] . "</p>
                </div>
            </div>";
    }

    public static function showItem(mysqli $connection)
    {
        $result = SqlQueries::getItemInCart($connection);
        $sum = 0;
        $userId = $_SESSION['id'];
        $i = 1;
        $sing = '';
        echo "<div userId='$userId' id='userId'></div>";
        foreach ($result as $value) {
            $id = $value['id'];
            echo '
    <div class="col-md-12 productInCart">
            <div class="col-md-2 part"><img class="img-responsive "src="' . $value['path'] . '">
            </div>
            <div class="col-md-4 part">' . $value['name'] . '
            </div>
            <div class="col-md-2 part">' . '<form class="fuck"><input type ="number"  id="' . $id . '" class="itemId form-control input-sm quantityItem" value = 1 min="1" max="' . $value["availability"] . '"></form>max: ' . $value['availability'] . '
            </div>
            <div class="col-md-2 part price" name="' . $value['price'] . '">' . $value['price'] . '
            </div>
        <div class="col-md-2 part">
            <br/>
            <a href="../deleteItemFromCart.php?id=' . $id . '"><button class="btn-danger deleteItemInBasket">Usuń</button></a>
        </div>
    </div>';
            $sum += $value['price'];
            $sing .= '&id' . $i . '=' . $id . '&quantity' . $i . '=1';
            $i++;
        }
        echo "<div class='col-md-12' style='color: #ffffff; border-top: solid white 1px; margin-bottom: 10px'>";
        echo "<div class='col-md-8' style=''>Łączna kwota wynosi: </div>";
        echo "<div class='col-md-2' id='sum'>$sum</div>";
        echo "<div class='col-md-2'><a href='../order.php?sum=$sum&userId=$userId" . $sing . "&i=" . $i . "'><button class='btn-info' id='buttonPay'>Zapłać</button> </a> </div>";
        echo "</div>";
    }

    public static function selectAllUsers(mysqli $connection)
    {
        $result = SqlQueries::selectUsersFromDb($connection);

        echo '<form action="#" method="post">';
        echo '<select name="receiverId">';

        foreach ($result as $value) {
            echo '<option value="' . $value['id'] . '">' . $value['name'] . ' ' . $value['surname'] . '</option>';
        }

        echo '</select><br><br>';
        echo 'Tytuł wiadomości:<br>';
        echo '<input type="text" name = "messageTitle"><br>';
        echo 'Treść wiadomości:<br>';
        echo '<textarea name="messageContent" cols="30" rows="5"></textarea>';

        echo '<br><br><input type="submit" value="Wyślij"></form>';
    }

    public static function searchShow()
    {
        echo '
        <div class="col-md-2"></div>
        <div class="col-md-4 col-sm-6 col-xs-12 search">
                <form style="color: #101010" method="post" action="group.php">
                    <input type="text" name="search" class="searchText">
                    <input type="submit" value="Szukaj">
                </form>
        </div>';
    }

    public static function filterShow()
    {
        echo '
        <div class="col-md-4 col-sm-6 col-xs-12 filter">
            <form style="color:black; margin-left: 79px" method="post" action="group.php">
                <select name="filter">
                    <option value="name">Nazwa</option>
                    <option value="price">Cena</option>
                    <option value="availability">Dostępność</option>
                </select>
                <input type="submit" value="Sortuj">
            </form>
        </div>
        <div class="col-md-2"></div>
        ';
    }

    public static function showProductGroup($groupId, mysqli $connection, $selection, $orderSelection)
    {
        $result = SqlQueries::selectGroup($groupId, $connection, $selection, $orderSelection);

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];

            $result = Carousel::getPhotoPath($connection, $id);

            foreach ($result as $value) {
                $path = '../' . $value['path'];
            }

            echo "<div class='col-md-6 col-sm-6 col-xs-12 productElement' >";
            echo "<div class='col-md-6 col-sm-12 col-xs-12 productPhotoElement'>";
            echo "<a href='product.php?id=$id'><img id='wtf' class='img-responsive'  src='$path'></a>";
            echo "</div>";
            echo "<div class='col-md-6 col-sm-12 col-xs-12 productPriceElement'>";
            echo "<p>" . $price . "zł.</p><p>" . $availability . " szt.</p>" . "<a href='../addItemToCart.php?name=$name&path=$path' class='btn btn-primary btn-block'>Do Koszyka</a>";
            echo "</div>";
            echo "<div class='col-md-12 col-sm-12 col-xs-12 productBuyElement' style='margin-bottom: 65px'>";
            echo "<h3>" . $name . "</h3>";
            echo "</div>";
            echo "</div>";
        }
    }

}