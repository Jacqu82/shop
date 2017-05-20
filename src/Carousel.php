<?php

/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 14.05.17
 * Time: 12:40
 */
class Carousel
{
    public static function getItemData($host, $user, $password, $database)
    {
        $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1 ";

        $connection = new mysqli($host, $user, $password, $database);

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na itemie" . $connection->error);
        }

        return $result;
    }

    public static function getPhotoPath($host, $user, $password, $database, $id)
    {
        $sql = "SELECT * FROM photos WHERE item_id = $id LIMIT 1";

        $connection = new mysqli($host, $user, $password, $database);

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na photosie" . $connection->error);
        }

        return $result;
    }

    public static function parametersReceiver($host, $user, $password, $database)
    {
        $result = self::getItemData($host, $user, $password, $database);

        foreach ($result as $value) {
            $id = $value['id'];
            $name = $value['name'];
            $price = $value['price'];
            $availability = $value['availability'];
            $description = $value['description'];
        }

        $result = self::getPhotoPath($host, $user, $password, $database, $id);

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

    public static function getHTML($host, $user, $password, $database)
    {
        $result = self::parametersReceiver($host, $user, $password, $database);

        $id = ($result['id']);

        echo "  <div class='carousel-caption'>
                    <a href='product.php?id=" . $id . "'>
                        <img id='wtf' class='img-responsive' src='" . $result['path'] . "'>
                    </a>
                    <div id='inner1'>
                        <span style='padding-right: 10px'>Cena:</span>
                        <span style='color: red; font-size: 110%'>" . $result['price'] . " zł." . "</span><br>
                        <b><span style='font-size: 110%'>" . $result['name'] . "</span></b>
                    </div>
                </div>";
    }

}


