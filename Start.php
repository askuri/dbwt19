<?php include 'snippets/HTMLStart.php'; ?>
<?php include 'snippets/NavOben.php'; ?>

<main>
    <!-- layout with bootstrap grid here -->
    <div class="container">
        <!-- top-image -->
        <div class="row justify-content-center" >
            <div class="col">
                <img width="100%" src="https://dummyimage.com/800x200/000/fff" alt="Picture"></img>
            </div>
        </div>

        <div class="row justify-content-between pt-4" >
            <div class="col-3" >
                <p>Der Dienst <b>e-Mensa</b> ist noch beta. Sie können bereits <a class="link" href="Produkte.html">Mahlzeiten</a> durchstöbern, aber noch nicht bestellen.</p>
            </div>
            <div class="col-6">
                <h3>Leckere Gerichte vorbestellen</h3>
                <p>...und gemeinsam mit Kommilitonen und Freunden essen</p>
                <p> <?php echo "Die Uhrzeit ist: " . date("h:i:sa"); ?> </p>
                <?php if (isset($_GET['username'])) {
                    $user = $_GET['username'];
                    echo "<p>Hallo $user</p>";
                }?>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-light btn-block"><i class="fa fa-hand-pointer-o" aria-hidden="true">Registrieren</i></button>
                <button type="button" class="btn btn-light btn-block"><i class="fa fa-sign-out">Anmelden</i></button>
            </div>
        </div>

        <div class="row" >
            <div class="col-3" >
                <p>Registrieren Sie sich <a class="link" href="Registrieren.html">hier</a>, um über die Veröffentlichung des Dienstes per Mail informiert zu werden.</p>
            </div>
            <div class="col-9">
                <img width="100%"  src="https://dummyimage.com/800x200/000/fff" alt="Picture"></img>
            </div>
        </div>
    </div>
</main>

<?php include 'snippets/NavUnten.php'; ?>
<?php include 'snippets/HTMLEnd.php'; ?>