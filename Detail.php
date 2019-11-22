<?php
require 'inc/PHPprepare.php';


$remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}

//Query For Mahlzeit
$user_price_category = 'Gastpreis';
// left join damit Mahlzeiten ohne Bild auch rein kommen
$query = 'SELECT m.Beschreibung, m.Name, b.`Alt-Text`, b.Binärdaten, p.'.$user_price_category.' FROM Mahlzeiten m 
	LEFT JOIN MahlzeitenHatBilder mhb ON m.ID = mhb.`MID` 
	LEFT JOIN Bilder b ON mhb.BID = b.ID 
	JOIN Preise p ON m.ID = p.ID 

	WHERE p.Jahr = YEAR(NOW()) 
        AND m.ID = '.$_GET['id'].';'; // Achtung SQL injection. Nicht hinsehen! Schwere Augenschäden möglich
if (!($result = mysqli_query($remoteConnection, $query))) {
    var_dump(mysqli_error($remoteConnection));
    die('Query konnte nicht ausgeführt werden: Mahlzeiten');
}
$product = mysqli_fetch_assoc($result);
if ($product === NULL) {
    // redirect if product id invalid
    header('location: Produkte.php');
}

// Query for Zutaten
$query = 'SELECT z.ID, z.Name, z.Bio, z.Vegan,z.Vegetarisch, z.Glutenfrei FROM Zutaten z
        JOIN MahlzeitenEnthältZutaten mz ON mz.ZID = z.ID
        JOIN Mahlzeiten m ON m.ID = mz.MID
        WHERE m.ID = '.$_GET['id'].';';

if (!($result = mysqli_query($remoteConnection, $query))) {
    mysqli_error($remoteConnection);
    die('Query konnte nicht ausgeführt werden: Zutaten');
    return NULL;
}
$remoteConnection->close();

// convert into array ... who cares about performance
$zutaten = [];
while ($row = $result->fetch_assoc()) {
    $zutaten[] = $row;
}

echo $blade->run("pages.Detail", [
    'product' => $product,
    'zutaten' => $zutaten,
    'user_price_category' => $user_price_category
]);