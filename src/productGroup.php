<?php
/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 16.05.17
 * Time: 23:21
 */

require_once 'Carousel.php';

class productGroup
{

    public static function selectGroup($groupId,$host, $user, $password, $database)
    {
        $connection = new mysqli($host, $user, $password, $database);
        $sql = "SELECT * FROM item WHERE group_id=$groupId";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych" . $connection->connect_error);
        }

        return $result;
    }

     public static function showProductGroup($groupId,$host, $user, $password, $database)
    {
        $result = self::selectGroup($groupId,$host, $user, $password, $database);

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];

            $result = Carousel::getPhotoPath($host, $user, $password, $database, $id);

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

    }

}