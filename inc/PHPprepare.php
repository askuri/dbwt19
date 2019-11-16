</?php
/*
 * Preparing the environment
 */

require 'vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::create('/home/martin/NetBeansProjects/dbwt19');
$dotenv = Dotenv\Dotenv::create('/home/leonhard/Documents/Informatik/dbwt/.env');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);
