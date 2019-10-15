<!DOCTYPE html>

<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Start.html</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <nav class="">
            <div class="row align-items-center"> <!-- vertical alignment: center -->
                <!-- logo -->
                <div class="col-3">
                    <h1><a class="link" href="#">e-Mensa</a></h1>
                </div>

                <!-- Menu -->
                <div class="col-6">
                    <a class="link" href="Start.php">Start</a> | 
                    <a class="link" href="Produkte.html">Mahlzeiten</a> | 
                    <a class="link" href="#">Bestellung</a> | 
                    <a class="link" target="_blank" rel="noopener noreferrer" href="https://www.fh-aachen.de/">FH-Aachen</a>
                </div>

                <!-- search -->
                <div class="col">
                    <!-- "form group" of bootstrap alllows prepended search icon -->
                    <form class="form-inline my-2 my-lg-0">
                        <div class="input-group input-group-sm"> <!-- size: sm(all) -->
                            <!-- icon -->
                            <div class="input-group-prepend"> 
                                <div class="input-group-text"><i class="fa fa-search"></i></div>
                            </div>
                            <!-- input box -->
                            <input class="form-control mr-sm-2" type="search" placeholder="Suchen ..." aria-label="Search">
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <hr>
    </header>

    <main>
        <!-- layout with bootstrap grid here, see https://getbootstrap.com/docs/4.3/layout/grid/ -->
        <div class="container">
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
                    <button type="button" class="btn btn-primary btn-block"><i class="fa fa-hand-pointer-o" aria-hidden="true">Registrieren</i></button>
                    <button type="button" class="btn btn-primary btn-block"><i class="fa fa-sign-out">Anmelden</i></button>
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

    <footer>
        <hr>
        <div class="row align-items-center"> 
            <div class="col-3">(c) <?php echo date("Y"); ?> Martin Weber & Leonhard Kipp</div>
            <div class="col">
                <a class="link" href="#">Login</a> | 
                <a class="link" href="#">Registrieren</a> | 
                <a class="link" href="#">Zutatenliste</a> | 
                <a class="link" href="Impressum.html">Impressum</a>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
