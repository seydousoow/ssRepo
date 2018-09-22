<?php
include("source/model/delivery/M_delete_employe.php");
$list  = get_list_employe();
$count = count($list);

?>
<div class="delivery_employe_container new-emp-page">

    <p class="delivery-employe-title">
        Modification d'un employe&#769;
    </p>
    <div id="edit-emp-container">
        <div class="edit-cont">
            <p class="delivery-employe-title">
                Se&#769;lectioner l'employe&#769; à supprimer
            </p>

            <div class="input-group edit-input-group">
                <span class="input-group-addon">Recherche&nbsp;</span>
                <input id="filter" onkeyup="filter_name()" type="text" class="form-control" placeholder="Entrez un employe&#769;">
            </div>

            <p class="delivery-employe-title">
                Re&#769;sultat
            </p>

            <div id="edit-result">
                <table id="table" class="table table-hover table-sm table-striped table-edit">
                    <thead>
                        <tr>
                            <th>Pre&#769;nom</th>
                            <th>Nom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        for($i=0;$i<$count;$i++){
                            echo '<tr onclick="selected('.$list[$i][0].')">';
                            echo '<td>'.$list[$i][2].'</td>';
                            echo '<td>'.$list[$i][1].'</td>';
                            echo '<tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="edit-cont">
            <form style="width:500px" method="post" action="source/model/delivery/M_delete_employe.php">

                <p class="delivery-employe-title">
                    De&#769;tails de l'employe&#769; se&#769;lectionner
                </p>

                <div class="new-emplo-input-group">
                    <input type="hidden" name="id_selected" id="id_selected" value="">
                </div>

                <div class="new-emplo-input-group">
                    <input type="text" name="nom" id="last_name" required>
                </div>

                <div class="new-emplo-input-group">
                    <input type="text" name="prenom" id="first_name" required>
                </div>

                <div class="new-emplo-input-group">
                    <select name="fonction" id="fonction" required>
                        <option value=""></option>
                        <option value="1">Chauffeur</option>
                        <option value="2">Livreur</option>
                        <option value="3">Aide livreur</option>
                    </select>
                </div>

                <input class="btn btn-primary submit_new_emp" style="width: 150px;" type="submit" name="submit_delete_emp" value="Supprimer">
            </form>
        </div>
    </div>

</div>

<script>
    function selected(i) {
        var list = <?php echo json_encode($list);?>;
        var choosed_emp = null,
            t = 0,
            nom = document.getElementById("nom"),
            prenom = document.getElementById("prenom");

        for (t = 0; t < list.length; t++) {
            if (list[t][0] == i) {
                first_name.value = list[t][2];
                last_name.value = list[t][1];
                document.getElementById('fonction').options[list[t][3]].selected = "selected";
                document.getElementById("id_selected").value = list[t][0];
            }
        }
    }

    function filter_name() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("filter");
        filter = input.value.toUpperCase();
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            td1 = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

</script>


<style>
    footer {
        position: fixed;
        bottom: 0;
    }

</style>
