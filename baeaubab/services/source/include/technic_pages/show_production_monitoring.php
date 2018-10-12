<div id="selectDateContainer" style="margin-bottom: 7px;">
    <input type="text" name="dateSelector" id="dateSelector">
    <input type="button" class="btn btn-primary" id="showBtn" value="Afficher">
</div>
<script src="source/include/technic_pages/js/show_production_monitoring.js"></script>

<?php 
if (isset($_GET['date1']) && isset($_GET['date2'])) {
    //if the first date is valid
    if (validateDate($_GET['date1']) === true) {
        require_once("source/model/init.php");
        $bd = connect();
        //if the second date is valid
        if (validateDate($_GET['date2']) === true) {
            //the user selected a range
            $sql = "SELECT * FROM `production_monitoring` WHERE `date`>=? and `date` <=? order by `date` asc";
            $req = $bd->prepare($sql);
            $req->execute(array($_GET['date1'], $_GET['date2']));
        } else {
            //there is only one date to show
            $sql = "select * from production_monitoring where date=?";
            $req = $bd->prepare($sql);
            $req->execute(array($_GET['date1']));
        }
        
        //list of data
        $list = [];
        //variable that will count the number of entries
        $entries = 0;
        //total variable
        $totalProd05 = $totalProd19 = $totaldeliv05 = $totaldeliv19 = $totalrebus05 = $totalrebus19 = 0;
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            array_push($list, [$data['date'], $data['conducteur05'], $data['conducteur19'], $data['starting_time05'], $data['starting_time19'], $data['ending_time05'], $data['ending_time19'], $data['production05'], $data['production19'], $data['delivery05'], $data['delivery19'], $data['rebus05'], $data['rebus19'], $data['visa05'], $data['visa19'], $data['responsable05'], $data['responsable19']]);
            $entries += 1;
            $totalProd05 += $data['production05'];
            $totalProd19 += $data['production19'];
            $totaldeliv05 += $data['delivery05'];
            $totaldeliv19 += $data['delivery19'];
            $totalrebus05 += $data['rebus05'];
            $totalrebus19 += $data['rebus19'];
        }

    }
}

//functon that check if the date are correct
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
require_once("source/alert/production_monitoring_alert.php");

// show the table that contains the totals
if (isset($_GET['date1']) && isset($_GET['date2'])) {
    //if the first date is valid
    if (validateDate($_GET['date1']) === true && validateDate($_GET['date2']) === true) {
        ?>
<table class="tg-total" style="table-layout: fixed; width: 601px">
    <colgroup>
        <col style="width: 150px">
        <col style="width: 150px">
        <col style="width: 150px">
        <col style="width: 150px">
        <col style="width: 150px">
        <col style="width: 150px">
    </colgroup>
    <tr>
        <td class="tg-66bl" colspan="6"><script> document.write('Synthèse du '+d1+' au '+d2);</script></td>
    </tr>
    <tr>
        <td class="tg-18l6" colspan="2">Bouteilles produites</td>
        <td class="tg-18l6" colspan="2">Bouteilles livrees</td>
        <td class="tg-18l6" colspan="2">Rebus</td>
    </tr>
    <tr>
        <td class="tg-66bl">0,5L</td>
        <td class="tg-66bl">19L</td>
        <td class="tg-66bl">0,5L</td>
        <td class="tg-66bl">19L</td>
        <td class="tg-66bl">0,5L</td>
        <td class="tg-66bl">19L</td>
    </tr>
    <tr>
        <td class="tg-gb70">
            <?php echo $totalProd05; ?>
        </td>
        <td class="tg-gb70">
            <?php echo $totalProd19; ?>
        </td>
        <td class="tg-gb70">
            <?php echo $totaldeliv05; ?>
        </td>
        <td class="tg-gb70">
            <?php echo $totaldeliv19; ?>
        </td>
        <td class="tg-gb70">
            <?php echo $totalrebus05; ?>
        </td>
        <td class="tg-gb70">
            <?php echo $totalrebus19; ?>
        </td>
    </tr>
</table>

<?php 
}
} ?>

<!-- show the table the contains the details -->
<table id="tg-pTiHD" class="tg">
    <colgroup>
        <col style="width: 150px">
        <col style="width: 120px">
        <col style="width: 120px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 70px">
        <col style="width: 120px">
        <col style="width: 120px">
        <col style="width: 120px">
        <col style="width: 120px">
    </colgroup>
    <tr>
        <th class="tg-i1bv"></th>
        <th class="tg-dr65" colspan="2">Conducteur</th>
        <th class="tg-dr65" colspan="2">Heure de début</th>
        <th class="tg-dr65" colspan="2">Heure de Fin</th>
        <th class="tg-ma7l" colspan="2">Production</th>
        <th class="tg-dr65" colspan="2">Livraison</th>
        <th class="tg-z9vm" colspan="2">Rebus</th>
        <th class="tg-z9vm" colspan="2">Visa<br></th>
        <th class="tg-z9vm" colspan="2">Responsable</th>
    </tr>
    <tr>
        <td class="tg-osjs">Date</td>
        <td class="tg-osjs">0,5 L</td>
        <td class="tg-osjs">19L</td>
        <td class="tg-osjs">0,5L</td>
        <td class="tg-osjs">19L</td>
        <td class="tg-osjs">0,5L</td>
        <td class="tg-osjs">19L</td>
        <td class="tg-osjs">0,5L</td>
        <td class="tg-osjs">19L</td>
        <td class="tg-osjs">0,5L</td>
        <td class="tg-osjs">19L</td>
        <td class="tg-osjs">0,5L</td>
        <td class="tg-osjs">19L</td>
        <td class="tg-osjs">0,5L</td>
        <td class="tg-osjs">19L</td>
        <td class="tg-osjs">0,5L</td>
        <td class="tg-osjs">19L</td>
    </tr>
    <?php
    if (isset($_GET['date1']) && validateDate($_GET['date1']) === true) {
        for ($i = 0; $i < $entries; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 17; $j++) {
                if (($i % 2) == 0)
                    echo "<td class='tg-2024'>";
                else
                    echo "<td class='tg-kpis'>";
                if ($j == 0)
                    echo date("d F Y", strtotime($list[$i][$j]));
                else
                    echo $list[$i][$j] . "</td>";
            }
            echo "</tr>";
        }
    }
    ?>
</table>