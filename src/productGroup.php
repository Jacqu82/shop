<?php

require_once 'Carousel.php';

class productGroup
{

    public static function selectGroup($groupId, mysqli $connection, $selection, $orderSelection)
    {
        $sql = "SELECT * FROM item WHERE group_id=$groupId AND name LIKE '%$selection%' ORDER BY $orderSelection";
        $result = $connection->query($sql);

        if (!$result) {
            die ("Błąd połączenia z bazą danych selectgrup" . $connection->connect_error);
        }

        return $result;
    }

    public static function showProductGroup($groupId, mysqli $connection, $selection, $orderSelection)
    {
        $result = self::selectGroup($groupId, $connection, $selection, $orderSelection);

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];

            $result = Carousel::getPhotoPath($connection, $id);

            foreach ($result as $value) {
                $path = $value['path'];
            }

            echo "<div class='col-md-6 col-sm-6 col-xs-12 productElement' >";
            echo "<div class='col-md-6 col-sm-12 col-xs-12 productPhotoElement'>";
            echo "<a href='product.php?id=$id'><img id='wtf' class='img-responsive'  src='$path'></a>";
            echo "</div>";
            echo "<div class='col-md-6 col-sm-12 col-xs-12 productPriceElement'>";
            echo "<p>" . $price . "zł.</p><p>" . $availability . " szt.</p>" . "<a href='addItemToCart.php?name=$name&path=$path' class='btn btn-primary btn-block'>Do Koszyka</a>";
            echo "</div>";
            echo "<div class='col-md-12 col-sm-12 col-xs-12 productBuyElement' style='margin-bottom: 65px'>";
            echo "<h3>" . $name . "</h3>";
            echo "</div>";
            echo "</div>";
        }
    }
}
