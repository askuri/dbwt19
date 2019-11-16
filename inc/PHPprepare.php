<?php
require 'vendor/autoload.php';

//TODO Change to correct path
// $dotenv = Dotenv\Dotenv::create('/home/martin/NetBeansProjects/dbwt19');
$dotenv = Dotenv\Dotenv::create('/home/leonhard/Code/dbwt19');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);
