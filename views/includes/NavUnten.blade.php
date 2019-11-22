<footer>
    <div class="row align-items-center nav-border-top">
        <div class="col-3">(c) {{ date('Y') }} Martin Weber & Leonhard Kipp</div>
        <div class="col">
            <ul class="nav">
                <li class="nav-item nav-border-right">
                    <a class="nav-link" href="#">Login</a>
                </li>
                <li class="nav-item nav-border-right">
                    <a class="nav-link" href="#">Registrieren</a>
                </li>
                <li class="nav-item nav-border-right">
                    <a class="nav-link" {!! $_SERVER['REQUEST_URI'] === '/Zutaten.php' ? ' ' : 'href="Zutaten.php"' !!}>Zutatenliste</a>
                </li>
                <li class="nav-item nav-border-right">
                    <a class="nav-link" href="Impressum.html">Impressum</a>
                </li>
            </ul>
        </div>
    </div>
</footer>