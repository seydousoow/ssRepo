<?php
//show error
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once('../init.php');
if (isset($_POST)) {
    extract($_POST);

    date_default_timezone_set("Africa/Dakar");
    
    //get all the datas entered by the administrator
    $table = 'delivery_line' . filter_var($ligne, FILTER_SANITIZE_STRING);
    $livreur = filter_var($livreur, FILTER_SANITIZE_STRING);
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
    $today = "2018-10-04";//date("Y-m-d");
    
    //check if we should add or update the current line
    $temoin = check_data($table);
    
    //set the correct sql statement according to the current situation of the actual line
    if ($temoin > 0) {
        //the data for that date already exists
        $sql = "update $table set date_delivery=?, mat_livreur=?, mat_aide_livreur=?, mat_chauffeur=?, b_chargees=?, b_livrees=?, b_consignees=?, b_deconsignees=?, retour_b_pleines=?, retour_b_vides=?, retour_b_pretees=?, b_pretees=?, b_percees_voiture=?, b_percees_entrepot=?, b_perdues=?, client_livre_sur_demande=?, remarques=? where id=$temoin";
    } else {
        //the data for that date doesnt exist
        $sql = "INSERT INTO $table (`id`, `date_delivery`, `mat_livreur`, `mat_aide_livreur`, `mat_chauffeur`, `b_chargees`, `b_livrees`, `b_consignees`, `b_deconsignees`, `retour_b_pleines`, `retour_b_vides`, `retour_b_pretees`, `b_pretees`, `b_percees_voiture`, `b_percees_entrepot`, `b_perdues`, `client_livre_sur_demande`, `remarques`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }
    //insert the datas
    $bd = connect();
    $req = $bd->prepare($sql);
    //executing and checking the status of the insertion
    if ($req->execute(array($today, $livreur, $aide_livreur, $chauffeur, $chargee, $livree, $consignee, $deconsignee, $r_pleine, $r_vide, $r_pretee, $pretee, $perce_voiture, $perce_entrepot, $perdue, $livree_sur_demande, $remarque)))
        $state = true;
    else
        $state = false;
    //redirect 
    if ($state) {
        if (temoin > 0)
            header("location:../../../delivery_homepage.php?new_delivery&operation=update&line=$ligne&date=$today&state=success");
        else
            header("location:../../../delivery_homepage.php?new_delivery&operation=add&line=$ligne&date=$today&state=success");
    } else {
        if (temoin > 0)
            header("location:../../../delivery_homepage.php?new_delivery&operation=update&line=$ligne&date=$today&state=fail");
        else
            header("location:../../../delivery_homepage.php?new_delivery&operation=add&line=$ligne&date=$today&state=fail");
    }

}

function check_data($table_name)
{
    date_default_timezone_set("Africa/Dakar");
    $today = "2018-10-04";//date("Y-m-d");
    $bd = connect();
    $req = $bd->prepare("select id from " . $table_name . " where date_delivery=?");
    $req->execute(array($today));
    if ($req->rowCount() > 0) {
        while ($data = $req->fetch(PDO::FETCH_ASSOC))
            return $data['id'];
    } else
        return "0";
}

function get_data_today($num_line)
{
    $sql = "SELECT `mat_livreur` as a1, `mat_aide_livreur` as a2, `mat_chauffeur` as a3, `b_chargees` as a4, `b_livrees` as a5, `b_consignees` as a6, `b_deconsignees` as a7, `retour_b_pleines` as a8, `retour_b_vides` as a9, `retour_b_pretees` as a10, `b_pretees` as a11, `b_percees_voiture` as a12, `b_percees_entrepot` as a13, `b_perdues` as a14, `client_livre_sur_demande` as a15, `remarques` as a16 FROM `delivery_line$num_line` WHERE `date_delivery`=?";

    date_default_timezone_set("Africa/Dakar");
    $today = "2018-10-04";//date("Y-m-d");
    $bd = connect();

    $req = $bd->prepare($sql);
    $req->execute(array($today));
    $line_data = [];
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        for ($i = 1; $i < 17; $i++)
            array_push($line_data, $data["a$i"]);
    }
    return $line_data;
}