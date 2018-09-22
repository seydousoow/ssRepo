<?php
require_once("source/model/init.php");


function setDate($date){
    date_default_timezone_set("Africa/Dakar");
    $date = date("Y-m")."-".$date;
    return $date;
} 

function get_list_employe(){
    $bd=connect();
    $sql = "SELECT `nom`, `prenom`, `matricule` FROM `personel_livraison` order by matricule";
    $req = $bd->prepare($sql);
    $req ->execute(array());
    $list_employe = []; 
    while($data = $req->fetch(PDO::FETCH_ASSOC)){
        array_push($list_employe, [$data['nom'], $data['prenom'], $data['matricule']]);
    }
    return $list_employe;
}

function get_list_absent_of_date($date){
    $bd=connect();
    $sql = "SELECT `matricule`, `motif` FROM `delivery_absence` WHERE `date_absence`=?";
    $req = $bd->prepare($sql);
    $req ->execute(array($date));
    $list_absence = [];
    while($data = $req->fetch(PDO::FETCH_ASSOC)){
        array_push($list_absence, [$data['matricule'], $data['motif'] ]);
    }
    return $list_absence;
}

