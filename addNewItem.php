<?php
include_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Item.php';
include_once 'config.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');      
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";

?>

<html>
    <head>
        <title>adding Group of Products</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form action="#" method="post" enctype="multipart/form-data">
            Enter item name:<br>
            <input type="text" name="name"/><br>            
            Select group of products or create <a href="addGroupOfProducts.php">new group:</a><br>
            <?php
            
            //wybieramy z listy rozwijalnej grupę produktów do której dodamy przedmiot
            
                //$connection = new mysqli($host, $user, $password, $database);

                $sql = "SELECT * FROM groups";

                $result = $connection->query($sql);

                if (!$result) {
                    die ("Error");
                }
                echo '<select name="selection">';

                foreach ($result as $value) {
                   echo '<option value="' . $value['id'] . '">' . $value['groupName'] . '</option>';
                }
                echo '</select>';
            ?>
            <br>
            Enter item description:<br>
            <textarea rows='4' cols='50' name='description'></textarea><br>
            Enter item price<br>
            <input type="text" name="price"/><br>
            Enter item availability:<br>
            <input type="text" name="availability"/><br>
            Add picture:<br>
            <input type="file" name="file1"/><br>
            Add picture:<br>
            <input type="file" name="file2"/><br>
            Add picture:<br>
            <input type="file" name="file3"/><br>
            Add picture:<br>
            <input type="file" name="file4"/><br>
            <input type="submit" value="Add"/>
        </form>
    </body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['selection']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['availability'])) {

        //przypisujemy wszystkie dane z formularza do zmiennych
        
        $name = $_POST['name'];
        $selection = $_POST['selection'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];

        //tworzymy obiekt typu Item i ustawiamy setery zmiennymi otrzymanymiz formularza
        
        $item = new Item();
        $item->setName($name);
        $item->setAvailability($availability);
        $item->setDescription($description);
        $item->setGroup($selection);
        $item->setPrice($price);
        
        $connection = new mysqli($host, $user, $password, $database);
        
        $item->save($connection);
        
        $id = $item->getId();
        
        //tworze folder z id pliku a nastepnie z jego nazwą
        
        $path = "files/" . $id . $name;
        
        if (!file_exists($path)) {
            $dirMode = 0777;
            mkdir($path, $dirMode, true);
        }      
               
        //w ten dziwny sposób okreslam ile zdjęć zostało załadowanych - wartość tą wykoprzystam w pętli
        
        if ($_FILES['file2']['size'] == 0) {
            $flag = 1;
        } else if ($_FILES['file3']['size'] == 0) {
            $flag = 2;
        } else if ($_FILES['file4']['size'] == 0) {
            $flag = 3;
        } else {
            $flag = 4;
        }


        for ($i = 0; $i < $flag; $i++) {
            
            //strasznie rozbudowane, ale w każdym ifie sprawdzam z którym plikiem pracuję a następnie wyszukuje końcówki pliku
            
            if ($i == 0) {
                $fileNo = 'file1';
                $fileName = $_FILES['file1']['name'];
                preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                $ending = $matches[0];
            } else if ($i == 1) {
                $fileNo = 'file2';
                $fileName = $_FILES['file2']['name'];
                preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                $ending = $matches[0];
            } else if ($i == 2) {
                $fileNo = 'file3';
                $fileName = $_FILES['file3']['name'];
                preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                $ending = $matches[0];
            } else {
                $fileNo = 'file4';
                $fileName = $_FILES['file4']['name'];
                preg_match('~[\.][a-zA-Z]+~', $fileName, $matches);
                $ending = $matches[0];
            } 
            
            //przy każdej iteracji resetuje zmiane sciezki dostepu do ustawien poczatkowych
            $path = "files/" . $id . $name;
            
            //nastepnie zmieniam nazwe elementu na liczbe porzadkowa + nazwe przedmiotu + koncowka odpowiednia
            
            $_FILES[$i]['name'] = $i+1 . "_" . $name . $ending; 
            $path = $path . "/" . $_FILES[$i]['name'];
            
            $sql = "INSERT INTO photos (`item_id`, `path`) VALUES ('$id', '$path')";
            $result = $connection->query($sql);
            
            if (!$result) {
                die ("Error - couldn't add photos to database");
            }
     
            move_uploaded_file($_FILES[$fileNo]['tmp_name'], $path);
        }

        header('Location: itemPanel.php');
    }
}