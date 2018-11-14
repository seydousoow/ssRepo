<?php
<<<<<<< HEAD
function get_list()
{
=======


function get_list(){
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
    require("source/model/init.php");
    $bd = connect();

    $query = "select id_personel as id, nom, prenom, matricule, intitule as poste from personel_livraison inner join poste_livraison on personel_livraison.poste=poste_livraison.id_poste order by nom, prenom";
<<<<<<< HEAD

    $req = $bd->prepare($query);
    $req->execute(array());
    $list = [];

    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        array_push($list, [$data['id'], $data['nom'], $data['prenom'], $data['poste'], $data['matricule']]);
=======
    
    $req = $bd -> prepare($query);
    $req->execute(array());
    $list = [];
    
    while($data = $req -> fetch(PDO::FETCH_ASSOC)){
        array_push($list, [$data['id'], $data['nom'], $data['prenom'], $data['poste'], $data['matricule'] ]);
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
    }
    return $list;
}
?>
