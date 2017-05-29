<?php

require_once 'autoload.php';

/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 29.05.17
 * Time: 23:09
 */
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
}