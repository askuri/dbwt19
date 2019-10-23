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
    <nav>
        <div class="row align-items-center nav-border-bottom"> <!-- vertical alignment: center -->
            <!-- logo -->
            <div class="col-3">
                <h1>e-Mensa</h1>
            </div>

            <!-- Menu -->
            <div class="col">
                <ul class="nav">
                    <li class="nav-item nav-border-right">
                        <a class="nav-link">Start</a>
                    </li>
                    <li class="nav-item nav-border-right">
                        <a class="nav-link" href="Produkte.html">Mahlzeiten</a>
                    </li>
                    <li class="nav-item nav-border-right">
                        <a class="nav-link" href="#">Bestellung</a>
                    </li>
                    <li class="nav-item nav-border-right">
                        <a class="nav-link" href="http://fh-aachen.de" target="_blank">FH-Aachen</a>
                    </li>
                </ul>
            </div>

            <!-- search -->
            <div class="col-3">
                <!-- "form group" of bootstrap allows prepended search icon -->
                <form class="form-inline my-2 my-lg-0" action="http://www.google.de/search" target="_blank">
                    <div class="input-group input-group-sm"> <!-- size: sm(all) -->
                        <!-- icon -->
                        <div class="input-group-prepend"> 
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <!-- input box -->
                        <input class="form-control mr-sm-2" name="q" type="search" placeholder="Suchen ..." aria-label="Search">
                        <!-- hidden fields -->
                        <input name="as_sitesearch" type="hidden" value="http://fh-aachen.de/">
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <main>
        <!-- layout with bootstrap grid here -->
        <div class="container">
            <!-- top-image -->
            <div class="row justify-content-center" >
                <div class="col">
                    <img  class="w-100" src="https://dummyimage.com/800x200/000/fff" alt="Picture">
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
                    <img class="w-100"  src="https://dummyimage.com/800x200/000/fff" alt="Picture">
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="row align-items-center nav-border-top">
            <div class="col-3">(c) <?php echo date('Y') ?> Martin Weber & Leonhard Kipp</div>
            <div class="col">
                <ul class="nav">
                    <li class="nav-item nav-border-right">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item nav-border-right">
                        <a class="nav-link" href="#">Registrieren</a>
                    </li>
                    <li class="nav-item nav-border-right">
                        <a class="nav-link" href="#">Zutatenliste</a>
                    </li>
                    <li class="nav-item nav-border-right">
                        <a class="nav-link" href="Impressum.html">Impressum</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
