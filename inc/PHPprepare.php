<?php
session_start();
require 'vendor/autoload.php';

global $dotenv;
$dotenv = Dotenv\Dotenv::create('./');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);

global $blade;
use eftec\bladeone\BladeOne;
$blade = new BladeOne();
