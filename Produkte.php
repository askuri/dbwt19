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
	LEFT JOIN Bilder b ON mhb.BID = b.ID ';

function categoryIsSet(){
    return isset($_GET['category']) && !($_GET['category'] == 'all');
}

if (isset($_GET['avail']) || categoryIsSet() || isset($_GET['vegan']) || isset($_GET['veget'])){
    $query .= ' WHERE ';
}
$needsLogicalOperator = false;

$showOnlyAvailable = false;
if ($_GET['avail'] ?? false) {
    $query .= 'Vorrat > 0 ';
    $showOnlyAvailable = true;
    $needsLogicalOperator = true;
}

$showOnlyVeget = false;
if ($_GET['veget'] ?? false) {
    $showOnlyVeget = true;

    if($needsLogicalOperator){
        $query .= 'AND ';
    }
    //Mahlzeiten having no ingredients are also vegetarian... 
    $query .= 'TRUE = ALL(SELECT z.Vegetarisch FROM Zutaten z
               JOIN MahlzeitenEnthältZutaten mEz on mEz.ZID = z.ID
               WHERE mEz.MID = m.ID) ';

    $needsLogicalOperator = true;
}

$showOnlyVegan = false;
if ($_GET['vegan'] ?? false) {
    $showOnlyVegan = true;
    if($needsLogicalOperator){
        $query .= 'AND ';
    }
    //Mahlzeiten having no ingredients are also vegan... 
    $query .= 'TRUE = ALL(SELECT z.Vegan FROM Zutaten z
               JOIN MahlzeitenEnthältZutaten mEz on mEz.ZID = z.ID
               WHERE mEz.MID = m.ID) ';

    $needsLogicalOperator = true;
}

if(categoryIsSet()){
    if($needsLogicalOperator){
        $query.= 'AND ';
    }
    $query .= 'm.KategorieID = '.$_GET['category'].' ';

    $needsLogicalOperator = true;
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

$selectedID = -1;
if(categoryIsSet()){
    $selectedID = $_GET['category'];
}
$selectedCategoryName = 'Bestseller';
if(categoryIsSet()){
    foreach($categoryList as $entr){
        if($entr['ID'] == $_GET['category']){
            $selectedCategoryName = $entr['Bezeichnung'];
        }
    }
}
if(mysqli_num_rows($result) == 0){
    $selectedCategoryName = 'Keine Ergebnisse';
}


$remoteConnection->close();
echo $blade->run("pages.Produkte", [
    'mealResult' => $result,
    'categoryList' => $categoryList,
    'selectedID' => $selectedID,
    'selectedCategoryName' => $selectedCategoryName,
    'isOnlyAvailableSelected' => $showOnlyAvailable,
    'isVegetSelected' => $showOnlyVeget,
    'isVeganSelected' => $showOnlyVegan
]);
