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
                    <a class="nav-link" <?=$_SERVER['REQUEST_URI'] === '/Start.php' ? '' : 'href="Start.php"' ?>>Start</a>
                </li>
                <li class="nav-item nav-border-right">
                    <a class="nav-link" <?=$_SERVER['REQUEST_URI'] === '/Produkte.php' ? '' : 'href="Produkte.php"' ?>>Mahlzeiten</a>
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