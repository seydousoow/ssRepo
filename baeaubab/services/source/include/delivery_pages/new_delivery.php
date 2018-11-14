<style>
    #new-delivery-container {
        display: flex;
        flex-direction: row;
        overflow: hidden;
        justify-content: flex-start;
    }

    #selectDateContainer {
        display: flex;
        flex-direction: row;
        justify-content: center;
        margin-top: 10px;
    }

    #dateSelector {    
        width: 300px !important;
        text-align: center !important;
        margin-right: 5px !important;
        background-color: white !important;
        color: blueviolet !important;
        font-family: playfair display, Times, georgia, helvetica, serif !important;
        font-size: 15px !important;
        font-weight: bolder !important;
        border: 3px solid blueviolet !important;
        border-radius: 23px !important;
    }

    #showBtn {
        color: white;
        font-family: playfair display, times, georgia, serif;
        font-size: 17px;
        font-weight: bold;
        border: 1px solid blueviolet;
        border-radius: 25px;
        background-color: blueviolet;
    }

    /**************************************new delivery region ********************************/
    .tg {
        border-collapse: collapse;
        border-spacing: 0;
        border-color: #999;
        margin: 0px auto;
    }

    .tg td {
        font-family: Arial, sans-serif;
        font-size: 14px;
        padding: 5px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: #999;
        color: #444;
        background-color: #F7FDFA;
        border: 1px solid blueviolet;
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
        border-color: #999;
        color: #fff;
        background-color: #26ADE4;
    }

    .tg .tg-9g35 {
        background-color: #D2E4FC;
        font-size: 13px;
        font-family: Georgia, serif !important;
        border-color: inherit;
        border: 1px solid blueviolet;
        text-align: left;
    }

    .tg .tg-j71d {
        font-weight: 900;
        font-size: 28px;
        font-style: italic;
        line-height: 0.9;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;
        background-color: #f5f5f5;
        color: #8a2be2;
        border-color: #000000;
        text-align: center
    }

    .tg .tg-iqjh {
        background-color: #3166ff;
        font-weight: bold;
        font-size: 16px;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;
        color: #f7fdfa;
        border-color: #000000;
        text-align: center
    }

    .tg .tg-4mdr {
        font-size: 13px;
        font-family: Georgia, serif !important;
        border-color: inherit;
        text-align: left;
        border: 1px solid blueviolet;
    }

    @media screen and (max-width: 767px) {
        .tg {
            width: auto !important;
        }

        .tg col {
            width: auto !important;
        }

        .tg-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: auto 0px;
        }
    }

    .idRegion{
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size:17px;
        font-weight: 900;
        background-color: grey;
        border: 1px solid blueviolet;
        color: whitesmoke;
    }

</style>

<div id="selectDateContainer" style="margin-bottom: 7px;">
    <input type="text" name="dateSelector" id="dateSelector">
    <input type="button" class="btn btn-primary" id="showBtn" value="Afficher">
</div>

<script src="source/include/delivery_pages/js/add_delivery.js"></script>
<?php
require_once('source/model/delivery/M_set_delivery.php');
?>
<script>
    const frenchDateFormat = new Date(<?php echo json_encode(defaultDate); ?>).frenchDate();
    const numericDateFormat  = <?php echo json_encode(defaultDate); ?>;
    document.getElementById("dateSelector").value = "Livraison du " + frenchDateFormat;
</script>


<div id="new-delivery-main-container">
    <p class="delivery-employe-title">
        Enregistrement des lignes de livraison du <script>document.write(frenchDateFormat);</script>
        de la re&#769;gion de Dakar
    </p>

    <div id="new-delivery-container">
        <!-- list of name of each column-->
        <?php
        $details = ["Livreur", "Aide Livreur", "Chauffeur", "Bouteilles Charge&#769;es", "Bouteilles Livre&#769;es", "Bouteilles Consigne&#769;es", "Bouteilles De&#769;consigne&#769;es", "Retour Bouteilles Pleines", "Retour Bouteilles Vides", "Retour Bouteilles Prê&#769;te&#769;es", "Bouteilles Prê&#769;te&#769;es", "Bouteilles Perce&#769;es en entrepôt", "Bouteilles Perce&#769;es en voiture", "Bouteilles Perdues", "Client Livre&#769;s sur Demande", "Remarques"];
        ?>
        <!-- fixed table that represent the name of each column -->
        <table id="new-delivery-first-column" class="table table-striped table-sm table-bordered"
            style="width:235px">
            <thead>
                <tr>
                    <th>
                        De&#769;signation
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                for ($i = 0; $i < count($details); $i++) {
                    if ($i >= (count($details) - 2))
                        echo "<tr><td class='theadY-liv' style=\"height: 67.6px !important;\">$details[$i]</td></tr>";
                    else
                        echo "<tr><td class='theadY-liv'>$details[$i]</td></tr>";
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
                                        <button type="button" id="editer' . $index . '" onclick="edit(' . $index . ')" class="btn btn-primary edit-delivery-btn">Éditer</button>
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
    <input type="hidden" name="date" id="date" value="<?php echo defaultDate; ?>">
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
                <select class="form-control" name="modal-employe" id="modal-employe"
                    required>
                    <option value="">Se&#769;lectionner</option>;
                    <?php
                    $list = get_list_employe();
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

<?php
require_once("new_delivery_region.php");

//default employes's line setted by delivery responsable
$preselectedEmploye = [
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

//get data for the fourtheen lines
for ($i = 1; $i < 16; $i++) {
    //get the data
    $data_line['line' . $i] = selectedDateData($i, defaultDate);
    //check if there is a record
    if (count($data_line['line' . $i]) > 0) {
        $j = $i - 1;
        $preselectedEmploye[$j][0] = strlen($data_line['line' . $i][0]) > 0 ? $data_line['line' . $i][0] : "2018-liv-0043";
        $preselectedEmploye[$j][1] = strlen($data_line['line' . $i][1]) > 0 ? $data_line['line' . $i][1] : "2018-liv-0043";
        $preselectedEmploye[$j][2] = strlen($data_line['line' . $i][2]) > 0 ? $data_line['line' . $i][2] : "2018-liv-0043";
    }
}
?>

<script>
    var data = <?php echo json_encode($data_line); ?>;
    var list_employe = <?php echo json_encode($preselectedEmploye); ?>;
    var listPreselected = <?php echo json_encode($preselectedEmploye); ?>;
</script>

<script src="source/include/delivery_pages/js/add_delivery_functions.js"></script>
<script src="source/include/delivery_pages/js/delivery_auto_calculation.js"></script>