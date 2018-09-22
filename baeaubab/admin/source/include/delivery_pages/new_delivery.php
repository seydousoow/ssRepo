<?php
if(isset($_GET['operation'])){
    if($_GET['operation'] == "add"){
        if($_GET['state'] == "success"){
            $title = "Enregistré";
            $message = "L'ajout de la ligne ".$_GET['line']." du ".$_GET['date']." a réussi.";
        }
        else if($_GET['state'] == "fail"){
            $title = "Échec";
            $message = "L'ajout de la ligne ".$_GET['line']." du ".$_GET['date']." a échoué.";
        }
    }
    else if($_GET['operation'] == "update"){
        if($_GET['state'] == "success"){
            $title = "Enregistré";
            $message = "La mise à jour de la ligne ".$_GET['line']." du ".$_GET['date']." a réussi.";
        }
        else if($_GET['state'] == "fail"){
            $title = "Échec";
            $message = "La mise à jour de la ligne ".$_GET['line']." du ".$_GET['date']." a échoué.";
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
    
    <table class="table table-striped table-sm table-bordered">
        <caption>Date : 
        <?php 
            date_default_timezone_set("Africa/Dakar");
            echo date("d-F-Y");
        ?>
        </caption>
        <thead>
            <tr>
                <th class="thead-liv"></th>
                <?php
                for($i=1;$i<14;$i++){
                    if($i==13)
                        echo '<th class="thead-liv">Total</th>';
                    else
                        echo '<th class="thead-liv"> Ligne '.$i.'</th>';
                }
                ?>
            </tr>
        </thead>
        <tbody>

            <?php            
            $details = ["Livreur", "Aide Livreur", "Chauffeur", "Bouteilles Charge&#769;es", "Bouteilles Livre&#769;es", "Bouteilles Consigne&#769;es", "Bouteilles De&#769;consigne&#769;es", "Retour Bouteilles Pleines", "Retour Bouteilles Vides", "Retour Bouteilles Pre&#769;te&#769;es", "Bouteilles Pre&#769;te&#769;es", "Bouteilles Perce&#769;es en entrepôt", "Bouteilles Perce&#769;es en voiture", "Bouteilles Perdues", "Client Livre&#769;s sur Demande", "Remarques"];            
            for($i=0; $i<count($details);$i++){
                echo '<tr>';
                echo '<th scope="col" class="theadY-liv">'.$details[$i].'</td>';
                for($k=0;$k<13;$k++){
                    $num_line = $k+1;
                    $num_row = $i+1;
                    echo '<td>';
                    if($k==12){
                        if($i>2 && $i<=13)
                            echo '<div class="input-group">
                                <input type="text" class=" form-control line'.$num_line.' row'.$num_row.'" value="" disabled>
                              </div>';
                    }
                    else if($i<3)
                        echo '<div class="input-group">
                                <input type="text" class="form-control line'.$num_line.' row'.$num_row.'" value="" disabled>
                                <div class="input-group-prepend">
                                  <div class="input-group-text" id="btnGroupAddon"><i class="fas fa-pen sel_line'.$num_line.'" style="pointer-events:none" onclick="selectEmploye('.$num_line.', '.$num_row.');"></i></div>
                                </div>
                              </div>';
                    else if($i>13)
                        echo '<div class="input-group">
                                <textarea type="text" class=" form-control line'.$num_line.' row'.$num_row.'" value="" disabled></textarea>
                              </div>';
                    else
                        echo '<div class="input-group">
                                <input type="text" class="form-control line'.$num_line.' row'.$num_row.'" value="" disabled>
                              </div>';
                    
                    echo '</td>';
                }
                echo '</tr>';
            }
            ?>
            
            <tr>
                <td></td>
                <?php
                    for($i=0;$i<12;$i++){
                        $index = $i +1;
                        echo '<td class="row-btn">
                            <div>
                                <button type="button" id="editer'.$index.'" onclick="edit('.$index.')" class="btn btn-primary">Éditer</button>
                                <button style="display:none" type="button" id="annuler'.$index.'" onclick="annuler('.$index.')" class="btn btn-danger">Annuler</button>
                            </div>
                        </td>';
                    }
                ?>
            </tr>
        </tbody>
    </table>

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
                    $list=get_list();
                    for($i=0;$i<count($list);$i++){
                        echo '<option value="'.$list[$i][4].'">'.$list[$i][2].' '.$list[$i][1].'</option>';
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
    function selectEmploye(line, row) {
        var text = "",
            title = document.getElementById("modal-title");
        if(row==1)
            text = "Selection du livreur";        
        else if(row==2)
            text = "Selection de l'aide livreur";        
        else if(row==3)
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
        
        validate.onclick = function(){
            var choice = document.getElementById("modal-employe"),
                index = choice.selectedIndex;
            var selected_line = document.getElementsByClassName("line"+line+" row"+row)[0];
            selected_line.value = choice.options[index].text;
            document.getElementById("form-row"+row).value = choice.options[index].value;
            modal.style.display = "none";
            
            var form_row = document.getElementById("form-row"+row);
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

        for (var i = 1; i < 13; i++) {
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
        for(i=0;i<3;i++){
            t=i+1;
            console.log(document.getElementById("modal-employe").value.length);
            if(document.getElementById("modal-employe").value.length <=0){
                if(row[i].value.length > 0){
                    var actualRow = document.querySelector(".line"+index+".row"+t).value.split(" "),
                        list_employe = <?php echo json_encode($list); ?>;
                    for(var p=0;p<list_employe.length;p++){
                        if((list_employe[p][1] == actualRow[1]) && (list_employe[p][2] == actualRow[0]))
                            document.getElementById("form-row" + t).value = list_employe[p][4];
                    }
                }
            }
        }
        
        for (i = 3; i < row.length; i++) {
            var t = i + 1;
            var form_equiv = document.getElementById("form-row" + t);
            form_equiv.value = row[i].value;
        }
        
        document.getElementById("form-line").value = index;
        var temoin = false;
        i=0;
        //check if all the data has been added
        while (i < row.length && temoin == false) {
            var t = i + 1;
            var form_equiv = document.getElementById("form-row" + t);
            if(form_equiv.value.length == 0)
                temoin = true;
            i++;
        }
        if(!temoin)
            document.getElementById("new-delivery-form").submit();
        else
            swal("ERREUR", "Tous les champs sont requis. Assurez-vous de renseigner tous les champs de la ligne sélectionnée. Si une donnée n'est pas disponible, veillez mettre un ZÉRO (0) en lieu et place.", "error");
    }

    function annuler(index) {
        swal({
            title: "Annuler", 
            text : "Vous êtes sur le point d'annuler vos modification souhaitez-vous continuer ?", 
            type : "warning",
            buttons : ["Annuler", "Continuer"],
            dangerMode : true
        }).then((value)=>{
            if(value)
                location.href = "delivery_homepage.php?new_delivery";
        });
    }
    
</script>
<?php
require_once("source/model/delivery/M_show_data_delivery_page.php");
for($i=1;$i<13; $i++){
    $data_line["line".$i] = get_data_today($i);
}
?>

<script>
    var data = <?php echo json_encode($data_line); ?>;
    var list_employe = <?php echo json_encode($list);?>;
    for(var i=1;i<13;i++){
        if(data['line'+i].length >0){
            for(var j=0;j<16;j++){
                t = j+1;
                var line = document.querySelector(".line"+i+".row"+t);
                for(x=0;x<list_employe.length;x++){
                    if(list_employe[x][4] === data['line'+i][j]){
                        line.value = list_employe[x][2]+" "+list_employe[x][1];
                        break;
                    }
                    else
                        line.value = data['line'+i][j];       
                }
            }
        }
    }
</script>

<script>
    //calculate the total
    for(var i=4;i<15;i++){
        var row = document.getElementsByClassName("row"+i),
            total = 0;
        for(var j=0;j<12;j++){
            if(row[j].value.length > 0)
                total = total + parseInt(row[j].value);
        }
        row[12].value = total;
    }

</script>

