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

$sql = "select password from credentials where username = ?";
$req = $bd->prepare($sql);
$req->execute(array($_SESSION['username']));
while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
    define("__ADMIN_PWD__", $data['password']);
}
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
        <td class="tg-0gk5" id="oldStock05">
            <?php echo $preformStock[0]; ?>
        </td>
        <td class="tg-0gk5" id="oldStock19">
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
    aria-labelledby="myModalLabel" aria-hidden="true" sty>
    <div class="modal-dialog cascading-modal modal-avatar modal-lg" role="document">
        <!--Content-->
        <div class="modal-content">

            <!--Header-->
            <div class="modal-header">
                <img src="/services/source/images/icons/update icon .png" style="margin-left:194px"
                    width="100" alt="avatar" class="rounded-circle img-responsive">
            </div>
            <!--Body-->
            <div class="modal-body text-center mb-1">
                <form id="formUpdate" action="/services/source/model/technic/M_update_stock.php"
                    method="post">
                    <table class="tg" style="undefined;table-layout: fixed; width: 489px">
                        <colgroup>
                            <col style="width: 150px">
                            <col style="width: 170px">
                            <col style="width: 170px">
                        </colgroup>
                        <tr>
                            <td class="tg-v988" colspan="3">Mise à jour des
                                stocks
                                de préformes</td>
                        </tr>
                        <tr>
                            <td class="tg-v988">Date: </td>
                            <td class="tg-v988">Format 0,5L</td>
                            <td class="tg-v988">Format 19L</td>
                        </tr>
                        <tr>
                            <td class="tg-v988">Arrivé de stock:<br></td>
                            <td class="tg-k6mb"><input type="text" type="text"
                                    id="addstock05" class="form-control form-control-sm validate ml-0"
                                    autocomplete="off"></td>
                            <td class="tg-k6mb"><input type="text" type="text"
                                    id="addstock19" class="form-control form-control-sm validate ml-0"
                                    autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td class="tg-v988">Nouveau Stock:</td>
                            <td class="tg-iejq"><input type="text" type="text"
                                    id="newStock05" name="newStock05" class="form-control form-control-sm validate ml-0"
                                    value="<?php echo $preformStock[0]; ?>"
                                    readonly></td>
                            <td class="tg-iejq"><input type="text" type="text"
                                    id="newStock19" name="newStock19" class="form-control form-control-sm validate ml-0"
                                    value="<?php echo $preformStock[1]; ?>"
                                    readonly></td>
                        </tr>
                    </table>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary mt-1" type="button" id="validateUpdate">Valider
                            <i class="fa fa-sign-in ml-1"></i></button>
                        <button class="btn btn-danger mt-1" type="button" class="close"
                            data-dismiss="modal" aria-label="Close">Annuler <i
                                class="fa fa-sign-in ml-1"></i></button>
                    </div>
                </form>
            </div>

        </div>
        <!--/.Content-->
    </div>
</div>
<!--Modal: Login with Avatar Form-->

<style type="text/css">
    .modal-lg {
        width: 530px !important;
    }

    .tg {
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0px auto;
    }

    .tg td {
        font-family: Arial, sans-serif;
        font-size: 14px;
        padding: 10px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: black;
    }

    .tg th {
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: normal;
        padding: 10px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: black;
    }

    .tg .tg-iejq {
        background-color: #e8edff;
        color: #ffffff;
        text-align: left;
        vertical-align: top
    }

    .tg .tg-v988 {
        font-size: 14px;
        font-family: Georgia, serif !important;
        ;
        background-color: #800080;
        color: #ffffff;
        border-color: #ffffff;
        text-align: center;
        vertical-align: top
    }

    .tg .tg-818h {
        font-size: 14px;
        font-family: Georgia, serif !important;
        ;
        background-color: #000000;
        color: #ffffff;
        border-color: #ffffff;
        text-align: center
    }

    .tg .tg-k6mb {
        font-size: 16px;
        font-family: Georgia, serif !important;
        ;
        border-color: #000000;
        text-align: center;
        vertical-align: top
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.4/dist/sweetalert2.all.min.js"
    integrity="sha256-qtyU+b249rw/5PQ1KXGRtxjlgg6hfU2EK50YOlc0n50=" crossorigin="anonymous"></script>
<script src="source/include/technic_pages/js/manage_stock.js"></script>