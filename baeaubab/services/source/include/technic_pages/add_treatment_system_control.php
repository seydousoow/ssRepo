<!-- date to french -->
<script>
Date.prototype.frenchDate = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();
    var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    return [(dd > 9 ? '' : '0') + dd,
        month[mm-1],
        this.getFullYear()
        
    ].join(' ');
};
</script>

<?php
//import the page that contains the alert
require_once("source/alert/treatment_system_control_alert.php");

//set the default timezone and get the current date 
//date_default_timezone_set("Africa/Dakar");
$today = date("Y-m-d");

//get the data if exist
require("source/model/init.php");
$bd = connect();
//get the data for the water treatment system number 1 of the date of today
$sql = "select * from water_system_control1 where date=?";
$req=$bd->prepare($sql);
$req->execute(array($today));
if($req->rowCount() > 0){
        while($data = $req->fetch(PDO::FETCH_ASSOC))
                $listdata1 = [ $data['pressionPompeIn'], $data['pressionPompeOut'], $data['pressionAmiadeIn'], $data['pressionAmiadeOut'], $data['pressionMacroIn'], $data['pressionMacroOut'], $data['pressionCharbonIn'], $data['pressionCharbonOut'], $data['pressionAdouciIn'], $data['pressionAdouciOut'], $data['dureteBrute'], $data['dureteAdoucie'], $data['dureteOsmosee'], $data['tdsBrute'], $data['tdsAdoucie'], $data['tdsOsmosee1'], $data['tdsOsmosee2'], $data['tdsMineralise'], $data['chloreIn'], $data['chloreOut']];
}

