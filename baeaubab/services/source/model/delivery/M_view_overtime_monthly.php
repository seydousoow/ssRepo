<?php

require_once("source/model/init.php");

function get_list_matricule_overtime($monthIndex, $numberday){
    $firstDate = date("Y")."-$monthIndex-01";
    $lastDate = date("Y")."-$monthIndex-$numberday";
    $bd = connect();
    
    $sql = "select distinct(matricule) as matricule from delivery_overtime where date between ? and ? order BY matricule";
    
    $req = $bd->prepare($sql);
    $req->execute(array($firstDate, $lastDate));
    $listMatricule = [];
    while($data=$req->fetch(PDO::FETCH_ASSOC))
        array_push($listMatricule, $data['matricule']);
    
    if(sizeOf($listMatricule) > 0)
        return $listMatricule;
    else
        return null;
}

function get_employe_details($listMatricule){
    $bd= connect();
    $sql = "select nom, prenom, intitule as poste from personel_livraison inner join poste_livraison on personel_livraison.poste=poste_livraison.id_poste where matricule=?";
    $list = [];
    foreach($listMatricule as $matricule){
        $req = $bd->prepare($sql);
        $req->execute(array($matricule));
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
            array_push($list, [$data['prenom'], $data['nom'], $data['poste']]);
        }
    }
    return $list;
}

function get_employe_overtime($listMatricule, $monthIndex, $numberday){
    $firstDate = date("Y")."-$monthIndex-01";
    $lastDate = date("Y")."-$monthIndex-$numberday";
    $bd= connect();
    $sql = "select sum(nbr_overtime) as overtime from delivery_overtime where matricule = ? and date between ? and ?";
    $list = [];
    foreach($listMatricule as $matricule){
        $req = $bd->prepare($sql);
        $req->execute(array($matricule, $firstDate, $lastDate));
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
            array_push($list, $data['overtime']);
        }
    }
    return $list;
    
}
