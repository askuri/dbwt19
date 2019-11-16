<?php
function populateZutatenTable($mysqli_result){
    while ($row = mysqli_fetch_assoc($mysqli_result)) { 
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
}

?>
