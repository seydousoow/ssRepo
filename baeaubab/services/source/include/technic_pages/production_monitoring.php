<?php 
<<<<<<< HEAD
// set the date
date_default_timezone_set("Africa/Dakar");
$date = (isset($_GET['date']) ? filter_var($_GET['date'], FILTER_SANITIZE_NUMBER_INT) : date('Y-m-d'));

// add the page for alert
require_once("source/alert/production_monitoring_alert.php");
require_once("source/model/init.php");

$bd = connect();
$currentBottleStock = $currentPreformStock = $currentData = $userDetails = [];

// get the stock of preform
$sql = "select stock05, stock19 from production_preform_stock order by date desc limit 1";
$req = $bd->prepare($sql);
$req->execute(array());
while ($data = $req->fetch(PDO::FETCH_ASSOC))
    $currentPreformStock = [$data['stock05'], $data['stock19']];

//get the stock of bottle
$sql = "select stock05, stock19 from production_bottle_stock order by date desc limit 1";
$req = $bd->prepare($sql);
$req->execute(array());
while ($data = $req->fetch(PDO::FETCH_ASSOC))
    $currentBottleStock = [$data['stock05'], $data['stock19']];

=======
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
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd

//check if there is a record for today
$sql = "select * from production_monitoring where date=?";
$req = $bd->prepare($sql);
<<<<<<< HEAD
$req->execute(array($date));
if ($req->rowCount() > 0) $hasRecord = true;
else $hasRecord = false;
while ($data = $req->fetch(PDO::FETCH_ASSOC))
    $currentData = [$data['conducteur05'], $data['conducteur19'], $data['starting_time05'], $data['starting_time19'], $data['ending_time05'], $data['ending_time19'], $data['production05'], $data['production19'], $data['delivery05'], $data['delivery19'], $data['rebus05'], $data['rebus19'], $data['visa05'], $data['visa19'], $data['responsable05'], $data['responsable19']];

//if there is a record, get the details of the user that made the record
if ($hasRecord && ($currentData[0] != $_SESSION['status'])) {
    $sql = "select nom, prenom from userstatus where id = ?";
    $req = $bd->prepare($sql);
    $req->execute(array($currentData[0]));
    if ($req->rowCount() > 0) {
        while ($data = $req->fetch(PDO::FETCH_ASSOC))
            $userDetails = ['name' => $data['nom'], 'surname' => $data['prenom']];
    } else
        $userDetails = ['name' => $_SESSION['name'], 'surname' => $_SESSION['surname']];
} else
    $userDetails = ['name' => $_SESSION['name'], 'surname' => $_SESSION['surname']];


?>
<div id="selectDateContainer" style="margin-bottom: 7px;">
    <input type="text" name="dateSelector" id="dateSelector">
    <input type="button" class="btn btn-primary" id="showBtn" value="Afficher">
</div>

<script src="source/include/technic_pages/js/add_production_monitoring.js"></script>
<script>
    const CurrentStockPreform05 = <?php echo json_encode(count($currentPreformStock) > 0 ? $currentPreformStock[0] : 0) ?>;
    const CurrentStockPreform19 = <?php echo json_encode(count($currentPreformStock) > 0 ? $currentPreformStock[1] : 0) ?>;
    const CurrentStockBottle05 = <?php echo json_encode(count($currentBottleStock) > 0 ? $currentBottleStock[0] : 0) ?>;
    const CurrentStockBottle19 = <?php echo json_encode(count($currentBottleStock) > 0 ? $currentBottleStock[1] : 0) ?>;
    const HasRecord = <?php echo json_encode($hasRecord); ?>;
    const dateSelected = <?php echo json_encode($date); ?>;
    $(document).ready(function(){
        document.getElementById("dateSelector").value = "Production du " + new Date(<?php echo json_encode($date); ?>).frenchDate();
    });
</script>

