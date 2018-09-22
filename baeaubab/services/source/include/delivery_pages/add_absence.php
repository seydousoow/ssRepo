<style>
    footer{
        position: relative !important;
    }
    
    .table > thead > tr > th,
    .table > tbody > tr > td{
        border :2px solid #375a72 !important;
    }
    
</style>
<?php
include("source/model/delivery/M_edit_employe.php");
$list  = get_list_employe();
$count = count($list);

?>
<div class="delivery_employe_container new-emp-page">

    <p class="delivery-employe-title" style="color:#375a72 !important">
        Gestion des absences
    </p>
    <div id="edit-emp-container">
        <div class="edit-cont">
            <p class="delivery-employe-title" style="margin-bottom: -3px;color:#375a72 !important">
                Se&#769;lectioner l'employe&#769; absent
            </p>
            <div class="absence-search">
                <div class="input-group edit-input-group">
                    <span class="input-group-addon" style="color:#375a72 !important">Recherche&nbsp;</span>
                    <input id="filter" onkeyup="filter_name()" type="text" class="form-control" placeholder="Entrez un employe&#769;">
                </div>
                <hr class="search-absence-hr">
                <p class="delivery-employe-title" style="margin: 0px;color:#375a72 !important">
                    Re&#769;sultat
                </p>

                <div id="edit-result" style="height:339px !important;width:100%">
                    <table id="table" class="table table-striped table-hover table-sm table-edit">
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
        </div>

        <div class="edit-cont">
           <p class="delivery-employe-title" style="color:#375a72 !important">
                De&#769;tails de l'absent
            </p>
                
            <form class="absence-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?add_absence"; ?>">

                <div class="new-emplo-input-group">
                    <input type="hidden" name="id_selected" id="id_selected" value="">
                    <input type="text" name="matricule_selected" id="matricule_selected" value="" placeholder="Matricule" readonly>
                </div>

                <div class="new-emplo-input-group">
                    <input type="text" name="nom_selected" id="last_name" placeholder="Nom" readonly>
                </div>

                <div class="new-emplo-input-group">
                    <input type="text" name="prenom_selected" id="first_name" placeholder="Pre&#769;nom" readonly>
                </div>

                <div class="new-emplo-input-group">
                    <select class="absence-select" name="fonction_selected" id="fonction" style="pointer-events: none;" readonly>
                        <option value="" selected>Fonction</option>
                        <option value="1">Chauffeur</option>
                        <option value="2">Livreur</option>
                        <option value="3">Aide livreur</option>
                    </select>
                </div>
                
                <textarea name="motif-absence" id="motif-absence" placeholder="Entrer le motif de l'absence si e&#769;xiste"></textarea>

                <input class="btn btn-primary submit_new_absence" type="button" onclick="checkEntities();" name="submit_edit_absence" value="Ajouter" >
            </form>
        </div>
    </div>

</div>

<!--sweetalert2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.12/dist/sweetalert2.all.min.js"></script>

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
                document.getElementById("matricule_selected").value = list[t][4];
                document.getElementById("first_name").value = list[t][2];
                document.getElementById("last_name").value = list[t][1];
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
    
    function checkEntities(){
        if(document.getElementById("matricule_selected").value.length < 1){
            swal("Erreur", "Aucun employé n'a été sélectionné. Veillez en sélectionner un SVP!", "error");
        }
        else{
            const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: true,
                    });
            var nom = document.getElementById("first_name").value,
                prenom = document.getElementById("last_name").value, 
                matricule = document.getElementById("matricule_selected").value,
                
                today = "<?php setlocale(LC_ALL, "fr_FR.UTF-8"); date_default_timezone_set("Africa/Dakar"); echo date("d F, Y"); ?>";

            swalWithBootstrapButtons({
                title: 'CONTINUER ?',
                html:'<b style="font-family:georgia;font-weight:500">Vous êtes sur le point d\'ajouter l\'employé <span style="font-weight:bolder;color:red">'+prenom+' '+nom+'</span> <br/>titulaire du matricule <span style="font-weight:bolder;color:red">'+matricule+'</span> sur la liste des absents du <span style="font-weight:bolder;color:red">'+today+'</span></b>' ,
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmer',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementsByClassName("absence-form")[0].submit();
                } else if (result.dismiss === swal.DismissReason.cancel){
                swalWithBootstrapButtons('Annulation', 'L\'ajout sur la liste est annule&#769;', 'error' )
                }
            });
            
        }
    }
    
</script>


<style>
    footer{
        position: fixed;
        bottom:0;
    }
</style>


<?php 
if(isset($_POST['motif-absence']) && isset($_POST['matricule_selected'])){
    extract($_POST);
    $motif = filter_var(trim($_POST['motif-absence']), FILTER_SANITIZE_STRING);
    $bd = connect();
    date_default_timezone_set("Africa/Dakar");
    $today = date("Y-m-d");
    
    $sql = "INSERT INTO `delivery_absence`(`matricule`, `date_absence`, `motif`) VALUES (?,?,?)";
    $req = $bd->prepare($sql);
    if($req ->execute(array($matricule_selected, $today, $motif))){
        ?>
        <script>
            swal({
                title: "Enregistré", 
                text: "L'absence de l'employé a été bien ajouté!",
                icon: "success",
                button: "OK",
            });
        </script>
        <?php
    }
    else{
        ?>
        <script>
            swal("Erreur", "Une erreure s'est produite lors de l'ajout de l'absence. Veuillez rééssayer plus-tard SVP!", "error").then(
                (value) => {
                    window.location.href = "delivery_homepage.php?add_absence";
                });
        </script>
        <?php
    }
}
?>