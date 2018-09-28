<?php
require_once("source/model/init.php");
$bd=connect();
$sql = "select stock05, stock19 from production_preform_stock order by date desc limit 1";
$req = $bd->prepare($sql);
$req ->execute(array());
while($data = $req->fetch(PDO::FETCH_ASSOC))
    $preformStock = [$data['stock05'], $data['stock19'] ];

$sql = "select stock05, stock19 from production_bottle_stock order by date desc limit 1";
$req = $bd->prepare($sql);
$req ->execute(array());
while($data = $req->fetch(PDO::FETCH_ASSOC))
    $bottleStock = [$data['stock05'], $data['stock19'] ];
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
            <?php echo $preformStock[0];?>
        </td>
        <td class="tg-0gk5">
            <?php echo $preformStock[1];?>
        </td>
        <td class="tg-0gk5">
            <?php echo $bottleStock[0];?>
        </td>
        <td class="tg-0gk5">
            <?php echo $bottleStock[1];?>
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
            <div class="rectangle_legende"  style="background-color:orange"></div>
            <p>Le niveau de stock est moyen (entre 10000 et 50000)</p>
        </div>
        <div class="legend-container">
            <div class="rectangle_legende" style="background-color:green"></div>
            <p>Le niveau de stock est bon (supe&#769;rieur a&#769; 50000)</p>
        </div>
    </fieldset>

</div>

<button type="button" class="btn btn-success" id="updateStockBtn">Mettre à jour</button>

<script>
    $("#updateStockBtn").on('click', function () {
        location.href = "technic_homepage.php?stock&action=update";
    });
    $(document).ready(function () {
        var stockArea = document.querySelectorAll(".tg-0gk5");
        for (var i = 0; i < 2; i++) {
            var value = stockArea[i].innerHTML;
            stockArea[i].style.color = "white";
            if (value <= 10000) {
                stockArea[i].style.backgroundColor = "red";
            } else if (value > 10000 && value <= 50000)
                stockArea[i].style.backgroundColor = "orange";
            else if (value > 50000)
                stockArea[i].style.backgroundColor = "green";
        }
    });
</script>
