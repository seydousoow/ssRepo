<style>
    #new-delivery-container {
        display: flex;
        flex-direction: row;
        overflow: hidden;
        justify-content: flex-start;
    }
</style>

<?php
//show error
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['operation'])) {
    if ($_GET['operation'] == "add") {
        if ($_GET['state'] == "success") {
            $title = "Enregistré";
            $message = "L'ajout de la ligne " . $_GET['line'] . " du " . $_GET['date'] . " a réussi.";
        } else if ($_GET['state'] == "fail") {
            $title = "Échec";
            $message = "L'ajout de la ligne " . $_GET['line'] . " du " . $_GET['date'] . " a échoué.";
        }
    } else if ($_GET['operation'] == "update") {
        if ($_GET['state'] == "success") {
            $title = "Enregistré";
            $message = "La mise à jour de la ligne " . $_GET['line'] . " du " . $_GET['date'] . " a réussi.";
        } else if ($_GET['state'] == "fail") {
            $title = "Échec";
            $message = "La mise à jour de la ligne " . $_GET['line'] . " du " . $_GET['date'] . " a échoué.";
        }
    } ?>
<script>
    var title = "<?php echo $title; ?>",
            message = "<?php echo $message; ?>";
        swal(title, message, ((title == "Enregistré") ? "success" : "error")).
        then((value) => { location.href = "delivery_homepage.php?new_delivery"; });   
    </script>
<?php

}
?>

