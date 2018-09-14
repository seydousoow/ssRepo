<style>
    footer{
        position: relative !important;
    }

    .table > thead > tr > th,
    .table > tbody > tr > td{
        border :2px solid #375a72 !important;
    }

    .new-emplo-input-group {
        height  : 50px;
        display : flex;
        background-color: unset;
    }

    #n_overtime {

        width         : 10% !important;
        position      : absolute;
        z-index       : 99999;
        right         : 22%;
        padding-left  : 0px;
        padding-right : 20px;
        padding-top   : 4px;
    }

    #overtime-number-label {
        width: 100% !important;
        position: static;
        z-index: 1;
    }

    .swal2-popup{
        right : 43px;
    }
    
    .delivery-employe-title{
        color: #375a72 !important;
        padding-top: 8px;
        padding-bottom: 0px;
        margin-bottom: -18px;
    }
    
        
    .absence-form {
        margin-top: 34px;
    }
    
</style>
<?php
    include("source/model/delivery/M_edit_employe.php");
    $list  = get_list_employe();
    $count = count($list);

?>
<div class="delivery_employe_container new-emp-page">

    <p class="delivery-employe-title">
        Gestion des heures supple&#769;mentaires
    </p>
    <div id="edit-emp-container">
        <div class="edit-cont">
            <p class="delivery-employe-title" style="margin-bottom: -3px;color:#375a72 !important">
                Se&#769;lection l'employe&#769;
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
                De&#769;tails
            </p>

            <form class="absence-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?add_overtime"; ?>">

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
                    <input id="overtime-number-label" value="Nombre d'heures" type="text">
                    <input type="number" name="n_overtime" id="n_overtime" value="0" min="0" max="5" step="0.5">
                </div>

                <input class="btn btn-primary submit_new_absence" type="button" onclick="checkEntities();" name="submit_edit_absence" value="Ajouter">
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

    function checkEntities() {
        if (document.getElementById("matricule_selected").value.length < 1) {
            swal("Erreur", "Aucun employé n'a été sélectionné. Veillez en sélectionner un SVP!", "error");
        } else {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
            });
            var nom = document.getElementById("first_name").value,
                prenom = document.getElementById("last_name").value,
                matricule = document.getElementById("matricule_selected").value,
                nbr_over = document.getElementById("n_overtime").value;

            swalWithBootstrapButtons({
                title: 'CONTINUER ?',
                html: '<b style="font-family:georgia;font-weight:500">Vous êtes sur le point d\'ajouter pour le compte de ' +
                    'l\'employé <span style="font-weight:bolder;color:red">' + prenom + ' ' + nom + '</span> <br/>titulaire du matricule ' +
                    ' <span style="font-weight:bolder;color:red">' + matricule + ', ' + nbr_over + ' heure(s) supplementaires.</span></b>',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmer',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementsByClassName("absence-form")[0].submit();
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swalWithBootstrapButtons('Annulation', 'L\'ajout sur la liste est annule&#769;', 'error')
                }
            });

        }
    }

</script>


<style>
    footer {
        position: fixed;
        bottom: 0;
    }

</style>


<?php
    if(isset($_POST['n_overtime']) && isset($_POST['matricule_selected'])){
        extract($_POST);
        $bd = connect();
        date_default_timezone_set("Africa/dakar");
        $today = date("Y-m-d");

    $sql = "INSERT INTO `delivery_overtime`(date, matricule, nbr_overtime) VALUES (?, ?,?)";
    $req = $bd->prepare($sql);
    if($req ->execute(array($today, $matricule_selected, $n_overtime))){
        ?>
<script>
    swal({
        title: "Enregistré",
        text: "L'enregistrement s'est éffectué avec succés!",
        icon: "success",
        button: "OK",
    });

</script>
<?php
    }
    else {
        ?>
<script>
    swal("Erreur", "Une eerreure s'est produite lors de l'ajout d'heure(s) supplémentaire(s). " +
        "Veuillez rééssayer plus-tard SVP!", "error");

</script>
<?php
    }
    }
?>
