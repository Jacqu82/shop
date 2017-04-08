<?php

require_once 'config.php';

//$connection = new mysqli($host, $user, $password, $database);
$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($connection->connect_error) {
    die ("Connection error" . $connection->connect_error);
}

$connection->query('SET CHARACTER SET utf8');

