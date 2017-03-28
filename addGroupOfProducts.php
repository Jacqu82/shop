<?php

include_once 'connection.php';
require_once 'src/User.php';
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
        <form action="addGroupOfProducts.php" method="post">
            Enter group name:<br>
            <input type="text" name="name"/><br>            
            Enter group description:<br>
            <input type="text" name="description"/>
            <br>
            <input type="submit" value="Add"/>
        </form>
    </body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['name']) && isset($_POST['description'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        
        $sql = "INSERT INTO groups (`groupName`, `groupDescriptiopn`) VALUES ('$name', '$description')";
        $connection = new mysqli($host, $user, $password, $database);
        $result = $connection->query($sql);
        
        if (!$result) {
            die ("error" . $connection->connect_error);
        }
        
        echo "A new group of products <b>" . $name . "</b> has been added<br>";
        echo "<a href='adminPanel.php'>Return to admin panel</a><br>";
        echo "<a href='groupsOfProducts.php'>Return to Group of products options</a><br>";
    }
}



?>