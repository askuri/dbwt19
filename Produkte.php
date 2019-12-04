<?php
require_once 'inc/PHPprepare.php';

// Bilder einfügen
$remoteConnection = connectToDB();
$query =
        "INSERT INTO Bilder (`Alt-Text`, `Titel`, Binärdaten) ".
        "VALUES ('NoPic','NoTitle','".mysqli_real_escape_string($remoteConnection, file_get_contents('images/48x48fff.jpg'))."'); ";
mysqli_query($remoteConnection, $query);
for ($i = 1; $i <= 5; $i++) {
    $query = "INSERT INTO MahlzeitenHatBilder VALUES ($i, 1); ";
    mysqli_query($remoteConnection, $query);
}
$remoteConnection->close();






function getCategoryID(){
    return isset($_GET['category']) && !($_GET['category'] == 'all') ?
        $_GET['category']
        : false;
}
require './controllers/ProdukteController.php';
use \Emensa\Controller;
$controller = new \Emensa\Controller\ProdukteController();
echo $controller->getView(
    $_GET['avail'] ?? false,
    $_GET['vegan'] ?? false,
    $_GET['veget'] ?? false,
    getCategoryID(),
    $_GET['limit'] ?? false
);

