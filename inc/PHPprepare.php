<?php
session_start();
require 'vendor/autoload.php';
use eftec\bladeone\BladeOne;

$dotenv = Dotenv\Dotenv::create('./');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);

$blade = new BladeOne(); 
