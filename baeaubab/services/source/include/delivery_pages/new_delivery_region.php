<?php
//get list of regions
$listRegion = getListRegions();
//get the list of data that already in the database for the selected date
$listDataRegion = getDataForSelectedDate($listRegion);
?>

<div id="delivery-region">
    <?php
    $designations = ["Re&#769;gion", "Livreur", "Aide Livreur", "Chauffeur", "Bouteilles Charge&#769;es", "Bouteilles Livre&#769;es", "Bouteilles Consigne&#769;es", "Bouteilles De&#769;consigne&#769;es", "Retour Bouteilles Pleines", "Retour Bouteilles Vides", "Retour Bouteilles Prê&#769;te&#769;es", "Bouteilles Prê&#769;te&#769;es", "Bouteilles Perce&#769;es en entrepôt", "Bouteilles Perce&#769;es en voiture", "Bouteilles Perdues", "Client Livre&#769;s sur Demande", "Remarques"];
    ?>
    <div class="tg-wrap">
        <table class="tg table table-responsive" style="width:100%;overflow-x:scroll">
            <colgroup>
                <col style="width: 240px">
                <col style="width: auto">
                <col style="width: auto">
                <col style="width: auto">
                <col style="width: auto">
                <col style="width: auto">
                <col style="width: auto">
                <col style="width: auto">
                <col style="width: 90px">
            </colgroup>
            <tr>
                <th class="tg-j71d" colspan="9"><span style="font-weight:bold;text-decoration:underline">Enregistrement
                        des lignes de livraison du <script>
                            document.write(frenchDateFormat);
                        </script>
                        des autres régions</span></th>
            </tr>

            <tr>
                <td class="tg-iqjh">De&#769;signations</td>
                <td class="tg-iqjh">Ligne </td>
                <td class="tg-iqjh">Ligne</td>
                <td class="tg-iqjh">Ligne</td>
                <td class="tg-iqjh">Ligne</td>
                <td class="tg-iqjh">Ligne</td>
                <td class="tg-iqjh">Ligne</td>
                <td class="tg-iqjh">Ligne</td>
                <td class="tg-iqjh">Total</td>
            </tr>

            <?php 
            for ($i = 0; $i < count($designations); $i++) {
                $row = $i + 1;
                echo "<tr>";
                $class = $i % 2 == 0 ? "tg-4mdr" : "tg-9g35";
                echo "<td class=$class>" . $designations[$i] . "</td>";
                if ($i == 0) {
                    for ($row = 0; $row < 7; $row++) {
                        echo "<td> <select class='idRegion region" . ($row + 1) . "' required disabled>";
                        echo "<option value='unselected'>Se&#769;lection</option>";
                        for ($ele = 0; $ele < count($listRegion); $ele++)
                            echo "<option value=" . $listRegion[$ele]['id'] . ">" . $listRegion[$ele]['nom'] . "</option>";
                        echo "</select> </td>";
                    }
                } else if ($i > 0 && $i <= 3) {
                    $j = 0;
                    while ($j <= 6) {
                        echo '<td><div class="input-group">
                                <input type="text" class="form-control region' . ($j + 1) . ' rowRegion' . $row . '" readonly tabindex="-1" disabled>
                                    <div class="input-group-text fa-pen-region' . ($j + 1) . '" id="btnGroupAddon">
                                        <i class="fas fa-pen fa-pen-region' . ($j + 1) . '" style="pointer-events:none">
                                        </i>
                                    </div>
                                </div>
                            </div>
                            </td>';
                        $j++;
                    }
                    //echo '<td></td>';
                } else if ($i >= 4 && $i <= 14) {
                    $j = 0;
                    while ($j <= 6) {
                        echo "<td class=$class><input class='form-control isInt region" . ($j + 1) . " rowRegion$row' type='text' disabled></td>";
                        $j++;
                    }
                    //total cell
                    echo "<td class=$class><input class='form-control totalRegion rowTotal$row' type='text' disabled></td>";
                } else {
                    $j = 0;
                    while ($j <= 6) {
                        echo "<td class=$class><textarea class='form-control-plaintext region" . ($j + 1) . " rowRegion$row' disabled></textarea></td>";
                        $j++;
                    }
                }
                echo "</tr>";
            }

            //row for the buttons (edit save or cancel the line)
            echo '<tr>';
            echo '<td></td>';
            for ($i = 0; $i < 7; $i++) {
                $j = $i + 1;
                echo '<td class="row-btn">
                        <div>
                            <button type="button" id="region' . $j . '" class="btn btn-primary edit-region">Éditer</button>
                            <button style="display:none" type="button" id="cancel-region-' . $j . '" class="btn btn-danger" onclick="cancelDelivery()">Annuler</button>
                        </div>
                    </td>';
            }
            echo '</tr>';
            ?>
        </table>
    </div>
</div>

<form id="new-delivery-region-form" method="post" action="source/model/delivery/M_add_delivery_region.php">
    <input type="hidden" name="date" id="date" value="<?php echo defaultDate; ?>">
    <input type="hidden" name="region" id="form-region0">
    <input type="hidden" name="livreur" id="form-region1">
    <input type="hidden" name="aideLivreur" id="form-region2">
    <input type="hidden" name="chauffeur" id="form-region3">
    <input type="hidden" name="b_charge" id="form-region4">
    <input type="hidden" name="b_livre" id="form-region5">
    <input type="hidden" name="b_consigne" id="form-region6">
    <input type="hidden" name="b_deconsigne" id="form-region7">
    <input type="hidden" name="retour_b_pleine" id="form-region8">
    <input type="hidden" name="retour_b_vide" id="form-region9">
    <input type="hidden" name="retour_b_pretees" id="form-region10">
    <input type="hidden" name="b_prete" id="form-region11">
    <input type="hidden" name="b_perce_voiture" id="form-region12">
    <input type="hidden" name="b_perce_entrepot" id="form-region13">
    <input type="hidden" name="b_perdu" id="form-region14">
    <input type="hidden" name="c_livre_sur_demande" id="form-region15">
    <input type="hidden" name="rmq" id="form-region16">
    <input type="hidden" name="ligne" id="form-line-region">
</form>

<script>var listData = <?php echo json_encode($listDataRegion); ?>;</script>
<script src="source/include/delivery_pages/js/add_delivery_functions_region.js"></script>
