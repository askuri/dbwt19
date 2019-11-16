<?php
require 'inc/PHPprepare.php';
require 'inc/PopulateZutatenTable.php';


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


include 'snippets/HTMLStart.php';
include 'snippets/NavOben.php';
?>
<h2>Zutatenliste (<?=$result->num_rows ?>)</h2>
<main>
            <?php
include 'snippets/ZutatenTableHead.php';
populateZutatenTable($result);
include 'snippets/CloseTable.php';
            ?>
</main>

<?php include 'snippets/NavUnten.php'; ?>
<?php include 'snippets/HTMLEnd.php'; ?>

