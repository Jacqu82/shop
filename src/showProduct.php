<?php
/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 17.05.17
 * Time: 06:39
 */

require_once 'Carousel.php';

class showProduct
{
    public static function getItem(mysqli $connection, $id)
    {

        $sql = "SELECT * FROM item WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd połączenia z bazą danych" . $connection->connect_error);
        }

        return $result;
    }

    public static function getPhotoPath(mysqli $connection, $id)
    {
        $sql = "SELECT * FROM photos WHERE item_id = $id";

        $result = $connection->query($sql);

        if (!$result) {
            die("Error na photosie" . $connection->error);
        }

        return $result;
    }

    public static function getAllData(mysqli $connection, $id)
    {
        $result = self::getItem($connection, $id);

        foreach ($result as $value) {
            $name = $value['name'];
            $price = $value['price'];
            $description = $value['description'];
            $availability = $value['availability'];
        }

        $array = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'availability' => $availability,
            'description' => $description
        ];

        return $array;

    }

    public static function getAllPhotos(mysqli $connection, $id)
    {
        $result = self::getPhotoPath($connection, $id);

        $paths = [0 => '', 1 => '', 2 => '', 3 => ''];
        $i = 0;

        foreach ($result as $value) {
            $paths[$i] = $value['path'];
            $i++;
        }

        for ($i = 0; $i != 4; $i++) {
            if ($paths[$i] == '') {
                $paths[$i] = $paths[$i - 1];
            }
        }

        return $paths;
    }

    public static function showAllPhotos(mysqli $connection, $id)
    {
        $result = self::getAllData($connection, $id);
        $itemName = $result['name'];
        $paths = self::getAllPhotos($connection, $id);
        $path = $paths[0];

        echo "
            <div class='col-md-8 tresc col-sm-8 col-xs-6'>
                <div id='photoSpace' class='col-md-6 col-sm-6 col-xs-12'>
                    <img id='mainPhoto' class='img-responsive' src='" . $paths[0] . "' style='border: solid 2px red'>
                    <div id='smallPhotos' class='col-md-12 col-sm-12 col-xs-12' style='position: relative; left: -0.5em ;top: 0.25em'>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='firstThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[0] . "' style='border: solid 2px red'></a>
                        </div>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='secondThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[1] . "' style='border: solid 2px red'></a>
                        </div>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='secondThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[2] . "' style='border: solid 2px red'></a>
                        </div>
                        <div class='col-xs-3 col-sm-6 col-md-3' id='secondThumb'>
                            <a><img id='hej' class='img-thumbnail1' src='" . $paths[3] . "' style='border: solid 2px red'></a>
                        </div>
                    </div>
                </div>
                <div id='priceSpace' class='col-md-6 col-sm-6 col-xs-12' >
                    <h2>" . $result['name'] . "</h2>
                    <div class='col-md-6 col-sm-6 col-xs-6'><h3>Cena:</h3><h3>Dostepny:</h3></div>
                    <div class='col-md-6 col-sm-6 col-xs-6'>
                        <h3>" . $result['price'] . "zł.</h3>
                        <h3>" . $result['availability'] . " szt.</h3>
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12'>
                        <a href='addItemToCart.php?name=$itemName&path=$path' class='btn btn-success btn-block'>Do Koszyka</a>
                    </div>
                </div>
                <div id='descriptionSpace' class='col-md-12 col-sm-12 col-xs-12'>
                    <p style='padding-top: 30px; font-size: 1.3em'>" . $result['description'] . "</p>
                </div>
            </div>";
    }
}