//get the data for the water treatment system number 2 of the date of today
$sql = "select * from water_system_control2 where date=?";
$req=$bd->prepare($sql);
$req->execute(array($today));
if($req->rowCount() > 0){
        while($data = $req->fetch(PDO::FETCH_ASSOC))
                $listdata2 = [ $data['pressionPompeIn'], $data['pressionPompeOut'], $data['pressionAmiadeIn'], $data['pressionAmiadeOut'], $data['pressionMacroIn'], $data['pressionMacroOut'], $data['pressionCharbonIn'], $data['pressionCharbonOut'], $data['pressionAdouciIn'], $data['pressionAdouciOut'], $data['dureteBrute'], $data['dureteAdoucie'], $data['dureteOsmosee'], $data['tdsBrute'], $data['tdsAdoucie'], $data['tdsOsmosee1'], $data['tdsOsmosee2'], $data['tdsMineralise'], $data['chloreIn'], $data['chloreOut']];
}
?>
<div class="tg-wrap">
        <table id="tg-dt5fY" class="tg">
                <thead>
                        <tr>
                                <td class="tg-r1kb" colspan="20">CONTROLE DU SYSTEME DE TRAITEMENT EAU N<sup>o</sup> 1 DU
                                        <script>document.write(new Date(<?php echo json_encode($today);?>).frenchDate());</script>
                                </td>
                        </tr>
                        <tr>
                                <td class="tg-nn11 tg-nn111" colspan="10">PRESSIONS</td>
                                <td class="tg-nn11 tg-nn111" colspan="3">Dureté d'eau</td>
                                <td class="tg-nn11 tg-nn111" colspan="5">TDS Eau</td>
                                <td class="tg-nn11 tg-nn111" colspan="2">Test Chlore</td>
                        </tr>
                        <tr>
                                <td class="tg-kqiv" colspan="2">Pompe</td>
                                <td class="tg-kqiv" colspan="2">Filtre Amiad</td>
                                <td class="tg-kqiv" colspan="2">CP213 Macro</td>
                                <td class="tg-kqiv" colspan="2">CP213 Charbon<br></td>
                                <td class="tg-kqiv" colspan="2">CP213 Adouci</td>
                                <td class="tg-kqiv" rowspan="2">Brute</td>
                                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                                <td class="tg-kqiv" rowspan="2">Osmosée</td>
                                <td class="tg-kqiv" rowspan="2">Brute</td>
                                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                                <td class="tg-kqiv" rowspan="2">Osmosée 1</td>
                                <td class="tg-kqiv" rowspan="2">Osmosée 2</td>
                                <td class="tg-kqiv" rowspan="2">Minéralisée</td>
                                <td class="tg-kqiv" rowspan="2">IN</td>
                                <td class="tg-kqiv" rowspan="2">OUT</td>
                        </tr>
                        <tr>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                        </tr>
                </thead>
                <tbody>
                        <tr>
                                <form id="treatmentForm1" action="source/model/technic/M_add_treatment_control_system.php"
                                        method="post">
                                        <!-- correspond to the number of the sheet -->
                                        <input type="hidden" name="version" value="1">
                                        <!-- correspond to the selected date -->
                                        <input type="hidden" name="date" value="<?php echo $today;?>" class="selected_date">

                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionPompeIn"
                                                        id="pressionPompeIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionPompeOut"
                                                        id="pressionPompeOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionAmiadeIn"
                                                        id="pressionAmiadeIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionAmiadeOut"
                                                        id="pressionAmiadeOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionMacroIn"
                                                        id="pressionMacroIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionMacroOut"
                                                        id="pressionMacroOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionCharbonIn"
                                                        id="pressionCharbonIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionCharbonOut"
                                                        id="pressionCharbonOut" value="" maxlength="7" disabled
                                                        required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionAdouciIn"
                                                        id="pressionAdouciIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="pressionAdouciOut"
                                                        id="pressionAdouciOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="dureteBrute" id="dureteBrute"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="dureteAdoucie" id="dureteAdoucie"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="dureteOsmosee" id="dureteOsmosee"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="tdsBrute" id="tdsBrute"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="tdsAdoucie" id="tdsAdoucie"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="tdsOsmosee1" id="tdsOsmosee1"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="tdsOsmosee2" id="tdsOsmosee2"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="tdsMineralise" id="tdsMineralise"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="chloreIn" id="chloreIn"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control1" name="chloreOut" id="chloreOut"
                                                        value="" maxlength="7" disabled required></td>
                                </form>
                        </tr>

                </tbody>
        </table>
        <div class="treatmentDivContainer">
                <?php 
                        if(isset($listdata1))
                                echo '<button class="btn btn-success" id="editTreatmentControlBtn1">Mettre à jour</button>';
                        else
                                echo '<button class="btn btn-success" id="editTreatmentControlBtn1">E&#769;diter</button>';
                ?>
                <button class="btn btn-danger" id="cancelTreatmentControlBtn1">Annuler</button>
        </div>
</div>

