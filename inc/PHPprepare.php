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

function connectToDB(){
    $remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
    if (mysqli_connect_errno()) {
        printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
        die();
    }
    return $remoteConnection;
}
