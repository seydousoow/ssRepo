<script src="js/flatPickR.js"></script>

<div class="flatpickr">
    <input id="flatpickr" placeholder="Se&#769;lectionner une date" class="form-control" data-input>
    <!--    far fa-calendar-alt-->
</div>
<script>
    var selected = null,
        checkingDate = null;

    const flick = flatpickr('#flatpickr', {
        dateFormat: 'd F Y',
        minDate: "01 Septembre 2018",
        maxDate: new Date().fp_incr(7),
        onValueUpdate: function(selectedDates) {
            //format the selected date to match to format in database
            checkingDate = flatpickr.formatDate(selectedDates[0], "Y-m-d");
            sessionStorage.setItem("selected", flatpickr.formatDate(selectedDates[0], "d F Y"));
            //clear the in the table
            clearData();
            //get the data of that correspond to the selected date
            window.location.href = "delivery_homepage.php?view_deliveries&date=" + checkingDate;
        },
    });

    function clearData() {
        for (var i = 0; i < 16; i++) {
            var x = document.querySelectorAll(".line" + i);
            for (var j = 0; j < x.length; j++) {
                x[j].value = "";
            }
        }
    }

</script>



<div id="view_delivery_container">
    <table class="table table-striped table-sm table-bordered table-responsive">
        <thead>
            <tr>
                <th class="thead-liv"></th>
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
                        echo '<th class="thead-liv">Ligne Comptoire</th>';
                    else
                        echo '<th class="thead-liv"> Ligne ' . $i . '</th>';
                }
                ?>
            </tr>
        </thead>
        <tbody>

            <?php 
            $details = ["Bouteilles Charge&#769;es", "Bouteilles Livre&#769;es", "Bouteilles Consigne&#769;es", "Bouteilles De&#769;consigne&#769;es", "Retour Bouteilles Pleines", "Retour Bouteilles Vides", "Retour Bouteilles Pre&#769;te&#769;es", "Bouteilles Pre&#769;te&#769;es", "Bouteilles Perce&#769;es en entrepôt", "Bouteilles Perce&#769;es en voiture", "Bouteilles Perdues", "Client Livre&#769;s sur Demande", "Remarques"];
            for ($i = 0; $i < count($details); $i++) {
                echo '<tr>';
                echo '<th scope="col" class="theadY-liv">' . $details[$i] . '</td>';
                for ($k = 0; $k < 16; $k++) {
                    $num_line = $k + 1;
                    $num_row = $i + 1;
                    //insert a cell
                    if ($k == 15)
                        echo '<td class="total-cell">';
                    else
                        echo '<td>';
                        //cell container
                        //total cell
                    if ($k == 15) {
                        if ($i <= 10)
                            echo '<div class="input-group">
                                    <input type="text" class="form-control line' . $num_line . ' row' . $num_row . '" disabled>
                                  </div>';
                    } else if ($i > 10)
                            //text area
                    echo '<div class="input-group">
                                    <textarea class="form-control line' . $num_line . ' row' . $num_row . '" disabled></textarea>
                                  </div>';

                    else
                        echo '<div class="input-group">
                                    <input type="text" class="form-control line' . $num_line . ' row' . $num_row . '" disabled>
                                  </div>';

                    echo '</td>';
                }
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script>

    function getDataForDate(x) {
        document.getElementById("flatpickr").value = sessionStorage.getItem("selected");
        //sessionStorage.removeItem("selected");
        for (var i = 1; i < 16; i++) {
            var line = document.querySelectorAll(".line" + i);
            for (var j = 0; j < line.length; j++) {
                t = j + 3;
                line[j].value = x[i - 1][t];
            }
        }
        calculateTheTotal();
    }

    //calculate the total for each row
    function calculateTheTotal() {
        for (var i = 1; i < 12; i++) {
            var row = document.getElementsByClassName("row" + i),
                total = 0;
            for (var j = 0; j < row.length-1; j++) {
                if (row[j].value.length > 0)
                    total = total + parseInt(row[j].value);
            }
            //column that contain the total of each row
            row[row.length - 1].value = total;

        }
    }
</script>

<?php 
require_once("source/model/delivery/M_show_data_delivery_page.php");
if (isset($_GET['date']) && $_GET['date'] != "") {
    $data = get_data_per_line($_GET['date']);
    ?>
<script>
    var dat = <?php echo json_encode($data); ?>;
    var data = Object.values(dat);
    getDataForDate(data);

</script>

<?php 
} ?>
