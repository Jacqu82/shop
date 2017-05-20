<?php

include_once 'connection.php';
require_once 'src/User.php';
include_once 'config.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";
echo "<p><a href='addNewItem.php'>Add new item</a></p>";
echo "<p>Show all items:</p>";

$connection = new mysqli($host, $user, $password, $database);

$sql = "SELECT * FROM groups";

$result = $connection->query($sql);

if (!$result) {
    die ("Error");
}

echo '<form action="#" method="post">';
echo '<p>Select  a group of items:</p>';
echo '<select name="selection">';
echo '<option value="all">All</option>';

foreach ($result as $value) {
    echo '<option value="' . $value['groupName'] . '">' . $value['groupName'] . '</option>';
}

echo '</select>
    <input type="submit" value="Show">
</form>';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['selection'])) {
        $selection = $_POST['selection'];
        echo "Items from group <b> " . $selection . ":</b><br>";

        if ($selection == 'all') {
            $sql = "SELECT * from groups g RIGHT JOIN item i ON i.group_id = g.id";
        } else {
            $sql = "SELECT * from groups g RIGHT JOIN item i ON i.group_id = g.id WHERE groupName='$selection'";
        }

        $result = $connection->query($sql);

        if (!$result) {
            die ("Error");
        }

        echo "<table border=1 cellpadding=5>";
        echo "<tr>";
        echo "<th>Name</th><th>Group name</th><th>description</th><th>Availability</th><th>Price</th><th>edit</th><th>delete</th>";
        echo "</tr>";
        foreach ($result as $value) {
            $id = $value['id'];
            echo "<tr>";
            echo "<td>" . $value['name'] . "</td><td>" . $value['groupName'] . "</td><td>" . $value['description'] . "</td>";
            echo "<td>" . $value['availability'] . "</td><td>" . $value['price'] . "</td>";
            echo "<td><a href='editItem.php?id=$id'>Edit</a></td>";
            echo "<td><a href='deleteItem.php?id=$id'>Delete</a></td></tr>";
        }

        echo "</table>";
    }
}
?>