<div class="tg-wrap">
    <form action="source/model/technic/M_add_production_monitoring.php" method="POST">
        <table id="tg-WnK7G" class="tg table" style="table-layout: fixed; width: 750px">
            <colgroup>
                <col style="width: 350px">
                <col style="width: 200px">
                <col style="width: 200px">
            </colgroup>
            <tr>
                <td class="tg-unkg" colspan="3"><span style="font-weight:bold">FEUILLE
                        DE SUIVI DE PRODUCTION</span></td>
            </tr>
            <tr>
                <td class="tg-dc05">Date :
                    <script>document.write(new Date(<?php echo json_encode($date); ?>).frenchDate());</script>
                    <input type="hidden" name="currentDate" id="currentDate"
                        value="<?php echo $date; ?>">
                    <input type="hidden" name="form_state" value="<?php echo ($hasRecord) ? 1 : 0; ?>">
=======
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
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
                </td>
                <td class="tg-0big">Bouteille 0,5L</td>
                <td class="tg-ugu0">Bouteille 19L</td>
            </tr>
            <tr>
                <td class="tg-dc05">Stock de Pre&#769;forme:</td>
                <td class="tg-fm9z" style="background-color:darkgray !important">
<<<<<<< HEAD
                    <input class="technicalProduction_input" type="text" id="prevStockPreform05"
                        disabled>
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input class="technicalProduction_input" type="text" id="prevStockPreform19"
                        disabled>
=======
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform05">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockPreform19">
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
                </td>
            </tr>
            <tr>
                <td class="tg-dc05">Stock de Bouteilles:</td>
                <td class="tg-fm9z" style="background-color:darkgray !important">
<<<<<<< HEAD
                    <input class="technicalProduction_input" type="text" id="prevStockBottle05"
                        disabled>
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input class="technicalProduction_input" type="text" id="prevStockBottle19"
                        disabled>
=======
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle05">
                </td>
                <td class="tg-73ax" style="background-color:darkgray !important">
                    <input style="background-color:darkgray !important;border:none;color:black" type="text" id="prevStockBottle19">
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
                </td>
            </tr>
            <tr>
                <td class="tg-dc05">Conducteurs:</td>
<<<<<<< HEAD
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input"
                        name="conduc05" id="conduc05" value="<?php echo $userDetails['surname'] . ' ' . $userDetails['name']; ?>"
                        disabled></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input"
                        name="conduc19" id="conduc19" value="<?php echo $userDetails['surname'] . ' ' . $userDetails['name']; ?>"
                        disabled></td>
                <input type="hidden" name="conductor" value="<?php echo ($hasRecord) ? $currentData[0] : $_SESSION['status']; ?>" >
            </tr>
            <tr>
                <td class="tg-dc05">Heure de Début</td>
                <td class="tg-fm9z"><input type="time" class="technicalProduction_input"
                        name="start05" id="start05" value="<?php echo ($hasRecord) ? $currentData[2] : "08:00:00"; ?>" autocomplete="off"></td>
                <td class="tg-73ax"><input type="time" class="technicalProduction_input"
                        name="start19" id="start19" value="<?php echo ($hasRecord) ? $currentData[3] : "08:00:00"; ?>" autocomplete="off"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Heure de Fin</td>
                <td class="tg-fm9z"><input type="time" class="technicalProduction_input"
                        name="end05" id="end05" value="<?php echo ($hasRecord) ? $currentData[4] : "16:30:00"; ?>"></td>
                <td class="tg-73ax"><input type="time" class="technicalProduction_input"
                        name="end19" id="end19" value="<?php echo ($hasRecord) ? $currentData[5] : "16:30:00"; ?>"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Quantité Produite</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input"
                        name="produc05" id="produc05" value="<?php echo ($hasRecord) ? $currentData[6] : ""; ?>"
                        autocomplete="off"></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input"
                        name="produc19" id="produc19" value="<?php echo ($hasRecord) ? $currentData[7] : ""; ?>"
                        autocomplete="off"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Total de bouteilles disponibles</td>
                <td class="tg-fm9z" style="background-color: darkgray;"><input
                        type="text" class="technicalProduction_input" name="totalBottle05"
                        id="totalBottle05" value="" disabled></td>
                <td class="tg-73ax" style="background-color: darkgray;"><input
                        type="text" class="technicalProduction_input" name="totalBottle19"
                        id="totalBottle19" value="" disabled></td>
            </tr>
            <tr>
                <td class="tg-dc05">Quantité Livrée</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input"
                        name="deliv05" id="deliv05" value="<?php echo ($hasRecord) ? $currentData[8] : ""; ?>"
                        autocomplete="off"></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input"
                        name="deliv19" id="deliv19" value="<?php echo ($hasRecord) ? $currentData[9] : ""; ?>"
                        autocomplete="off"></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nombre de Rebus</td>
                <td class="tg-fm9z"><input type="text" class="technicalProduction_input"
                        name="rebus05" id="rebus05" value="<?php echo ($hasRecord) ? $currentData[10] : ""; ?>"
                        autocomplete="off"></td>
                <td class="tg-73ax"><input type="text" class="technicalProduction_input"
                        name="rebus19" id="rebus19" value="<?php echo ($hasRecord) ? $currentData[11] : ""; ?>"
                        autocomplete="off"></td>
