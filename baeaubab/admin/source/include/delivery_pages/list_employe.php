<?php
require_once('source/model/delivery/M_list_employe.php');
$list = get_list();
$number = count($list);
?>
<div class="delivery_employe_container">

    <table id="delivery_list_table" class="table table-bordered table-striped table-sm">
        <caption id="list-delivery-caption">Liste des employe&#769;s du service de Livraison</caption>
        <thead>
            <tr>
                <th>#</th>
                <th onclick="sortTable(1)">Nom</th>
                <th onclick="sortTable(2)">Pre&#769;nom</th>
                <th onclick="sortTable(3)">Fonction</th>
                <th onclick="sortTable(4)">Matricule</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for($i = 0; $i<$number; $i++){
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$list[$i][1].'</td>';
                echo '<td>'.$list[$i][2].'</td>';
                echo '<td>'.$list[$i][3].'</td>';
                echo '<td>'.$list[$i][4].'</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

</div>

<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("delivery_list_table");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

</script>
