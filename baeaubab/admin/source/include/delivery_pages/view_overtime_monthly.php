<?php
include_once("source/model/delivery/M_view_overtime_monthly.php");

$currentMonthEN = date("F");
$listMonthFR = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
$listMonthEN = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$listDayInMonth = [];
for ($m=1; $m<=12; $m++) {
    //get the number of days of each month
    array_push($listDayInMonth, date('t', mktime(0,0,0,$m, 1, date('Y'))));
}

$key = array_search($currentMonthEN, $listMonthEN);
$currentMonthFR = $listMonthFR[$key];

//get the number of day
$key = (isset($_GET['month-selected']) ? array_search($_GET['month-selected'], $listMonthFR) : $key);
$currentMonthDayNumber = $listDayInMonth[$key];

$key++;
$x = (($key < 10) ? "0".$key : $key);
$listMatricule = get_list_matricule_overtime($x, $currentMonthDayNumber);

if($listMatricule == null){
    echo "<script>swal('INFO', 'Aucune employé n\'a eu a effectuer d\'heure supplémentaire pour le compte du mois de ".$listMonthFR[$key-1]." de l\'année ".date("Y")."','info');</script>";
}
else{
    $listEmploye = get_employe_details($listMatricule);
    $listOvertimeAmount = get_employe_overtime($listMatricule, $x, $currentMonthDayNumber);
    $overtimeToTxt = [];
    foreach($listOvertimeAmount as $x){
        $nbr = explode(".", $x);
        if($nbr[0] <= 1 and $nbr[1] == 0)
            $heure = "heure";
        else
            $heure = "heures";
        if($nbr[1]==0)
            $minute = "";
        else
            $minute = " et 30 minutes";
        array_push($overtimeToTxt, $nbr[0]." ".$heure.$minute); 
    }
}
?>
<style>
    .input-group-prepend {
        margin-right: 0px;
    }
</style>

<div id="monthSelection">
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text month-change-btn prev" onclick="prev_month();" id="btnGroupAddon"><i class="far fa-arrow-alt-circle-left"></i></div>
        </div>
        <input type="text" class="form-control" id="month-value" value="<?php echo isset($_GET['month-selected']) ? $_GET['month-selected'] : $currentMonthFR;?>" aria-label="Input group example" aria-describedby="btnGroupAddon" disabled>
        <div class="input-group-prepend">
            <div class="input-group-text month-change-btn next" onclick="next_month();" id="btnGroupAddon"><i class="far fa-arrow-alt-circle-right"></i></div>
        </div>
        <div class="input-group-prepend">
            <div class="input-group-text month-change-btn showbtn" onclick="showDetails();" id="btnGroupAddon">Afficher</div>
        </div>
    </div>
</div>

<div id="overtime-month-container">
    <table class="table table-bordered table-striped" id="overtime-month-table">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Poste</th>
                <th>Nombre d'heure(s)</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i=0;$i<count($listEmploye); $i++){
                    echo "<tr>";
                    echo "<td>$listMatricule[$i]</td>";
                    for($j=0;$j<3;$j++){
                        echo "<td>".$listEmploye[$i][$j]."</td>";
                    }
                    echo "<td>$overtimeToTxt[$i]</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<script>
    var month_btn = document.querySelectorAll(".month-change-btn"),
        listMonthFR = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        month_input = document.getElementById("month-value");
    $(document).ready(check_month_btn());

    function check_month_btn() {
        if (month_input.value == "Janvier") {
            month_btn[0].style.pointerEvents = "none";
        } else {
            month_btn[0].style.pointerEvents = "auto";
            month_btn[0].style.cursor = "pointer";
        }
        if (month_input.value == "Décembre") {
            month_btn[1].style.pointerEvents = "none";
        } else {
            month_btn[1].style.pointerEvents = "auto";
            month_btn[1].style.cursor = "pointer";
        }
    }

    function prev_month() {
        indexFR = listMonthFR.indexOf(month_input.value);
        month_input.value = listMonthFR[indexFR - 1];
        check_month_btn();
    }

    function next_month() {
        indexFR = listMonthFR.indexOf(month_input.value);
        month_input.value = listMonthFR[indexFR + 1];
        check_month_btn();
    }

    function showDetails() {
        window.location.href = "delivery_homepage.php?view_overtime_monthly&month-selected=" + month_input.value;
    }

</script>
