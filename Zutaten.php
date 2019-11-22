<?php
require 'inc/PHPprepare.php';


$remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}

$query = 'SELECT * FROM Zutaten ORDER BY Bio DESC;';
if (!($result = mysqli_query($remoteConnection, $query))) {
    die('Query konnte nicht ausgeführt werden');
}
$remoteConnection->close();

$zutatenListe = [];
while ($row = mysqli_fetch_assoc($result)) {
    $zutatenListe[] = $row;
}

echo $blade->run("pages.Zutaten",  [
    'num_rows' => $result->num_rows,
    'zliste' => $zutatenListe
]);