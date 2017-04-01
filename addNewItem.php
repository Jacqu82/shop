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
                $connection = new mysqli($host, $user, $password, $database);

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

        $name = $_POST['name'];
        $selection = $_POST['selection'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];

        $item = new Item();
        $item->setName($name);
        $item->setAvailability($availability);
        $item->setDescription($description);
        $item->setGroup($selection);
        $item->setPrice($price);
        
        $connection = new mysqli($host, $user, $password, $database);
        
        $item->save($connection);
        
        $id = $item->getId();
        
        $path = "files/" . $id . $name;
        
        if (!file_exists($path)) {
            mkdir($path);
        }

        for ($i = 0; $i != 4; $i++) {
            $_FILES[$i]['name'] = $i+1 . "_" . $name; 
            echo $_FILES[$i]['name'] . "<br>";
            $path = $path . "/" . $_FILES[$i]['name'];
            move_uploaded_file($_FILES[$i]['name'], $path);
        }

//        header('Location: itemPanel.php');
    }
}