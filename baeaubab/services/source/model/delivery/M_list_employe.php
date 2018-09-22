<?php


function get_list(){
    require("source/model/init.php");
    $bd = connect();

    $query = "select id_personel as id, nom, prenom, matricule, intitule as poste from personel_livraison inner join poste_livraison on personel_livraison.poste=poste_livraison.id_poste order by nom, prenom";
    
    $req = $bd -> prepare($query);
    $req->execute(array());
    $list = [];
    
    while($data = $req -> fetch(PDO::FETCH_ASSOC)){
        array_push($list, [$data['id'], $data['nom'], $data['prenom'], $data['poste'], $data['matricule'] ]);
    }
    return $list;
}
?>
