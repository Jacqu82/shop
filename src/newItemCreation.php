<?php

include_once 'Item.php';

class newItemCreation
{
    public static function newFolder($path)
    {
        if (!file_exists($path)) {
            $dirMode = 0777;
            mkdir($path, $dirMode, true);
        }
    }

    public static function showEditItem($name, $description, $price, $availability)
    {

        // 3. Wyświtlamy formularz w którym wstawiamy wykorzystując gettery dane , które można edytować
        echo "<form action='editItem.php' method='post'>";
        //wyłączona opcja zmiany nazwy - do poprawki
//        echo "Edit the name for the <b>" . $name . " </b>item.<br>";
//        echo "<textarea rows='1' cols='50' name='name'>" . $name . "</textarea><br>";
        echo "Edit description for the <b>" . $name . "</b> item<br>";
        echo "<textarea rows='4' cols='50' name='description'>" . $description . "</textarea><br>";
        echo "Edit the price for the <b>" . $name . " </b>item.<br>";
        echo "<input name='price' type='text'  value= " . $price . "><br><br>";
        echo "Edit the availability for the <b>" . $name . " </b>item.<br>";
        echo "<input name='availability' type='text'  value= " . $availability . "><br><br>";
        echo "<input type='hidden' name='oldName' value=" . $name . ">";
        echo "<input type='submit' value='change'/>";
        echo "</form>";
        echo "<hr>";
    }

    public static function editPhoto($tab, Item $item)
    {
        // 5. Pętla przebiega 4 razy, ponieważ tyle można maksymalnie dodać zdjęć.
        for ($i = 0; $i < 4; $i++) {

            // 6. Jeśli są juz jakieś zdjęcia dodane do danego przedmiotu uruchomi się ten if
            if (isset($tab[$i][0])) {

                echo "<form action='#' method='post' enctype='multipart/form-data'>";

                $id = $item->getId();
                $path = $tab[$i][0]['path'];
                $_SESSION['path'] = $path;
                $photoId = $tab[$i][0]['id'];
                $itemId = $tab[$i][0]['item_id'];

                echo "<div class='photoBox'>";
                echo "<br>Zdjęcie nr " . ($i + 1) . "<br>";
                echo "<img src='" . $path . "' height='120' width='120'><br>";
                echo "Change | <a href='deletePhoto.php?photo_id=$photoId&id=$id'>Delete</a><br>";
                echo "<input type='file' name='file'><br>";
                echo "<input type='hidden' name='path' value=$path>";
                echo "<input type='hidden' name='photoId' value=$photoId>";
                echo "<input type='hidden' name='itemId' value=$itemId>";
                echo "<input type='submit' value='Add'/>";
                echo "</form></div>";

                //7. Jesli nie to uruchomi się ten else
            } else {
                echo "<form action='#' method='post' enctype='multipart/form-data'>";
                $fileNo = ($i + 1);
                $itemName = $item->getName();
                $_SESSION['name'] = $itemName;
                $itemId = $_SESSION['itemId'];
                echo "<br>Zdjęcie nr " . ($i + 1) . "<br>";
                echo "Brak załadowanego zdjęcia.<br>";
                echo "<input type='file' name='file'><br>";
                echo "<input type='hidden' name='number' value=$itemId>";
                echo "<input type='hidden' name='name' value=$itemName>";
                echo "<input type='hidden' name='fileNo' value=$fileNo>";
                echo "<input type='submit' value='Add'/>";
                echo "</form>";
            }
        }
    }
}