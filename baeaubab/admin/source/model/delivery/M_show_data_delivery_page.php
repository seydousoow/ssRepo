<?php
require_once("source/model/init.php");

function get_data_per_line($date){
    $line_data = [];
    for($i=1;$i<13;$i++){
        $sql = "SELECT `mat_livreur` as a1, `mat_aide_livreur` as a2, `mat_chauffeur` as a3, `b_chargees` as a4, `b_livrees` as a5, `b_consignees` as a6, `b_deconsignees` as a7, `retour_b_pleines` as a8, `retour_b_vides` as a9, `retour_b_pretees` as a10, `b_pretees` as a11, `b_percees_voiture` as a12, `b_percees_entrepot` as a13, `b_perdues` as a14, `client_livre_sur_demande` as a15, `remarques` as a16 FROM `delivery_line$i` WHERE `date_delivery`=?";

        $bd = connect();

        $req = $bd->prepare($sql);
        $req->execute(array($date));
        
        if($req->rowCount() == 0)
            $line_data[$i] = ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "aucune donnees", "aucune donnees" ];
        else if($req->rowCount() > 0){
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
                    $line_data[$i] = [$data["a1"], $data["a2"], $data["a3"], $data["a4"], $data["a5"], $data["a6"], $data["a7"], $data["a8"], $data["a9"], $data["a10"], $data["a11"], $data["a12"], $data["a13"], $data["a14"], $data["a15"], $data["a16"] ];
            }
        }
    }
    return $line_data;
}

function get_data_today($num_line){
    $sql = "SELECT `mat_livreur` as a1, `mat_aide_livreur` as a2, `mat_chauffeur` as a3, `b_chargees` as a4, `b_livrees` as a5, `b_consignees` as a6, `b_deconsignees` as a7, `retour_b_pleines` as a8, `retour_b_vides` as a9, `retour_b_pretees` as a10, `b_pretees` as a11, `b_percees_voiture` as a12, `b_percees_entrepot` as a13, `b_perdues` as a14, `client_livre_sur_demande` as a15, `remarques` as a16 FROM `delivery_line$num_line` WHERE `date_delivery`=?";
    
    date_default_timezone_set("Africa/Dakar");
    $today = date("Y-m-d");
    $bd = connect();
    
    $req = $bd->prepare($sql);
    $req->execute(array($today));
    $line_data = [];
    while($data=$req->fetch(PDO::FETCH_ASSOC)){
        for($i = 1; $i < 17; $i ++)
            array_push($line_data, $data["a$i"]);
    }
    return $line_data;
}
