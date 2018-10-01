<?php 
if(isset($_POST)){

    extract($_POST);
    $lenprod = filter_var($lenprod, FILTER_SANITIZE_NUMBER_INT);
    $lenmat = filter_var($lenmat, FILTER_SANITIZE_NUMBER_INT);


    $listProduct = $listMaterial = [];

    for($i=0;$i<$lenprod;$i++) {
        if(isset(${'product'.$i}))
            array_push($listProduct, filter_var(${'product'.$i}, FILTER_SANITIZE_SPECIAL_CHARS));}
    
    for($i=0;$i<$lenmat;$i++){
        if(isset(${'material'.$i}))
            array_push($listMaterial, filter_var(${'material'.$i}, FILTER_SANITIZE_SPECIAL_CHARS));}
    
    $stringMaterial = implode(', ', $listMaterial);
    $stringProduct = implode(', ', $listProduct);
    $date = date("Y-m-d", strtotime(filter_var($date, FILTER_SANITIZE_NUMBER_INT)));

    try{
        require_once("../init.php");
        $bd=connect();
        //check if there is a record for the current date
        $sql = "INSERT INTO `technic_used_material_and_product` VALUES (?, ?, ?)";
        //start the transaction
        $bd->beginTransaction();
        $req = $bd ->prepare($sql);
        $req->execute(array($date, $stringMaterial, $stringProduct));
        //if erything is aight, commit the transaction
        $bd->commit();
        //redirection
        header("location: ../../../technic_homepage.php?maintenance&section=mat_prod&action=add&action=add&state=success");
    }catch(PDOException $e){
        //if there is a problem
        $bd->rollback();
        //redirection
        //echo $e->getMessage();
        header("location: ../../../technic_homepage.php?maintenance&section=mat_prod&action=add&action=add&state=error&code=".$e->getCode());
    }
}