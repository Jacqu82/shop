<?php
/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 17.05.17
 * Time: 23:19
 */

class dbEdit
{
    public static function delete($connection, $photoId)
    {
        $sql = "DELETE FROM photos WHERE id=$photoId";

        $result = $connection->query($sql);

        if (!$result) {
            die("Nie udało się usunąć zdjęcia z bazy danych!");
        }
    }

    public static function insert($connection, $itemId, $path)
    {
        $sql = "INSERT INTO photos (`item_id`, `path`) VALUES('$itemId', '$path')";

        $result = $connection->query($sql);

        if (!$result) {
            die("Nie udało się zapisać zdjęcia do bazy danych!");
        }
    }
}