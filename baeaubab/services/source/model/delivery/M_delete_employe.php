<?php

function get_list_employe(){
    require_once("source/model/init.php");
    $bd = connect();
    $query = "select id_personel as id, nom, prenom, poste from personel_livraison";
    $req = $bd->prepare($query);
    $req->execute(array());
    $list = [];
    while($data=$req->fetch(PDO::FETCH_ASSOC))
        array_push($list, [$data['id'], $data['nom'], $data['prenom'], $data['poste']]);
    
    return $list;
}

if(isset($_POST) and isset($_POST['submit_delete_emp'])){
    extract($_POST);
    $nom = ucfirst(filter_var($nom, FILTER_SANITIZE_STRING));
    $prenom = ucfirst(filter_var($prenom, FILTER_SANITIZE_STRING));
    $fonction = filter_var($fonction, FILTER_SANITIZE_STRING);
    $id = filter_var($id_selected, FILTER_SANITIZE_STRING);
    require_once("../init.php");
    $bd = connect();
    $query = "delete from personel_livraison where poste=? and id_personel=?";
    $req=$bd->prepare($query);
    if($req->execute(array($fonction, $id)))
        header("location: ../../../delivery_homepage.php?delete_employe&del_emp_status=succes");
    else
        header("location: ../../../delivery_homepage.php?delete_employe&del_emp_status=fail");
}
?>
