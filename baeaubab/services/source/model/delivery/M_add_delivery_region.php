<?php
if (isset($_POST)) {
    extract($_POST);
    require_once("../init.php");

    //get all the datas entered by the administrator
    $idRegion = filter_var($region, FILTER_SANITIZE_NUMBER_INT);
    //get the name of the region of the sended id
    $nomRegion = getRegionName($idRegion);
    //delete accent and special character
    $nomRegion = str_replace(" ", "_", $nomRegion);
    $nomRegion = str_replace(['ê', 'é', 'è'], "e", $nomRegion);
    //set the table name
    $table = "delivery_line_" . $nomRegion;

    $livreur = strlen($livreur) ? filter_var($livreur, FILTER_SANITIZE_STRING) : "";
    $aide_livreur = filter_var($aideLivreur, FILTER_SANITIZE_STRING);
    $chauffeur = filter_var($chauffeur, FILTER_SANITIZE_STRING);
    $chargee = filter_var($b_charge, FILTER_SANITIZE_NUMBER_INT);
    $livree = filter_var($b_livre, FILTER_SANITIZE_NUMBER_INT);
    $consignee = filter_var($b_consigne, FILTER_SANITIZE_NUMBER_INT);
    $deconsignee = filter_var($b_deconsigne, FILTER_SANITIZE_NUMBER_INT);
    $r_pleine = filter_var($retour_b_pleine, FILTER_SANITIZE_NUMBER_INT);
    $r_vide = filter_var($retour_b_vide, FILTER_SANITIZE_NUMBER_INT);
    $r_pretee = filter_var($retour_b_pretees, FILTER_SANITIZE_NUMBER_INT);
    $pretee = filter_var($b_prete, FILTER_SANITIZE_NUMBER_INT);
    $perce_entrepot = filter_var($b_perce_entrepot, FILTER_SANITIZE_NUMBER_INT);
    $perce_voiture = filter_var($b_perce_voiture, FILTER_SANITIZE_NUMBER_INT);
    $perdue = filter_var($b_perdu, FILTER_SANITIZE_NUMBER_INT);
    $livree_sur_demande = filter_var($c_livre_sur_demande, FILTER_SANITIZE_STRING);
    $remarque = filter_var($rmq, FILTER_SANITIZE_STRING);
    $today = filter_var($date, FILTER_SANITIZE_NUMBER_INT);
    $ligne = filter_var($ligne, FILTER_SANITIZE_NUMBER_INT);

    $temoin = 0;
    //check if there is a record
    if (checkRecord($table, $today) == 1) {
        //a record for the selected date already exists for that region
        $sql = "UPDATE $table set mat_livreur=?, mat_aide_livreur=?, mat_chauffeur=?, b_chargees=?, b_livrees=?, b_consignees=?, b_deconsignees=?, retour_b_pleines=?, retour_b_vides=?, retour_b_pretees=?, b_pretees=?, b_percees_voiture=?, b_percees_entrepot=?, b_perdues=?, client_livre_sur_demande=?, remarques=?, ligne=? where date_delivery=\"$today\"";
        $temoin = 1;
    } else {
        //there is no record for the selected date of that region
        $sql = "INSERT INTO $table (`id`, `date_delivery`, `mat_livreur`, `mat_aide_livreur`, `mat_chauffeur`, `b_chargees`, `b_livrees`, `b_consignees`, `b_deconsignees`, `retour_b_pleines`, `retour_b_vides`, `retour_b_pretees`, `b_pretees`, `b_percees_voiture`, `b_percees_entrepot`, `b_perdues`, `client_livre_sur_demande`, `remarques`, `ligne`) VALUES (NULL, \"$today\", ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }

    $operation = $temoin == 1 ? "update" : "add";

    try {
        //get the connection
        $bd = connect();
        //begin the transaction
        $bd->beginTransaction();
        //insert the datas
        $req = $bd->prepare($sql);
        //executing and checking the status of the insertion
        if ($req->execute(array($livreur, $aide_livreur, $chauffeur, $chargee, $livree, $consignee, $deconsignee, $r_pleine, $r_vide, $r_pretee, $pretee, $perce_voiture, $perce_entrepot, $perdue, $livree_sur_demande, $remarque, $ligne)))
            $state = true;
        else
            $state = false;
        //commit
        $bd->commit();
        //redirect 
        header("location:../../../delivery_homepage.php?new_delivery&operation=$operation&line=$nomRegion&date=$today&state=success");

    } catch (PDOException $e) {
        //cancel the statement if there is an error
        $bd->rollback();
        //show the error
        //echo $e->getMessage();
        header("location:../../../delivery_homepage.php?new_delivery&operation=$operation&line=$nomRegion&date=$today&state=fail");

    }
}

//get the region name
function getRegionName($regionId)
{
    try {
        $bd = connect();
        $sql = "SELECT `nom` FROM `delivery_list_region` WHERE `id_region`=?";
        $req = $bd->prepare($sql);
        $req->execute(array($regionId));
        while ($data = $req->fetch(PDO::FETCH_ASSOC))
            return $data['nom'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//check if there is a record for the selected date in the table
function checkRecord($table, $date)
{
    try {
        $bd = connect();
        $sql = "SELECT `id` from $table where `date_delivery`=?";
        $req = $bd->prepare($sql);
        $req->execute(array($date));
        return ($req->rowCount() > 0) ? 1 : 0;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}