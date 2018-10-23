<div id="delivery-region">
    <?php
    $designations = ["Re&#769;gions", "Livreur", "Aide Livreur", "Chauffeur", "Bouteilles Charge&#769;es", "Bouteilles Livre&#769;es", "Bouteilles Consigne&#769;es", "Bouteilles De&#769;consigne&#769;es", "Retour Bouteilles Pleines", "Retour Bouteilles Vides", "Retour Bouteilles Prê&#769;te&#769;es", "Bouteilles Prê&#769;te&#769;es", "Bouteilles Perce&#769;es en entrepôt", "Bouteilles Perce&#769;es en voiture", "Bouteilles Perdues", "Client Livre&#769;s sur Demande", "Remarques"];
    var_dump($designations);
    ?>
    <div class="tg-wrap">
        <table class="tg" style="width:100%;overflow-x:scroll">
            <colgroup>
                <col style="width: 240px">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 90px">
            </colgroup>
            <tr>
                <th class="tg-j71d" colspan="9"><span style="font-weight:bold;text-decoration:underline">Enregistrement
                        des lignes de livraison du <script>
                            document.write(frenchDateFormat);
                        </script> des autres régions</span></th>
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
                $line = $i + 1;
                echo "<tr>";
                $class = $i % 2 == 0 ? "tg-4mdr" : "tg-9g35";
                echo "<td class=$class>" . $designations[$i] . "</td>";
                if ($i == 0) {
                    echo "<select name='' id='' required>";
                    echo "<option value='unselected'>Se&#769;lection</option>";
                    echo "<option value=''>option</option>";
                    echo "</select>";
                } else if ($i > 0 && $i <= 3) {
                    $j = 0;
                    while ($j <= 6) {
                        echo '<td><div class="input-group">
                                <input type="text" class="form-control" disabled>
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="btnGroupAddon" >
                                        <i class="fas fa-pen" style="pointer-events:none" onclick="">
                                        </i>
                                    </div>
                                </div>
                            </div>
                            </td>';
                        $j++;
                    }
                    echo '<td></td>';
                } else if ($i >= 4 && $i <= 13) {
                    $j = 0;
                    while ($j <= 7) {
                        echo "<td class=$class><input class='form-control' type='text' name='' disabled></td>";
                        $j++;
                    }
                } else {
                    $j = 0;
                    while ($j <= 6) {
                        echo "<td class=$class><textarea class='form-control-plaintext' disabled></textarea></td>";
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
                            <button style="display:none" type="button" id="cancel-region-' . $j . '" class="btn btn-danger">Annuler</button>
                        </div>
                    </td>';
            }
            echo '</tr>';
            ?>
        </table>
    </div>
</div>

<script>
    //if the user click on edit button on one of the edit button
    document.querySelectorAll(".edit-region").forEach(function(element){
        element.addEventListener("click", function(){
            //check if there is an line that is already been edited
            if(document.getElementById("save-region") !== null){
                swal("Erreur","la modification de la ligne n'est pas encore terminee", "error");
            }
            else{
                var element_index = element.id.toString().substr(6);
                document.getElementById(element.id).innerHTML = "Enregistrer";
                document.getElementById(element.id).setAttribute("id", "save-region");
                document.getElementById("cancel-region-"+element_index).style.display = "block";
            }
        });
    });
</script>