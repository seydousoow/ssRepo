<?php

function get_matricule(){
    require_once("source/model/init.php");
    $bd = connect();
    $query = "select matricule from personel_livraison ORDER BY matricule DESC limit 1 ";
    $req = $bd->prepare($query);
    $req->execute(array());
    while($data=$req->fetch(PDO::FETCH_ASSOC))
        $mat = set_new_matricule($data['matricule']);
    return $mat;
}

function set_new_matricule($mat){
    $prev = substr($mat,0,9);
    $num = substr($mat, 9);
    $num = intval($num);
    $num = $num+1;
    
    if((0 <= $num) && ($num <= 9))
        return $prev.'000'.$num;
    else if((10 <= $num) && ($num <= 99))
        return $prev.'00'.$num;
    else if((100 <= $num) && ($num <= 999))
        return $prev.'0'.$num;
}

if(isset($_POST) and isset($_POST['submit_new_emp'])){
    extract($_POST);
    $nom = ucfirst(filter_var($nom, FILTER_SANITIZE_STRING));
    $prenom = ucfirst(filter_var($prenom, FILTER_SANITIZE_STRING));
    $fonction = filter_var($fonction, FILTER_SANITIZE_STRING);
    $matricule = substr(filter_var($matricule, FILTER_SANITIZE_STRING), 12);
    
    require_once("../init.php");
    $bd = connect();
    $query = "insert into personel_livraison (nom, prenom, matricule, poste) values(?,?,?,?)";
    $req=$bd->prepare($query);
    if($req->execute(array($nom, $prenom, $matricule, $fonction)))
        header("location: ../../../delivery_homepage.php?list_employe&add_emp_status=succes");
    else
        header("location: ../../../delivery_homepage.php?new_employe&add_emp_status=fail");
}
