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
            <script src="../js/style.js?s3=2132317" type="text/javascript"></script>
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
        $result = photoGallery::getGallery($connection);

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
}