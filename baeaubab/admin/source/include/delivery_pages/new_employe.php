<?php
    require('source/model/delivery/M_new_employe.php');
    $matricule = get_matricule();
?>

<div class="delivery_employe_container new-emp-page">

    <p class="delivery-employe-title">
        Ajout d'un nouvel employe&#769;
    </p>

    <form style="width:500px" method="post" action="source/model/delivery/M_new_employe">

        <div class="new-emplo-input-group">
            <input type="text" name="matricule" id="matricule" value="Matricule : <?php echo $matricule;?>" readonly>
        </div>

        <div class="new-emplo-input-group">
            <input type="text" name="nom" id="nom" placeholder="Entrer le nom" required>
        </div>

        <div class="new-emplo-input-group">
            <input type="text" name="prenom" id="prenom" placeholder="Entrer le pre&#769;nom" required>
        </div>

        <div class="new-emplo-input-group">
            <select name="fonction" id="fonction" required>
                <option value="">Se&#769;lectionner une fonction</option>
                <option value="1">Chauffeur</option>
                <option value="2">Livreur</option>
                <option value="3">Aide livreur</option>
            </select>
        </div>

        <input class="btn btn-primary submit_new_emp" type="submit" name="submit_new_emp" value="Ajouter">
    </form>

</div>

<style>
    footer {
        position: absolute;
        bottom: 0
    }

</style>
