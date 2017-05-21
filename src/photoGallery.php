<?php
/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 15.05.17
 * Time: 23:17
 */

class photoGallery
{
    public static function getGallery($host, $user, $password, $database)
    {
        $connection = new mysqli($host, $user, $password, $database);
        $sql = "SELECT * FROM groups";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Error - błąd połączenia z bazą danych" . $connection->error);
        }
        return $result;
    }

    public  static function showGroupName($host, $user, $password, $database)
    {
        $result = self::getGallery($host, $user, $password, $database);

        foreach ($result as $value) {
            echo '<div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1">';
            echo "<a href='group.php?groupId=" . $value['id'] . "' class='btn btn-primary btn-block'>" . $value['groupName'] . "</a>";
            echo '</div>';
        }


    }
}

//