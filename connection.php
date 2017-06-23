<?php

require_once 'config.php';

//$connection = new mysqli($host, $user, $password, $database);
$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die ("Connection error" . $connection->connect_error);
}

$connection->query('SET CHARACTER SET utf8');
