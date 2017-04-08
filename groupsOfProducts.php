<?php

include_once 'connection.php';
require_once 'src/User.php';
include_once 'config.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');      
}

echo "Hello " . $_SESSION['admin'] . " | " . "<a href='index.php'>Start</a>" . " | " . "<a href='logOut.php'>wyloguj</a><hr>";
echo "<p><a href='addGroupOfProducts.php'>Add new group of items</a></p>";

$sql = "SELECT * FROM groups";

$connection = new mysqli($host, $user, $password, $database);

$result = $connection->query($sql);

if(!$result) {
    die("Error" . $connection->connect_error);
}

echo "<table border=1 cellpadding=5>";
echo "<tr>";
echo "<th>id</th><th>group name</th><th>group description</th><th>edit</th><th>delete</th>";
echo "</tr>";
foreach ($result as $value) {
    $id = $value['id'];
    echo "<tr>";
    echo "<td>" . $value['id'] . "</td><td>" . $value['groupName'] . "</td><td>" . $value['groupDescriptiopn'] . "</td>";
    echo "<td><a href='editGroupOfProducts.php?id=$id'>Edit</a></td>";
    echo "<td><a href='deleteGroupOfProducts.php?id=$id'>Delete</a></td></tr>";
}

echo "</table>";






