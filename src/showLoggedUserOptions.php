<?php

require_once 'autoload.php';

class showLoggedUserOptions
{
    static public function showAllOptions($connection)
    {
        $id = $_SESSION['id'];

        echo '<div class="row" id="topMenu">';
        echo '<div class="col-md-2 col-sm-3 col-xs-3 witaj row1">';
        echo '<a href="userPanel.php" class="btn btn-primary btn-block">' . $_SESSION['user'];
        echo '<span class="glyphicon glyphicon-envelope" style="margin-top: 2px"></span>';
        echo '<span style="padding-left: 4px">';
        Message::getUnreadMessage($connection, $id);
        echo '</span>';
        echo '</a>';
        echo '</div>';
        echo '<div class="col-md-2 col-sm-3 col-xs-3 rejestracja row1">';
        echo '<a href="web/logOut.php" class="btn btn-primary btn-block">Wyloguj</a>';
        echo '</div>';
        echo '<div class="col-md-2 col-sm-3 col-xs-3 col-md-offset-6 col-sm-offset-3 koszyk row1">';
        echo '<a href="koszyk.php" class="btn btn-success btn-block">Koszyk</a>';
        echo "</div>";
        echo "</div>";

    }

    //metoda sprawdzająca czy użytkownik jest zalogowany
    static public function showAllOptionsIndex($connection)
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $id = $_SESSION['id'];
            echo '<div class="row" id="topMenu">';
            echo '<div class="col-md-2 col-sm-3 col-xs-3 witaj row1">';
            echo '<a href="userPanel.php" class="btn btn-primary btn-block">' . $_SESSION['user'];
            echo '<span class="glyphicon glyphicon-envelope" style="margin-top: 2px"></span>';
            echo '<span style="padding-left: 4px">';
            Message::getUnreadMessage($connection, $id);
            echo '</span>';
            echo '</a>';
            echo '</div>';
            echo '<div class="col-md-2 col-sm-3 col-xs-3 rejestracja row1">';
            echo '<a href="web/logOut.php" class="btn btn-primary btn-block">Wyloguj</a>';
            echo '</div>';
            echo '<div class="col-md-2 col-sm-3 col-xs-3 col-md-offset-6 col-sm-offset-3 koszyk row1">';
            echo '<a href="koszyk.php" class="btn btn-success btn-block">Koszyk</a>';
            echo "</div>";
            echo "</div>";
        } else {
            echo '
        <div class="row" id="topMenu">
            <div class="col-md-2 col-sm-3 col-xs-4 witaj row1">
                <a href="web/loginForm.html" class="btn btn-primary btn-block">Logowanie</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4 rejestracja row1">
                <a href="web/registerForm.html" class="btn btn-primary btn-block">Rejestracja</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4 col-md-offset-6 col-sm-offset-3 koszyk row1">
                <a href="koszyk.php" class="btn btn-success disabled btn-block">Koszyk</a>
            </div>
        </div>';
        }
    }
}
