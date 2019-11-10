<?php
require 'inc/PHPprepare.php';
$remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}

$query = 'SELECT * FROM Mahlzeiten m
	JOIN Preise p ON m.ID = p.ID
	WHERE p.Jahr = YEAR(NOW())
        AND m.id = '.$_GET['id'].';'; // Achtung SQL injection. Nicht hinsehen! Schwere Augenschäden möglich
if (!($result = mysqli_query($remoteConnection, $query))) {
    die('Query konnte nicht ausgeführt werden');
}

$product = mysqli_fetch_assoc($result);

if ($product === NULL) {
    // redirect if product id invalid
    header('location: Produkte.php');
}

// nicht nach oben ziehen wegen header()
include 'snippets/HTMLStart.php';
include 'snippets/NavOben.php';
?>
<main>
    <header>
        <div class="row">
            <div class="col-3"></div> <!-- TODO Beschreibung?! -->
            <div class="col"><h2>Details für "<?=$product['Beschreibung']?>"</h2></div>
        </div>
    </header>

    <div class="row">
        <!-- login -->
        <div class="col-3">
            <aside>
                <fieldset class="form-group border p-2">
                    <legend class="col-form-label w-auto">Login</legend>
                    <form method="post" action="#">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm" id="inputUser" placeholder="Benutzer">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-sm" id="inputPassword" placeholder="******">
                        </div>
                        <button type="submit" class="btn btn-link">Anmelden</button>
                    </form>
                </fieldset>
            </aside>
        </div>

        <!-- detail image -->
        <div class="col-7">
            <img class="w-100" src="https://dummyimage.com/600x200/6b6b6b/0011ff" alt="Ein Dummy Image">
        </div>

        <!-- price and order -->
        <div class="col-2 text-right">
            <div class="row h-50">
                <div class="col">
                    <p class="mb-0"><strong>Gast</strong>-Preis</p>
                    <p class="mb-0 h3"><strong><?=$product['Gastpreis']?></strong></p>
                </div>
            </div>
            <div class="row align-items-end h-50">
                <div class="col">
                    <a href="#" class="shadow border border-secondary btn btn-light"><i class="fa fa-cutlery"></i> Vorbestellen</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- sidebar -->
        <div class="col-3">
            <aside>
                <p>
                    Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise
                    für Mitarbeiter oder Studenten zu sehen
                </p>
            </aside>
        </div>

        <!-- content box with nav header -->
        <div class="col-7">
            <!-- page selector -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" id="beschreibung-tab">
                    <a class="nav-link active" data-toggle="tab" href="#beschreibung" role="tab" aria-controls="beschreibung" aria-selected="true">Beschreibung</a>
                </li>
                <li class="nav-item" id="zutaten-tab">
                    <a class="nav-link" data-toggle="tab" href="#zutaten" role="tab" aria-controls="zutaten" aria-selected="false">Zutaten</a>
                </li>
                <li class="nav-item" id="bewertung-tab">
                    <a class="nav-link" data-toggle="tab" href="#bewertungen" role="tab" aria-controls="bewertungen" aria-selected="false">Bewertungen</a>
                </li>
            </ul>

            <!-- below the page selector -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="beschreibung" role="tabpanel" aria-labelledby="beschreibung-tab">
                    <?=$product['Beschreibung']?>
                </div>
                <div class="tab-pane fade" id="zutaten" role="tabpanel" aria-labelledby="zutaten-tab">
                    Blaukraut bleibt Blaukraut und Brautkleid bleibt Brautkleid
                </div>

                <!-- Mahlzeit-Bewertung -->
                <div class="tab-pane fade" id="bewertungen" role="tabpanel" aria-labelledby="bewertung-tab">
                    <form action="http://bc5.m2c-lab.fh-aachen.de/form.php" method="post">
                    <input type="hidden"  name="matrikel" value="3188047"> 
                    <input type="hidden"  name="kontrolle" value="Kip"> 
                    <div class="form-group row justify-content-center">
                        <label for="bewertung_mahlzeit" class="col-6 col-form-label text-right">Mahlzeit</label>
                        <div class="col-6">
                            <select id="bewertung_mahlzeit" class="form-control" name="mahlzeit">
                                <option selected value="Falafel">Falafel</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="bewertung_user" class="col-6 col-form-label text-right">Benutzername</label>
                        <div class="col-6">
                            <input required type="text" name="benutzer" class="form-control" id="bewertung_user" placeholder="Max Mustermann">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rating_rating" class="col-6 col-form-label text-right">Bewertung</label>
                        <div class="col-6">
                            <input type="number" min="0" max="5" name="bewertung" id="rating_rating"  step="1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bewertung_bemerkung" class="col-6 col-form-label text-right">Bemerkung</label>
                        <div class="col-6">
                            <textarea cols="15" id="bewertung_bemerkung" name="Bemerkung" rows="4">
                                Geben Sie eine Bemerkung ein, wenn Sie möchten...
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6"></div>
                        <div class="col-6">
                        <button type="submit" class="btn btn-link">Bewertung absenden <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'snippets/NavUnten.php'; ?>
<?php include 'snippets/HTMLEnd.php'; ?>