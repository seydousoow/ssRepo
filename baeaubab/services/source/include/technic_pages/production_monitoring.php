<?php 
    date_default_timezone_set("Africa/Dakar");
//add the page for alert
require_once("source/alert/production_monitoring_alert.php");
require_once("source/model/init.php");

$bd=connect();

//get the stock of preform
$sql = "select date, stock05, stock19 from production_preform_stock order by id_stock_preforme desc limit 1";
$req = $bd->prepare($sql);
$req->execute();
while($data = $req->fetch(PDO::FETCH_ASSOC))
    $currentPreformStock = [$data['date'], $data['stock05'], $data['stock19']];

//get the stock of bottle
$sql = "select date, stock05, stock19 from production_bottle_stock order by id_bottle_stock desc limit 1";
$req = $bd->prepare($sql);
$req->execute();
while($data = $req->fetch(PDO::FETCH_ASSOC))
    $currentBottleStock = [$data['date'], $data['stock05'], $data['stock19']];

//check if there is a record for today
$sql = "select * from production_monitoring where date=?";
$req = $bd->prepare($sql);
$req->execute(array(date("Y-m-d")));
$state = false;//mean the is no record
if($req->rowCount() > 0)
    $state = true;//means there is a record

if(!($state)){
    ?>
<div class="tg-wrap">
    <form action="source/model/technic/M_add_production_monitoring.php" method="post">
        <table id="tg-WnK7G" class="tg table" style="table-layout: auto; width: auto">
            <colgroup>
                <col style="width: 550px">
                <col style="width: 300px">
                <col style="width: 300px">
            </colgroup>
            <tr>
                <td class="tg-unkg" colspan="3"><span style="font-weight:bold">FEUILLE DE SUIVI DE PRODUCTION</span></td>
            </tr>
            <tr>
                <td class="tg-dc05">Date :
                    <?php echo date("d-m-Y");?>
                    <input type="hidden" name="currentDate" id="currentDate" value="<?php echo date(" Y-m-d");?>">
                </td>
                <td class="tg-0big">Bouteille 0,5L</td>
                <td class="tg-ugu0">Bouteille 19L</td>
            </tr>
            <tr>
                <td class="tg-dc05">Stock de Pre&#769;forme:</td>
                <td class="tg-fm9z" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform05"
                        value="<?php echo isset($currentPreformStock[1])?$currentPreformStock[1]:'0';?>">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform19"
                        value="<?php echo isset($currentPreformStock[2]) ? $currentPreformStock[2]:'0';?>">
                </td>
            </tr>
            <tr>
                <td class="tg-dc05">Stock de Bouteilles:</td>
                <td class="tg-fm9z" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle05"
                        value="<?php echo isset($currentBottleStock[1]) ? $currentBottleStock[1]:'0';?>">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle19"
                        value="<?php echo isset($currentBottleStock[2]) ? $currentBottleStock[2]:'0';?>">
                </td>
            </tr>
            <tr>
                <td class="tg-dc05">Conducteurs:</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="conduc05" id="conduc05"
                        value="" autofocus></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="conduc19" id="conduc19"
                        value=""></td>
            </tr>
            <tr>
                <td class="tg-dc05">Heure de Début</td>
                <td class="tg-fm9z"><input type="time" class="technicalProduction_input" name="start05" id="start05"
                        value=""></td>
                <td class="tg-73ax"><input type="time" class="technicalProduction_input" name="start19" id="start19"
                        value=""></td>
            </tr>
            <tr>
                <td class="tg-dc05">Heure de Fin</td>
                <td class="tg-fm9z"><input type="time" class="technicalProduction_input" name="end05" id="end05" value=""></td>
                <td class="tg-73ax"><input type="time" class="technicalProduction_input" name="end19" id="end19" value=""></td>
            </tr>
            <tr>
                <td class="tg-dc05">Quantité Produite</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="produc05" id="produc05"
                        onkeyup='checkIfItsInteger("produc05");
                        updateTotalBottle("05");
                        updatePreformStock("05", <?php echo isset($currentPreformStock[1]) ? $currentPreformStock[1] : 0;?>);'
                        value=""></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="produc19" id="produc19"
                        onkeyup='checkIfItsInteger("produc19");
                        updateTotalBottle("19");
                        updatePreformStock("19", <?php echo isset($currentPreformStock[2]) ? $currentPreformStock[2] : 0;?>);'
                        value=""></td>
            </tr>
            <tr>
                <td class="tg-dc05">Total de bouteilles disponibles</td>
                <td class="tg-fm9z" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="totalBottle05" id="totalBottle05" value="<?php echo isset($currentBottleStock[1]) ? $currentBottleStock[1]:0;?>" disabled></td>
                <td class="tg-73ax" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="totalBottle19" id="totalBottle19" value="<?php echo isset($currentBottleStock[2]) ? $currentBottleStock[2]:0;?>" disabled></td>
            </tr>
            <tr>
                <td class="tg-dc05">Quantité Livrée</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="deliv05" id="deliv05"
                        onkeyup='checkIfItsInteger("deliv05");checkIfCorrect("05");updateNewBottleStockOnDelivery("05");'
                        value=""></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="deliv19" id="deliv19"
                        onkeyup='checkIfItsInteger("deliv19");checkIfCorrect("19");updateNewBottleStockOnDelivery("19");'
                        value=""></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nombre de Rebus</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="rebus05" id="rebus05"
                        onkeyup='checkIfItsInteger("rebus05");updatePreformStock("05", <?php echo isset($currentPreformStock[1]) ? $currentPreformStock[1]:0;?>);'
                        value=""></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="rebus19" id="rebus19"
                        onkeyup='checkIfItsInteger("rebus19");updatePreformStock("19", <?php echo isset($currentPreformStock[2]) ? $currentPreformStock[2]:0;?>);'
                        value=""></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nouveau stock de Pre&#769;forme</td>
                <td class="tg-fm9z" style="background-color: darkgray;">
                    <input type="text" class="technicalProduction_input" name="newPreformStock05" id="newPreformStock05"
                        value="<?php echo isset($currentPreformStock[1]) ? $currentPreformStock[1]:0;?>" readonly></td>
                <td class="tg-73ax" style="background-color: darkgray;">
                    <input type="text" class="technicalProduction_input" name="newPreformStock19" id="newPreformStock19"
                        value="<?php echo isset($currentPreformStock[2]) ? $currentPreformStock[2]:0;?>" readonly></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nouveau stock de Bouteilles</td>
                <td class="tg-fm9z" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="newBottleStock05" id="newBottleStock05" value="<?php echo isset($currentBottleStock[1]) ? $currentBottleStock[1]:0;?>"
                        readonly></td>
                <td class="tg-73ax" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="newBottleStock19" id="newBottleStock19" value="<?php echo isset($currentBottleStock[1]) ? $currentBottleStock[1]:0;?>"
                        readonly></td>
            </tr>
            <tr>
                <td class="tg-mv9o">Visa Chef de Ligne</td>
                <td class="tg-jtts"><input type="text" class="technicalProduction_input" name="visa05" id="visa05"
                        value=""></td>
                <td class="tg-ayio"><input type="text" class="technicalProduction_input" name="visa19" id="visa19"
                        value=""></td>
            </tr>
            <tr>
                <td class="tg-mv9o">Responsable<br></td>
                <td class="tg-jtts"><input type="text" class="technicalProduction_input" name="resp05" id="resp05"
                        value=""></td>
                <td class="tg-ayio"><input type="text" class="technicalProduction_input" name="resp19" id="resp19"
                        value=""></td>
            </tr>
        </table>

        <!-- <button class="btn btn-success" onclick="printData();">Imprimer</button> -->
        <input type="button" name="submitProductionMonitoring" class="submitBtnProduction" onclick="formValidation();"
            value="Enregistrer">
    </form>
</div>
<script src="source/include/technic_pages/js/production_monitoring.js"></script>

<?php
}else if($state){
    while($data = $req->fetch(PDO::FETCH_ASSOC)){
        $currentData = [$data['conducteur05'], $data['conducteur19'], $data['starting_time05'], $data['starting_time19'], $data['ending_time05'], $data['ending_time19'], $data['production05'], $data['production19'], $data['delivery05'], $data['delivery19'], $data['rebus05'], $data['rebus19'], $data['visa05'], $data['visa19'], $data['responsable05'], $data['responsable19'] ];
    }
    ?>
<div class="tg-wrap">
    <form action="source/model/technic/M_add_production_monitoring.php" method="post">
        <table id="tg-WnK7G" class="tg table" style="table-layout: auto; width: auto">
            <colgroup>
                <col style="width: 550px">
                <col style="width: 300px">
                <col style="width: 300px">
            </colgroup>
            <tr>
                <td class="tg-unkg" colspan="3"><span style="font-weight:bold">FEUILLE DE SUIVI DE PRODUCTION</span></td>
            </tr>
            <?php date_default_timezone_set("Africa/Dakar");?>
            <tr>
                <td class="tg-dc05">Date :
                    <?php echo date("d-m-Y");?>
                    <input type="hidden" name="currentDate" id="currentDate" value="<?php echo date(" Y-m-d");?>">
                </td>
                <td class="tg-0big">Bouteille 0,5L</td>
                <td class="tg-ugu0">Bouteille 19L</td>
            </tr>
            <tr>
                <td class="tg-dc05">Stock de Pre&#769;forme:</td>
                <td class="tg-fm9z" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform05">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform19">
                </td>
            </tr>
            <tr>
                <td class="tg-dc05">Stock de Bouteilles:</td>
                <td class="tg-fm9z" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle05">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle19">
                </td>
            </tr>
            <tr>
                <td class="tg-dc05">Conducteurs:</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="conduc05" id="conduc05"
                        value="<?php echo $currentData[0];?>"></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="conduc19" id="conduc19"
                        value="<?php echo $currentData[1];?>"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Heure de Début</td>
                <td class="tg-fm9z"><input type="time" class="technicalProduction_input" name="start05" id="start05"
                        value="<?php echo $currentData[2];?>"></td>
                <td class="tg-73ax"><input type="time" class="technicalProduction_input" name="start19" id="start19"
                        value="<?php echo $currentData[3];?>"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Heure de Fin</td>
                <td class="tg-fm9z"><input type="time" class="technicalProduction_input" name="end05" id="end05" value="<?php echo $currentData[4];?>"></td>
                <td class="tg-73ax"><input type="time" class="technicalProduction_input" name="end19" id="end19" value="<?php echo $currentData[5];?>"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Quantité Produite</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="produc05" id="produc05"
                        value="<?php echo $currentData[6];?>"></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="produc19" id="produc19"
                        value="<?php echo $currentData[7];?>"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Total de bouteilles disponibles</td>
                <td class="tg-fm9z" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="totalBottle05" id="totalBottle05" value="" disabled></td>
                <td class="tg-73ax" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="totalBottle19" id="totalBottle19" value="" disabled></td>
            </tr>
            <tr>
                <td class="tg-dc05">Quantité Livrée</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="deliv05" id="deliv05"
                        value="<?php echo $currentData[8];?>"></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="deliv19" id="deliv19"
                        value="<?php echo $currentData[9];?>"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nombre de Rebus</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input" name="rebus05" id="rebus05"
                        value="<?php echo $currentData[10];?>"></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="rebus19" id="rebus19"
                        value="<?php echo $currentData[11];?>"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nouveau stock de Pre&#769;forme</td>
                <td class="tg-fm9z" style="background-color: darkgray;">
                    <input type="text" class="technicalProduction_input" name="newPreformStock05" id="newPreformStock05"
                        value="<?php echo $currentPreformStock[1];?>" readonly></td>
                <td class="tg-73ax" style="background-color: darkgray;">
                    <input type="text" class="technicalProduction_input" name="newPreformStock19" id="newPreformStock19"
                        value="<?php echo $currentPreformStock[2];?>" readonly></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nouveau stock de Bouteilles</td>
                <td class="tg-fm9z" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="newBottleStock05" id="newBottleStock05" value="<?php echo $currentBottleStock[1];?>"
                        readonly></td>
                <td class="tg-73ax" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="newBottleStock19" id="newBottleStock19" value="<?php echo $currentBottleStock[2];?>"
                        readonly></td>
            </tr>
            <tr>
                <td class="tg-mv9o">Visa Chef de Ligne</td>
                <td class="tg-jtts"><input type="text" class="technicalProduction_input" name="visa05" id="visa05"
                        value="<?php echo $currentData[12];?>"></td>
                <td class="tg-ayio"><input type="text" class="technicalProduction_input" name="visa19" id="visa19"
                        value="<?php echo $currentData[13];?>"></td>
            </tr>
            <tr>
                <td class="tg-mv9o">Responsable<br></td>
                <td class="tg-jtts"><input type="text" class="technicalProduction_input" name="resp05" id="resp05"
                        value="<?php echo $currentData[14];?>"></td>
                <td class="tg-ayio"><input type="text" class="technicalProduction_input" name="resp19" id="resp19"
                        value="<?php echo $currentData[15];?>"></td>
            </tr>
        </table>
        <input type="hidden" name="old_form" value="yes">
        <!-- <button class="btn btn-success" onclick="printData();">Imprimer</button> -->
        <input type="button" name="submitProductionMonitoring" class="submitBtnProduction" onclick="formValidation();"
            value="Mettre a jour">
    </form>
</div>
<script src="source/include/technic_pages/js/production_monitoring_on_update.js"></script>
<?php
}?>