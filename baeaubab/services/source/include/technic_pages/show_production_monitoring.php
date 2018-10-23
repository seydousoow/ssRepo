<style>
    .tg-18l6 {
        border-color: white !important;
        padding: 5px 5px !important;
    }


    .tg-66bl {
        font-weight: bold !important;
        font-size: 14px !important;
        font-family: Georgia, serif !important;
        background-color: #375a72 !important;
        color: #ffffff !important;
        border-color: #ffffff !important;
        text-align: center;
        padding: 5px 5px !important;
    }

    .tg-dr65 {
        font-size: 14px !important;
        font-family: Georgia, "Courier New", Courier, monospace !important;
        background-color: #375a72 !important;
        border-color: #ffffff !important;
        color: white !important;
        padding: 5px 5px !important;

    }

    .tg-gb70 {
        padding: 5px 5px !important;
        font-size: 13px !important;
    }

    .tg-2024{
        font-size: 13.5px !important;
        font-family: Georgia, 'Times New Roman', Times, serif;
    }

</style>

<?php 
date_default_timezone_set("Africa/Dakar");
$date1 = isset($_GET['date1']) ? filter_var($_GET['date1'], FILTER_SANITIZE_NUMBER_INT) : date('Y-m-d');
$date2 = isset($_GET['date2']) ? filter_var($_GET['date2'], FILTER_SANITIZE_NUMBER_INT) : date('Y-m-d');
?>

<div id="selectDateContainer" style="margin-bottom: 7px;">
    <input type="text" name="dateSelector" id="dateSelector">
    <input type="button" class="btn btn-primary" id="showBtn" value="Afficher">
</div>
<script src="source/include/technic_pages/js/show_production_monitoring.js"></script>
<script>
    //create a date prototype to get the desired date format
    Date.prototype.yyyymmdd = function () {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();
        return [this.getFullYear(),
            (mm > 9 ? '' : '0') + mm,
            (dd > 9 ? '' : '0') + dd,
        ].join('-');
    };

    //date to french
    Date.prototype.frenchDate = function () {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();
        var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre',
            'Décembre'
        ];
        return [(dd > 9 ? '' : '0') + dd,
            month[mm - 1],
            this.getFullYear()

        ].join(' ');
    };

    var firstDate = "",
        lastDate = "";

    //create and instanciate flatpickr
    flatpickr("#dateSelector", {
        dateFormat: "d-F-Y",
        minDate: "01-01-2018",
        maxDate: new Date(),
        "locale": {
            "firstDayOfWeek": 1 // start week on Monday
        },
        // mode: "multiple",
        mode: "range",
        onChange: function (selectedDates) {
            if (selectedDates.length > 1) {
                firstDate = selectedDates[0].yyyymmdd();
                lastDate = selectedDates[1].yyyymmdd();
                document.getElementById("dateSelector").value =
                    "Afficher la periode du " + new Date(firstDate)
                    .frenchDate() + " au " +
                    new Date(lastDate).frenchDate();
            } else {
                firstDate = selectedDates[0].yyyymmdd();
                lastDate = "";
                document.getElementById("dateSelector").value =
                    "Afficher la date du " + new Date(firstDate).frenchDate();
            }
        }
    });

    //do the correct action when the user click on the button
    document.getElementById("showBtn").addEventListener("click", function () {
        //check if at least one date has been seleted
        if (firstDate == "")
            swal("Erreur",
                "Veillez choisir une date ou une range de date a afficher SVP!",
                "error");
        else if (lastDate != "")
            location.href =
            "technic_homepage.php?production_monitoring&action=view&date1=" +
            firstDate + "&date2=" +
            lastDate;
        else
            location.href =
            "technic_homepage.php?production_monitoring&action=view&date1=" +
            firstDate + "&date2=" + firstDate;
    });

    var date1 = <?php echo json_encode($date1); ?>;
    var date2 = <?php echo json_encode($date2); ?>;

    if (date1 == date2)
        document.getElementById("dateSelector").value =
        "Affichage de la date du " + new Date(
            date1).frenchDate();
    else
        document.getElementById("dateSelector").value =
        "Affichage de la periode du " + new Date(
            date1).frenchDate() + " au " + new Date(date2).frenchDate();
</script>