<div id="new-delivery-main-container">
    <p class="delivery-employe-title">
        Enregistrement d'une nouvelle livraison
    </p>

    <div id="new-delivery-container">
        <!-- list of name of each column-->
        <?php
        $details = ["Livreur", "Aide Livreur", "Chauffeur", "Bouteilles Charge&#769;es", "Bouteilles Livre&#769;es", "Bouteilles Consigne&#769;es", "Bouteilles De&#769;consigne&#769;es", "Retour Bouteilles Pleines", "Retour Bouteilles Vides", "Retour Bouteilles Pre&#769;te&#769;es", "Bouteilles Pre&#769;te&#769;es", "Bouteilles Perce&#769;es en entrepôt", "Bouteilles Perce&#769;es en voiture", "Bouteilles Perdues", "Client Livre&#769;s sur Demande", "Remarques"];
        ?>
        <!-- fixed table that represent the name of each column -->
        <table id="new-delivery-first-column" class="table table-striped table-sm table-bordered" style="width:230px">
            <thead>
                <tr>
                    <th>Date:
                        <?php date_default_timezone_set("Africa/Dakar");
                        echo date("d-m-Y"); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                for ($i = 0; $i < count($details); $i++) {
                    if ($i >= (count($details) - 2))
                        echo "<tr><td class='theadY-liv' style=\"height: 83.6px;\">$details[$i]</td></tr>";
                    else
                        echo "<tr><td class='theadY-liv' style=\"height: 48.6px;\">$details[$i]</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div id="second-delivery-table-container">
            <table id="new-delivery-table" class="table table-striped table-sm table-bordered">
                <!--table header-->
                <thead>
                    <tr>
                        <?php
                        for ($i = 1; $i < 17; $i++) {
                            if ($i == 16)
                                echo '<th class="thead-liv">Total</th>';
                            else if ($i == 11)
                                echo '<th class="thead-liv">Ligne 10 BIS</th>';
                            else if ($i == 12)
                                echo '<th class="thead-liv">Ligne 11</th>';
                            else if ($i == 13)
                                echo '<th class="thead-liv">Ligne 12</th>';
                            else if ($i == 14)
                                echo '<th class="thead-liv">Ligne Camion</th>';
                            else if ($i == 15)
                                echo '<th class="thead-liv">Ligne Comptoir</th>';
                            else
                                echo '<th class="thead-liv"> Ligne ' . $i . '</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                    for ($i = 0; $i < count($details); $i++) {
                        //create new row
                        echo '<tr>';
                        //iterate all the line including the total line
                        for ($k = 0; $k < 16; $k++) {
                            //creating index fr the numer of each row and each line
                            $num_line = $k + 1;
                            $num_row = $i + 1;
                            //new cell
                            echo '<td>';
                            //if we are pointing to the total column
                            if ($k == 15) {
                                //create total cell for the according row and ignoring non-calculable cell of the current row
                                if ($i > 2 && $i <= 13)
                                    echo '<div class="input-group">
                                        <input type="text" class="form-control line' . $num_line . ' row' . $num_row . '" value="" disabled>
                                      </div>';
                            }
                            //if we are pointing to the three first rows of each line. those are the rows for the selection of each line's employes
                            else if ($i < 3)
                                echo '<div class="input-group">
                                        <input type="text" class="form-control line' . $num_line . ' row' . $num_row . '" value="" readonly disabled>
                                        <div class="input-group-prepend">
                                          <div class="input-group-text" id="btnGroupAddon" ><i class="fas fa-pen sel_line' . $num_line . '" style="pointer-events:none" onclick="selectEmploye(' . $num_line . ', ' . $num_row . ');"></i></div>
                                        </div>
                                      </div>';
                            //if we are pointing to the last two rows of each line. those are the rows for remarques and some slected clients if exist
                            else if ($i > 13)
                                echo '<div class="input-group">
                                        <textarea type="text" class=" form-control line' . $num_line . ' row' . $num_row . '" value="" disabled></textarea>
                                      </div>';
                            //else just create normal row with empty input that will take the numbers of bottles
                            else
                                echo '<div class="input-group">
                                        <input type="text" class="form-control line' . $num_line . ' row' . $num_row . '" value="" disabled>
                                      </div>';

                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                    ?>

                    <tr>
                        <?php
                        //row for the buttons (edit save or cancel the line)
                        for ($i = 0; $i < 15; $i++) {
                            $index = $i + 1;
                            echo '<td class="row-btn">
                                    <div>
                                        <button type="button" id="editer' . $index . '" onclick="edit(' . $index . ')" class="btn btn-primary">Éditer</button>
                                        <button style="display:none" type="button" id="annuler' . $index . '" onclick="annuler(' . $index . ')" class="btn btn-danger">Annuler</button>
                                    </div>
                                </td>';
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="new-delivery-form" method="post" action="source/model/delivery/M_add_delivery.php">
    <input type="hidden" name="livreur" id="form-row1" value="">
    <input type="hidden" name="aideLivreur" id="form-row2" value="">
    <input type="hidden" name="chauffeur" id="form-row3" value="">
    <input type="hidden" name="b_charge" id="form-row4" value="">
    <input type="hidden" name="b_livre" id="form-row5" value="">
    <input type="hidden" name="b_consigne" id="form-row6" value="">
    <input type="hidden" name="b_deconsigne" id="form-row7" value="">
    <input type="hidden" name="retour_b_pleine" id="form-row8" value="">
    <input type="hidden" name="retour_b_vide" id="form-row9" value="">
    <input type="hidden" name="retour_b_pretees" id="form-row10" value="">
    <input type="hidden" name="b_prete" id="form-row11" value="">
    <input type="hidden" name="b_perce_voiture" id="form-row12" value="">
    <input type="hidden" name="b_perce_entrepot" id="form-row13" value="">
    <input type="hidden" name="b_perdu" id="form-row14" value="">
    <input type="hidden" name="c_livre_sur_demande" id="form-row15" value="">
    <input type="hidden" name="rmq" id="form-row16" value="">
    <input type="hidden" name="ligne" id="form-line" value="">
</form>


<!-- Modal content -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modal-title"></h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <div class="input-group">
                <select class="form-control" name="modal-employe" id="modal-employe" required>
                    <option value="">Se&#769;lectionner</option>;
                    <?php
                    require_once("source/model/delivery/M_list_employe.php");
                    $list = get_list();
                    for ($i = 0; $i < count($list); $i++) {
                        echo '<option value="' . $list[$i][4] . '">' . $list[$i][2] . ' ' . $list[$i][1] . '</option>';
                    }
                    ?>
                </select>
                <div class="input-group-prepend">
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="validate-modal">Valider</button>
            <button class="btn btn-danger" id="cancel-modal">Annuler</button>
        </div>
    </div>
</div>


<script>
    var listPreselected = [
        ["2018-liv-0016", "2018-liv-0030", "2018-liv-0029"],
        ["2018-liv-0008", "2018-liv-0025", "2018-liv-0014"],
        ["2018-liv-0018", "2018-liv-0028", "2018-liv-0022"],
        ["2018-liv-0007", "2018-liv-0035", "2018-liv-0004"],
        ["2018-liv-0009", "2018-liv-0032", "2018-liv-0021"],
        ["2018-liv-0012", "2018-liv-0038", "2018-liv-0017"],
        ["2018-liv-0010", "2018-liv-0033", "2018-liv-0011"],
        ["2018-liv-0002", "2018-liv-0037", "2018-liv-0024"],
        ["2018-liv-0006", "2018-liv-0036", "2018-liv-0020"],
        ["2018-liv-0039", "2018-liv-0043", "2018-liv-0003"],
        ["2018-liv-0040", "2018-liv-0043", "2018-liv-0041"],
        ["2018-liv-0015", "2018-liv-0043", "2018-liv-0027"],
        ["2018-liv-0013", "2018-liv-0034", "2018-liv-0031"],
        ["2018-liv-0026", "2018-liv-0043", "2018-liv-0019"],
        ["2018-liv-0042", "2018-liv-0043", "2018-liv-0043"]
    ];
    //set the value for ery line the driver the deliver and the helper
    $(document).ready(function() {
        for (var i = 0; i < 15; i++) {
            for (var j = 0; j < 3; j++) {
                //console.log(listPreselected[i][j]);
                var line = i + 1,
                    row = j + 1;
                selectEmploye(line, row);
                var x = document.getElementById("modal-employe");
                for (var k = 0; k < x.length; k++) {
                    
                    if (x.options[k].value == listPreselected[i][j]) {
                        x.selectedIndex = k;
                        $("#validate-modal").click();
                        document.getElementById('myModal').style.display = "none";
                    }
                }
            }
        }
        document.getElementById('myModal').style.display = "none";
        for (i = 1; i < 4; i++) {
            document.getElementById("form-row" + i).value = "";
        }
    });

    function selectEmploye(line, row) {
        var text = "",
            title = document.getElementById("modal-title");
        if (row == 1)
            text = "Selection du livreur";
        else if (row == 2)
            text = "Selection de l'aide livreur";
        else if (row == 3)
            text = "Selection du Chauffeur";

        title.textContent = text;

        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Open the modal
        modal.style.display = "block";

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        var validate = document.getElementById("validate-modal"),
            cancel = document.getElementById("cancel-modal");

        validate.onclick = function() {
            var choice = document.getElementById("modal-employe"),
                index = choice.selectedIndex;
            var selected_line = document.getElementsByClassName("line" + line + " row" + row)[0];
            selected_line.value = choice.options[index].text;
            document.getElementById("form-row" + row).value = choice.options[index].value;
            modal.style.display = "none";

            var form_row = document.getElementById("form-row" + row);
            form_row.value = choice.value;
            choice.selectedIndex = 0;
        }

        cancel.onclick = function() {
            modal.style.display = "none";
        }
    }

    function edit(index) {
        var test = false;
        var line = null;

        for (var i = 1; i < 16; i++) {
            if (document.getElementById("save" + i)) {
                test = true;
                line = i;
            }
        }

        if (test == false) {
            var line = document.getElementsByClassName("line" + index),
                i = 0;
            for (i = 0; i < line.length; i++) {
                line[i].disabled = false;
            }
            var btn = document.getElementById("editer" + index),
                btn_cancel = document.getElementById("annuler" + index);
            btn_cancel.style.display = "block";
            btn.innerHTML = "Enregistrer";
            btn.removeAttribute("id");
            btn.setAttribute("id", "save" + index);
            btn.removeAttribute("onclick");
            btn.setAttribute("onclick", "save(" + index + ")");

            var choice = document.getElementsByClassName("fa-pen sel_line" + index);
            for (var k = 0; k < choice.length; k++) {
                choice[k].style.pointerEvents = "auto";
                choice[k].style.cursor = "pointer";
            }

        } else if (test == true) {
            alert("la modification de la ligne " + line + " n'est pas encore terminee");
        }
    }

    function save(index) {

        var row = document.getElementsByClassName("line" + index),
            i = 3;
        for (i = 0; i < 3; i++) {
            t = i + 1;
            if (document.getElementById("modal-employe").value.length <= 0) {
                if (row[i].value.length > 0) {
                    var actualRow = document.querySelector(".line" + index + ".row" + t).value.split(" "),
                        list_employe = <?php echo json_encode($list); ?>;

                    for (var p = 0; p < list_employe.length; p++) {
                        if ((list_employe[p][1] == actualRow[1]) && (list_employe[p][2] == actualRow[0]))
                            document.getElementById("form-row" + t).value = list_employe[p][4];
                    }
                }
            }
        }

        for (i = 1; i < 4; i++) {
            t = i - 1;
            var form_equiv = document.getElementById("form-row" + i);
            form_equiv.value = (listPreselected[index - 1][t] != "2018-liv-0043") ? listPreselected[index - 1][t] : "";
        }

        for (i = 3; i < row.length; i++) {
            var t = i + 1;
            var form_equiv = document.getElementById("form-row" + t);
            form_equiv.value = row[i].value;
        }

        document.getElementById("form-line").value = index;
        //document.getElementById("new-delivery-form").submit();
    }

    function annuler(index) {
        swal({
            title: "Annuler",
            text: "Vous êtes sur le point d'annuler vos modification souhaitez-vous continuer ?",
            type: "warning",
            buttons: ["Annuler", "Continuer"],
            dangerMode: false
        }).then((value) => {
            if (value)
                location.href = "delivery_homepage.php?new_delivery";
        });
    }

</script>
<?php
//get data for the fourtheen lines
require_once("source/model/delivery/M_show_data_delivery_page.php");
for ($i = 1; $i < 16; $i++) {
    $data_line["line" . $i] = get_data_today($i);
}
?>

<script>
    var data = <?php echo json_encode($data_line); ?>;
    var list_employe = <?php echo json_encode($list); ?>;
    for (var i = 1; i < 16; i++) {
        if (data['line' + i].length > 0) {
            for (var j = 0; j < 16; j++) {
                t = j + 1;
                var line = document.querySelector(".line" + i + ".row" + t);
                for (x = 0; x < list_employe.length; x++) {
                    if (list_employe[x][4] === data['line' + i][j]) {
                        line.value = list_employe[x][2] + " " + list_employe[x][1];
                        break;
                    } else
                        line.value = data['line' + i][j];
                }
            }
        }
    }

    //calculate the total
    for (var i = 4; i < 15; i++) {
        var row = document.getElementsByClassName("row" + i),
            total = 0;
        for (var j = 0; j < row.length; j++) {
            if (row[j].value.length > 0)
                total = total + parseInt(row[j].value);
        }
        //column that contain the total of each row
        row[row.length - 1].value = total;
    }
</script>
