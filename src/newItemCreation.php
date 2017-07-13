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
        // Wyświetlamy formularz w którym wstawiamy wykorzystując gettery dane , które można edytować
        ?>
        <form action='editItem.php' method='post'>
            Edytuj nazwę dla <b><?php echo $name; ?></b><br>
            <textarea rows='1' cols='50' name='name'><?php echo $name; ?></textarea><br>
            Edytuj opis dla <b><?php echo $name; ?></b><br>
            <textarea rows='4' cols='50' name='description'><?php echo $description; ?></textarea><br>
            Edytuj cenę<br>
            <input name='price' type='text' value="<?php echo $price; ?>"><br><br>
            Edytuj dostępność<br>
            <input name='availability' type='text' value="<?php echo $availability ?>"><br><br>
            <input type='hidden' name='oldName' value="<?php echo $name; ?>">
            <input type='submit' value='Zmień'/>
        </form>
        <hr>
        <?php
    }

    public static function editPhoto($tab, Item $item)
    {
        // 2. Pętla przebiega 4 razy, ponieważ tyle można maksymalnie dodać zdjęć.
        for ($i = 0; $i < 4; $i++) {

            // 3. Jeśli są juz jakieś zdjęcia dodane do danego przedmiotu uruchomi się ten if
            if (isset($tab[$i][0])) {
                ?>
                <form action='#' method='post' enctype='multipart/form-data'>
                    <?php
                    $id = $item->getId();
                    $path = '../../' . $tab[$i][0]['path'];
                    $_SESSION['path'] = $path;
                    $photoId = $tab[$i][0]['id'];
                    $itemId = $tab[$i][0]['item_id'];
                    ?>
                    <div class='photoBox'>
                        <br>Zdjęcie nr <?php echo($i + 1); ?><br>
                        <img src='<?php echo $path; ?>' height='120' width='120'><br>
                        <?php
                        echo "Zmień | <a href='deletePhoto.php?photo_id=$photoId&id=$id'>Skasuj</a><br>";
                        ?>
                        <input type='file' name='file'><br>
                        <input type='hidden' name='path' value='<?php echo $path; ?>'>
                        <input type='hidden' name='photoId' value='<?php echo $photoId; ?>'>
                        <input type='hidden' name='itemId' value='<?php echo $itemId; ?>'>
                        <input type='submit' value='Dodaj'/>
                    </div>
                </form>
                <?php
                //4. Jesli nie to uruchomi się ten else
            } else {
                ?>
                <form action='#' method='post' enctype='multipart/form-data'>
                    <?php
                    $fileNo = ($i + 1);
                    $itemName = $item->getName();
                    $_SESSION['name'] = $itemName;
                    $itemId = $_SESSION['itemId'];
                    ?>
                    <br>Zdjęcie nr <?php echo $fileNo; ?><br>
                    Brak załadowanego zdjęcia.<br>
                    <input type='file' name='file'><br>
                    <input type='hidden' name='number' value='<?php echo $itemId; ?>'>
                    <input type='hidden' name='name' value='<?php echo $itemName; ?>'>
                    <input type='hidden' name='fileNo' value='<?php echo $fileNo; ?>'>
                    <input type='submit' value='Add'/>
                </form>
                <?php
            }
        }
    }
}
