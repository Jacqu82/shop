<?php

class Carousel
{
    public static function getItemData(mysqli $connection)
    {
        $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1 ";

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na itemie" . $connection->error);
        }

        return $result;
    }

    public static function getPhotoPath(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM photos WHERE item_id = $id LIMIT 1";

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na photosie" . $connection->error);
        }

        return $result;
    }

    public static function parametersReceiver(mysqli $connection)
    {
        $result = self::getItemData($connection);

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];
            $description = $value['description'];
        }

        $result = self::getPhotoPath($connection, $id);

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

    public static function getHTML(mysqli $connection)
    {
        $result = self::parametersReceiver($connection);

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
}
