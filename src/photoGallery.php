<?php

class photoGallery
{
    public static function getGallery(mysqli $connection)
    {
        $sql = "SELECT * FROM groups";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Error - błąd połączenia z bazą danych" . $connection->error);
        }
        return $result;
    }

//    public static function showGroupName(mysqli $connection)
//    {
//        $result = self::getGallery($connection);
//
//        foreach ($result as $value) {
//            echo '<div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1">';
//            echo "<a href='../group.php?groupId=" . $value['id'] . "' class='btn btn-primary btn-block'>" . $value['groupName'] . "</a>";
//            echo '</div>';
//        }
//    }
}
