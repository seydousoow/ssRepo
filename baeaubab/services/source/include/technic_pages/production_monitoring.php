<!-- get the current stock -->
<?php
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
$sql = "select id_monitoring as id from production_monitoring where date=?";
$req = $bd->prepare($sql);
$req->execute(array(date("Y-m-d")));
if($req->rowCount() > 0){
    ?>
<script>
    swal("Info", "il existe deja une feuille de suivi de production de la date d'aujourd'hui! Appuyer sur continué afin de la visualisé.","info").then((value)=>{
        location.href = "technic_homepage.php?phase=view&stage=ProductionControl&dateStart=today&dateEnd=today";
    });
</script>
<?php
}
?>
<button class="btn btn-success" onclick="printData();">Imprimer</button>


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
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform05"
                        value="<?php echo $currentPreformStock[1];?>">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform19"
                        value="<?php echo $currentPreformStock[2];?>">
                </td>
            </tr>
            <tr>
                <td class="tg-dc05">Stock de Bouteilles:</td>
                <td class="tg-fm9z" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle05"
                        value="<?php echo $currentBottleStock[1];?>">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle19"
                        value="<?php echo $currentBottleStock[2];?>">
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
                        updatePreformStock("05", <?php echo $currentPreformStock[1];?>);'
                        value=""></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="produc19" id="produc19"
                        onkeyup='checkIfItsInteger("produc19");
                        updateTotalBottle("19");
                        updatePreformStock("19", <?php echo $currentPreformStock[2];?>);'
                        value=""></td>
            </tr>
            <tr>
                <td class="tg-dc05">Total de bouteilles disponibles</td>
                <td class="tg-fm9z" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="totalBottle05" id="totalBottle05" value="<?php echo $currentBottleStock[1];?>" disabled></td>
                <td class="tg-73ax" style="background-color: darkgray;"><input type="text" class="technicalProduction_input"
                        name="totalBottle19" id="totalBottle19" value="<?php echo $currentBottleStock[2];?>" disabled></td>
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
                        onkeyup='checkIfItsInteger("rebus05");updatePreformStock("05", <?php echo $currentPreformStock[1];?>);'
                        value=""></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input" name="rebus19" id="rebus19"
                        onkeyup='checkIfItsInteger("rebus19");updatePreformStock("19", <?php echo $currentPreformStock[2];?>);'
                        value=""></td>
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
        <input type="button" name="submitProductionMonitoring" class="submitBtnProduction" onclick="formValidation();"
            value="Enregistrer">
    </form>
</div>
<script src="source/include/technic_pages/js/production_monitoring.js"></script>