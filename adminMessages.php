<?php

include_once 'connection.php';
include_once 'config.php';
require_once 'autoload.php';

Message::showAllMEssages($connection);