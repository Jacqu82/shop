<?php

include_once 'config.php';

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die ("Connection error" . $connection->connect_errno);
}

$connection->query('SET CHARACTER SET utf8');
