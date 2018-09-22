<?php

function get_list_employe(){
    require_once("source/model/init.php");
    $bd = connect();
    $query = "select id_personel as id, nom, prenom, poste, matricule from personel_livraison";
    $req = $bd->prepare($query);
    $req->execute(array());
    $list = [];
    while($data=$req->fetch(PDO::FETCH_ASSOC))
        array_push($list, [$data['id'], $data['nom'], $data['prenom'], $data['poste'], $data['matricule']]);
    
    return $list;
}

if(isset($_POST) and isset($_POST['submit_edit_emp'])){
    extract($_POST);
    $nom = ucfirst(filter_var($nom, FILTER_SANITIZE_STRING));
    $prenom = ucfirst(filter_var($prenom, FILTER_SANITIZE_STRING));
    $fonction = filter_var($fonction, FILTER_SANITIZE_STRING);
    $id = filter_var($id_selected, FILTER_SANITIZE_STRING);
    require_once("../init.php");
    $bd = connect();
    $query = "UPDATE personel_livraison set nom=?, prenom=?, poste=? where id_personel=?";
    $req=$bd->prepare($query);
    if($req->execute(array($nom, $prenom, $fonction, $id)))
        header("location: ../../../delivery_homepage.php?edit_employe&edit_emp_status=succes");
    else
        header("location: ../../../delivery_homepage.php?edit_employe&edit_emp_status=fail");
}
?>
