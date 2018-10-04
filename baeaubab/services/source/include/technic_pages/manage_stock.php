<?php
require_once("source/model/init.php");
$bd = connect();
$sql = "select stock05, stock19 from production_preform_stock order by date desc limit 1";
$req = $bd->prepare($sql);
$req->execute(array());
while ($data = $req->fetch(PDO::FETCH_ASSOC))
    $preformStock = [$data['stock05'], $data['stock19']];

$sql = "select stock05, stock19 from production_bottle_stock order by date desc limit 1";
$req = $bd->prepare($sql);
$req->execute(array());
while ($data = $req->fetch(PDO::FETCH_ASSOC))
    $bottleStock = [$data['stock05'], $data['stock19']];
?>

<table class="tg-view-stock">
    <colgroup>
        <col style="width: 300px">
        <col style="width: 300px">
        <col style="width: 300px">
        <col style="width: 300px">
    </colgroup>
    <tr>
        <th class="tg-fa8a" colspan="4">Stock Actuel</th>
    </tr>
    <tr>
        <td class="tg-smt3" colspan="2">Stock de pre&#769;forme<br></td>
        <td class="tg-smt3" colspan="2">Stock de bouteille</td>
    </tr>
    <tr>
        <td class="tg-52v8">Format 0,5L<br></td>
        <td class="tg-52v8">Format 19L</td>
        <td class="tg-52v8">Format 0,5L</td>
        <td class="tg-52v8">Format 19L</td>
    </tr>
    <tr>
        <td class="tg-0gk5">
            <?php echo $preformStock[0]; ?>
        </td>
        <td class="tg-0gk5">
            <?php echo $preformStock[1]; ?>
        </td>
        <td class="tg-0gk5">
            <?php echo $bottleStock[0]; ?>
        </td>
        <td class="tg-0gk5">
            <?php echo $bottleStock[1]; ?>
        </td>
    </tr>
</table>

<div id="stock-legend">
    <fieldset>
        <legend>Légende : Stock de pre&#769;forme</legend>
        <div class="legend-container">
            <div class="rectangle_legende" style="background-color:red;"></div>
            <p>Le niveau de stock est faible (infe&#769;rieur a&#769; 10000)</p>
        </div>
        <div class="legend-container">
            <div class="rectangle_legende" style="background-color:orange"></div>
            <p>Le niveau de stock est moyen (entre 10000 et 50000)</p>
        </div>
        <div class="legend-container">
            <div class="rectangle_legende" style="background-color:green"></div>
            <p>Le niveau de stock est bon (supe&#769;rieur a&#769; 50000)</p>
        </div>
    </fieldset>

</div>

<button type="button" data-toggle="modal" data-target="#modalLoginAvatar" class="btn btn-success"
    id="updateStockBtn">Mettre à jour</button>

<!--Modal: Login with Avatar Form-->
<div class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
        <!--Content-->
        <div class="modal-content">

            <!--Header-->
            <div class="modal-header">
                <img src="/services/source/images/icons/keypad icon.png" style="margin-left:80px"
                    width="100" alt="avatar" class="rounded-circle img-responsive">
            </div>
            <!--Body-->
            <div class="modal-body text-center mb-1">

                <h5 class="mt-1 mb-2" style="font-size: 14px; font-family: playfair display;">Enter
                    votre mot de passe</h5>

                <div class="md-form ml-0 mr-0">
                    <input type="password" type="text" id="form29" class="form-control form-control-sm validate ml-0">
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-primary mt-1">Valider <i class="fa fa-sign-in ml-1"></i></button>
                    <button class="btn btn-danger mt-1">Annuler <i class="fa fa-sign-in ml-1"></i></button>
                </div>
            </div>

        </div>
        <!--/.Content-->
    </div>
</div>
<!--Modal: Login with Avatar Form-->

<script src="js/manage_stock.js"></script>