<?php 
//if the first date is valid
if (validateDate($date1) === true) {
    require_once("source/model/init.php");
    $bd = connect();
    //if the second date is valid
    if (validateDate($date2) === true) {
        //the user selected a range
        $sql = "SELECT * FROM `production_monitoring` WHERE `date`>=? and `date` <=? order by `date` asc";
        $req = $bd->prepare($sql);
        $req->execute(array($date1, $date2));
    } else {
        //there is only one date to show
        $sql = "select * from production_monitoring where date=?";
        $req = $bd->prepare($sql);
        $req->execute(array($date1));
    }

    $listProduction = [];
    //variable that will count the number of entries
    $entries = 0;
    //total variable
    $totalProd05 = $totalProd19 = $totaldeliv05 = $totaldeliv19 = $totalrebus05 = $totalrebus19 = 0;
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        array_push($listProduction, [$data['date'], $data['conducteur05'], $data['conducteur19'], $data['starting_time05'], $data['starting_time19'], $data['ending_time05'], $data['ending_time19'], $data['production05'], $data['production19'], $data['delivery05'], $data['delivery19'], $data['rebus05'], $data['rebus19'], $data['visa05'], $data['visa19'], $data['responsable05'], $data['responsable19']]);
        $entries += 1;
        $totalProd05 += $data['production05'];
        $totalProd19 += $data['production19'];
        $totaldeliv05 += $data['delivery05'];
        $totaldeliv19 += $data['delivery19'];
        $totalrebus05 += $data['rebus05'];
        $totalrebus19 += $data['rebus19'];
    }

    $userDetails = [];
    //get name and surname of employees of the technical service
    $sql = "select id, nom, prenom from userstatus";
    $req = $bd->prepare($sql);
    $req->execute(array());
    while ($data = $req->fetch(PDO::FETCH_ASSOC))
        array_push($userDetails, ['id' => $data['id'], 'name' => $data['nom'], 'surname' => $data['prenom']]);

    // set the correct user detail on each row
    for ($i = 0; $i < count($listProduction); $i++) {
        for ($j = 0; $j < count($userDetails); $j++) {
            if ($userDetails[$j]['id'] == $listProduction[$i][1]) {
                $listProduction[$i][1] = $listProduction[$i][2] = $userDetails[$j]['surname'] . ' ' . $userDetails[$j]['name'];
            }
        }
    }
}

//function that check if the date are correct
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

require_once("source/alert/production_monitoring_alert.php");

// show the table that contains the totals
if ($date1 != $date2) {
    ?>
<table class="tg-total">
    <colgroup>
        <col style="width: 100px">
        <col style="width: 100px">
        <col style="width: 100px">
        <col style="width: 100px">
        <col style="width: 100px">
        <col style="width: 100px">
    </colgroup>
    <tr>
        <td class="tg-66bl" colspan="6" style="font-size: 18px !important;">
            <script>
                document.write('Synthèse du ' + new Date(date1).frenchDate() +
                    ' au ' + new Date(date2).frenchDate());
            </script>
        </td>
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
        <th class="tg-66bl" colspan="18" style="padding: 5px 5px;font-size: 18px !important;">
            <script>
                document.write("Suivie de la production du " + new Date(date1).frenchDate());
                if (date1 != date2) document.write(" au " + new Date(date2).frenchDate());
            </script>
        </th>
    </tr>
    <tr>
        <th class="tg-dr65" rowspan="2" style="vertical-align:bottom">Date</td>
        <th class="tg-dr65" colspan="2">Conducteur</th>
        <th class="tg-dr65" colspan="2">Heure de début</th>
        <th class="tg-dr65" colspan="2">Heure de Fin</th>
        <th class="tg-dr65" colspan="2">Production</th>
        <th class="tg-dr65" colspan="2">Livraison</th>
        <th class="tg-dr65" colspan="2">Rebus</th>
        <th class="tg-dr65" colspan="2">Visa<br></th>
        <th class="tg-dr65" colspan="2">Responsable</th>
    </tr>
    <tr>
        <td class="tg-dr65">0,5 L</td>
        <td class="tg-dr65">19L</td>
        <td class="tg-dr65">0,5L</td>
        <td class="tg-dr65">19L</td>
        <td class="tg-dr65">0,5L</td>
        <td class="tg-dr65">19L</td>
        <td class="tg-dr65">0,5L</td>
        <td class="tg-dr65">19L</td>
        <td class="tg-dr65">0,5L</td>
        <td class="tg-dr65">19L</td>
        <td class="tg-dr65">0,5L</td>
        <td class="tg-dr65">19L</td>
        <td class="tg-dr65">0,5L</td>
        <td class="tg-dr65">19L</td>
        <td class="tg-dr65">0,5L</td>
        <td class="tg-dr65">19L</td>
    </tr>
    <?php
    if (isset($date1) && validateDate($date1) === true) {
        for ($i = 0; $i < $entries; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 17; $j++) {
                if (($i % 2) == 0)
                    echo "<td class='tg-2024'>";
                else
                    echo "<td class='tg-kpis'>";
                if ($j == 0)
                    echo date("d F Y", strtotime($listProduction[$i][$j]));
                else
                    echo $listProduction[$i][$j] . "</td>";
            }
            echo "</tr>";
        }
    }
    ?>
</table>