<div class="tg-wrap">
        <table id="tg-dt5fY" class="tg">
                <thead>
                        <tr>
                                <td class="tg-r1kb" colspan="20">CONTROLE DU SYSTEME DE TRAITEMENT EAU N<sup>o</sup> 2 DU
                                <script>document.write(new Date(<?php echo json_encode($today);?>).frenchDate());</script>
                                </td>
                        </tr>
                        <!-- unite de mesure : PSI for pression
                durete : G
                TDS eau : PPM
                test chlore : mg/l    
                add to tds mineralisee

                alert:
                durete eau if adoucie>0 and osmose>0
                tds osmose 1 and 2 if >23
                chlore if >0,5
        -->
                        <tr>
                                <td class="tg-nn11 tg-nn111" colspan="10">PRESSIONS</td>
                                <td class="tg-nn11 tg-nn111" colspan="3">Dureté d'eau</td>
                                <td class="tg-nn11 tg-nn111" colspan="5">TDS Eau</td>
                                <td class="tg-nn11 tg-nn111" colspan="2">Test Chlore</td>
                        </tr>
                        <tr>
                                <td class="tg-kqiv" colspan="2">Pompe</td>
                                <td class="tg-kqiv" colspan="2">Filtre Amiad</td>
                                <td class="tg-kqiv" colspan="2">CP213 Macro</td>
                                <td class="tg-kqiv" colspan="2">CP213 Charbon<br></td>
                                <td class="tg-kqiv" colspan="2">CP213 Adouci</td>
                                <td class="tg-kqiv" rowspan="2">Brute</td>
                                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                                <td class="tg-kqiv" rowspan="2">Osmosée</td>
                                <td class="tg-kqiv" rowspan="2">Brute</td>
                                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                                <td class="tg-kqiv" rowspan="2">Osmosée 1</td>
                                <td class="tg-kqiv" rowspan="2">Osmosée 2</td>
                                <td class="tg-kqiv" rowspan="2">Minéralisée</td>
                                <td class="tg-kqiv" rowspan="2">IN</td>
                                <td class="tg-kqiv" rowspan="2">OUT</td>
                        </tr>
                        <tr>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                                <td class="tg-7cwe">IN</td>
                                <td class="tg-7cwe">OUT</td>
                        </tr>
                </thead>
                <tbody>
                        <tr>
                                <form id="treatmentForm2" action="source/model/technic/M_add_treatment_control_system.php"
                                        method="post">
                                        <!-- correspond to the number of the sheet -->
                                        <input type="hidden" name="version" value="2">
                                        <!-- correspond to the selected date -->
                                        <input type="hidden" name="date" value="<?php echo $today;?>" class="selected_date">
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionPompeIn"
                                                        id="pressionPompeIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionPompeOut"
                                                        id="pressionPompeOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionAmiadeIn"
                                                        id="pressionAmiadeIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionAmiadeOut"
                                                        id="pressionAmiadeOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionMacroIn"
                                                        id="pressionMacroIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionMacroOut"
                                                        id="pressionMacroOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionCharbonIn"
                                                        id="pressionCharbonIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionCharbonOut"
                                                        id="pressionCharbonOut" value="" maxlength="7" disabled
                                                        required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionAdouciIn"
                                                        id="pressionAdouciIn" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="pressionAdouciOut"
                                                        id="pressionAdouciOut" value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="dureteBrute" id="dureteBrute"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="dureteAdoucie" id="dureteAdoucie"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="dureteOsmosee" id="dureteOsmosee"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="tdsBrute" id="tdsBrute"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="tdsAdoucie" id="tdsAdoucie"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="tdsOsmosee1" id="tdsOsmosee1"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="tdsOsmosee2" id="tdsOsmosee2"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="tdsMineralise" id="tdsMineralise"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="chloreIn" id="chloreIn"
                                                        value="" maxlength="7" disabled required></td>
                                        <td class="tg-hmp3"><input type="text" class="control2" name="chloreOut" id="chloreOut"
                                                        value="" maxlength="7" disabled required></td>
                                </form>
                        </tr>
                </tbody>
        </table>
        <div class="treatmentDivContainer">
                <?php 
                        if(isset($listdata2))
                                echo '<button class="btn btn-success" id="editTreatmentControlBtn2">Mettre à jour</button>';
                        else
                                echo '<button class="btn btn-success" id="editTreatmentControlBtn2">E&#769;diter</button>';
                ?>
                <button class="btn btn-danger" id="cancelTreatmentControlBtn2">Annuler</button>
        </div>
</div>
<script src="source/include/technic_pages/js/treatment_control_form.js"></script>

<script>
        var list = <?php echo isset($listdata1)?json_encode($listdata1):"[]";?>;
        var i = 0;
        if (list.length > 5) {
                document.querySelectorAll(".control1").forEach(function (element) {
                        element.value = list[i];
                        i += 1;
                });
        }
        list = <?php echo isset($listdata2)?json_encode($listdata2):"[]";?>;
        i = 0;
        if (list.length > 5) {
                document.querySelectorAll(".control2").forEach(function (element) {
                        element.value = list[i];
                        i += 1;
                });
        }
</script>