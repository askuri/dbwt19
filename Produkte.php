<?php include 'snippets/HTMLStart.php'; ?>
<?php include 'snippets/NavOben.php'; ?>

<?php
require 'inc/PHPprepare.php';
$remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}

// Bilder einfügen
$query =
        "INSERT INTO Bilder (`Alt-Text`, `Titel`, Binrdaten) ".
        "VALUES ('NoPic','NoTitle','".mysqli_real_escape_string($remoteConnection, file_get_contents('images/48x48fff.jpg'))."'); ";
mysqli_query($remoteConnection, $query);
for ($i = 1; $i <= 5; $i++) {
    $query = "INSERT INTO MahlzeitenHatBilder VALUES ($i, 1); ";
    mysqli_query($remoteConnection, $query);
}

$query = 'SELECT m.ID, m.Beschreibung, m.Vorrat, b.`Alt-Text`, b.Binrdaten, m.Name FROM Mahlzeiten m
	LEFT JOIN MahlzeitenHatBilder mhb ON m.ID = mhb.`MID` -- left join damit Mahlzeiten ohne Bild auch rein kommen
	LEFT JOIN Bilder b ON mhb.BID = b.ID';

if ($_GET['avail'] ?? false) {
    $query .= ' WHERE Vorrat > 0 ';
}
if ($_GET['limit'] ?? false) {
    $query .= ' LIMIT '. $_GET['limit'];
}

if (!($result = mysqli_query($remoteConnection, $query))) {
    echo mysqli_error($remoteConnection);
    die('Query konnte nicht ausgeführt werden');
}

$remoteConnection->close();
?>

<main>
    <header>
        <div class="row">
            <div class="col-3"></div>
            <div class="col"><h2>Verfügbare Speisen (Bestseller)</h2></div>
        </div>
    </header>

    <div class="row">
        <div class="col-3">
            <!-- Filter -->
            <aside>
                <fieldset class="form-group border p-2">
                    <legend class="col-form-label w-auto">Speiseliste filtern</legend>
                    <form method="post" action="#">
                        <div class="form-group">
                            <select class="form-control" id="sel1">
                                <option>Kategorien</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" value=""> nur verfügbare</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value=""> nur vegetarische</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value=""> nur vegane</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-light">Speisen filtern</button>
                    </form>
                </fieldset>
            </aside>
        </div>

        <!-- gallery -->
        <div class="col-7 text-center">
            <?php
            
            while (true) {
                echo '<div class="row">'; // start new row
                
                for ($x = 0; $x < 4; $x++) {
                    
                    $row = mysqli_fetch_assoc($result);
                    if (!$row) {
                        echo '</div>'; // end row
                        break 2; // break 2 loops
                    }
                    // TODO Beschreibung --
                    echo '<div class="col-3 thumbnail">
                        <img alt="'.$row['Alt-Text'].'" class="w-100"
                            src="data:image/jpeg;base64,'.base64_encode($row["Binrdaten"]).'">
                        <div class="caption">
                            '.$row['Name'].'<br>
                            <a href="Detail.php?id='.$row['ID'].'">Details</a>
                        </div>
                    </div>';
                }
                
                echo '</div>'; // end row
            }
            ?>
            <!-- Beispiele
            <div class="row">
                <div class="col-3 thumbnail">
                    <img alt="Curry Wok" class="w-100" src="https://dummyimage.com/200x200/0008a6/fff.png">
                    <div class="caption">
                        Curry Wok<br>
                        <a href="Detail.html">Details</a>
                    </div>
                </div>
                <div class="col-3 thumbnail">
                    <img alt="Food" class="img-thumbnail w-100" src="https://dummyimage.com/200x200/0008a6/fff.png">
                    <div class="caption text-muted">
                        Bratrolle<br>
                        <a href="Detail.html" class="btn-link disabled">Details</a>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</main>

<?php include 'snippets/NavUnten.php'; ?>
<?php include 'snippets/HTMLEnd.php'; ?>
