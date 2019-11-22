<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create('./');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);
