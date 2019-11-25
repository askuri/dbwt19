<?php
require 'inc/PHPprepare.php';
$remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}

// Bilder einfügen
$query =
        "INSERT INTO Bilder (`Alt-Text`, `Titel`, Binärdaten) ".
        "VALUES ('NoPic','NoTitle','".mysqli_real_escape_string($remoteConnection, file_get_contents('images/48x48fff.jpg'))."'); ";
mysqli_query($remoteConnection, $query);
for ($i = 1; $i <= 5; $i++) {
    $query = "INSERT INTO MahlzeitenHatBilder VALUES ($i, 1); ";
    mysqli_query($remoteConnection, $query);
}

$query = 'SELECT m.ID, m.Beschreibung, m.Vorrat, b.`Alt-Text`, b.Binärdaten, m.Name FROM Mahlzeiten m
	LEFT JOIN MahlzeitenHatBilder mhb ON m.ID = mhb.`MID` -- left join damit Mahlzeiten ohne Bild auch rein kommen
	LEFT JOIN Bilder b ON mhb.BID = b.ID';

function categoryIsSet(){
    return isset($_GET['category']) && !($_GET['category'] == 'all');
}

if (isset($_GET['avail']) || categoryIsSet()){
    $query .= ' WHERE ';
}
if ($_GET['avail'] ?? false) {
    $query .= 'Vorrat > 0 ';
}

//BUT HERE IT DOES THIS IS BS EXTREME
if(categoryIsSet()){
    if($_GET['avail'] ?? false){
        $query.= 'AND ';
    }
    $query .= 'm.KategorieID = '.$_GET['category'];
}

if ($_GET['limit'] ?? false) {
    $query .= ' LIMIT '. $_GET['limit'];
}

if (!($result = mysqli_query($remoteConnection, $query))) {
    echo mysqli_error($remoteConnection);
    die('Query konnte nicht ausgeführt werden');
}

$category_query = 'SELECT k.ID, k.Bezeichnung, k.hat FROM Kategorien k
            ORDER BY CASE WHEN k.hat IS NULL THEN k.ID ELSE k.hat END, k.hat';
if (!($category_result = mysqli_query($remoteConnection, $category_query))) {
    echo mysqli_error($remoteConnection);
    die('Query konnte nicht ausgeführt werden');
}

$categoryList = [];
while ($row = mysqli_fetch_assoc($category_result)) {
    $categoryList[] = $row;
}

$remoteConnection->close();
$selectedID = -1;
if(categoryIsSet()){
    //FOR SOME FUCKNG REASON categoryIsSet evaluates to false
    //ABSOLUTLY UNDEBUGABLE 
    $selected = $_GET['category'];
    $selected = 5;
}
echo $blade->run("pages.Produkte", [
    'mealResult' => $result,
    'categoryList' => $categoryList,
    'selectedID' => $selectedID
]);