=======
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
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
            </tr>
            <tr>
                <td class="tg-dc05">Nouveau stock de Pre&#769;forme</td>
                <td class="tg-fm9z" style="background-color: darkgray;">
<<<<<<< HEAD
                    <input type="text" class="technicalProduction_input" name="newPreformStock05"
                        id="newPreformStock05" disabled></td>
                <td class="tg-73ax" style="background-color: darkgray;">
                    <input type="text" class="technicalProduction_input" name="newPreformStock19"
                        id="newPreformStock19" disabled></td>
            </tr>
            <tr>
                <td class="tg-dc05">Nouveau stock de Bouteilles</td>
                <td class="tg-fm9z" style="background-color: darkgray;"><input
                        type="text" class="technicalProduction_input" name="newBottleStock05"
                        id="newBottleStock05" disabled></td>
                <td class="tg-73ax" style="background-color: darkgray;"><input
                        type="text" class="technicalProduction_input" name="newBottleStock19"
                        id="newBottleStock19" disabled></td>
            </tr>
            <tr>
                <td class="tg-mv9o">Visa Chef de Ligne</td>
                <td class="tg-jtts"><input type="text" class="technicalProduction_input"
                        name="visa05" id="visa05" <?php echo ($hasRecord &&
                                                        strlen($currentData[12]) > 0) ? 'value="' .
                                                        $currentData[12] . '"' : 'placeholder="RAS"' ?>
                    autocomplete="off"></td>
                <td class="tg-ayio"><input type="text" class="technicalProduction_input"
                        name="visa19" id="visa19" <?php echo ($hasRecord &&
                                                        strlen($currentData[13]) > 0) ? 'value="' .
                                                        $currentData[13] . '"' : 'placeholder="RAS"' ?>
                    autocomplete="off"></td>
            </tr>
            <tr>
                <td class="tg-mv9o">Responsable</td>
                <td class="tg-jtts"><input type="text" class="technicalProduction_input"
                        name="resp05" id="resp05" <?php echo ($hasRecord &&
                                                        strlen($currentData[14]) > 0) ? 'value="' .
                                                        $currentData[14] . '"' : 'placeholder="Abdoulaye Niang"';
                                                    ?> autocomplete="off"></td>
                <td class="tg-ayio"><input type="text" class="technicalProduction_input"
                        name="resp19" id="resp19" <?php echo ($hasRecord &&
                                                        strlen($currentData[15]) > 0) ? 'value="' .
                                                        $currentData[15] . '"' : 'placeholder="Abdoulaye Niang"';
                                                    ?> autocomplete="off"></td>
            </tr>
        </table>
        <input type="button" name="submitProductionMonitoring" class="submitBtnProduction"
            onclick="formValidation();" value="<?php echo ($hasRecord) ? "
            Mettre à jour" : "Enregistrer"; ?>" >
    </form>
</div>
=======
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
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
