<?php
require 'inc/PHPprepare.php';
include 'snippets/HTMLStart.php';
include 'snippets/NavOben.php';

$remoteConnection = mysqli_connect( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}

$query = 'SELECT * FROM Zutaten ORDER BY Bio DESC;';
if (!($result = mysqli_query($remoteConnection, $query))) {
    die('Query konnte nicht ausgeführt werden');
}

?>
<h2>Zutatenliste (<?=$result->num_rows ?>)</h2>
<main>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Zutat</th>
                <th>Bio?</th>
                <th>Vegan?</th>
                <th>Vegetarisch?</th>
                <th>Glutenfrei?</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) { 
                echo '<tr>'.
                        '<td id="id-'.$row['ID'].'"><a '
                        . 'href="http://www.google.de/search?q='.$row['Name'].'" '
                        . 'title="Suchen Sie nach '.$row['Name'].' im Web">'.
                        $row['Name']
                        .'</a></td>'.
                        '<td>'.($row['Bio'] ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>').'</td>'.
                        '<td>'.($row['Vegan'] ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>').'</td>'.
                        '<td>'.($row['Vegetarisch'] ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>').'</td>'.
                        '<td>'.($row['Glutenfrei'] ? '<i class="fa fa-check-circle-o"></i>' : '<i class="fa fa-times-circle-o"></i>').'</td>'.
                    '</tr>'
                ;
            }
            ?>
        </tbody>
    </table>
    
</main>

<?php include 'snippets/NavUnten.php'; ?>
<?php include 'snippets/HTMLEnd.php'; ?>