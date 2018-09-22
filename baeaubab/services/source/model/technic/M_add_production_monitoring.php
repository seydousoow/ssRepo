<?php
require_once("../init.php");
if(isset($_POST['currentDate'])){
    //sanitize the $_POST
    //filter_var_array($_POST, FILTER_SANITIZE_STRING);
    extract($_POST);

    //check if the query should be an update or an insert
    $currentDate = date("Y-m-d");

    //transaction to db
    try{
        $bd = connect();
        //start the transaction
        $bd->beginTransaction();
        
        //insert into production monitoring
        $sql = checkQuery($currentDate);
        $req = $bd->prepare($sql);
        $req->execute(array($currentDate, $conduc05, $conduc19, $start05, $start19, $end05, $end19, $produc05, $produc19, $deliv05, $deliv19, $rebus05, $rebus19, $visa05, $visa19, $resp05, $resp19));
        
        //do an update instead of an insert
        if(isset($old_form)){
            $sql2 = "UPDATE `production_preform_stock` SET `date`=?, `stock05`=?,`stock19`=? WHERE `id_stock_preforme`=(select id_stock_preforme from (select * from production_preform_stock) AS m ORDER by id_stock_preforme DESC limit 1)";
            $sql3 = "UPDATE `production_bottle_stock` SET `date`=?, `stock05`=?,`stock19`=? WHERE `id_bottle_stock`=(select id_bottle_stock from (select * from production_bottle_stock) AS m ORDER by id_bottle_stock DESC limit 1)";
        }
        else{
            $sql2 = "INSERT INTO `production_preform_stock`(`date`, `stock05`, `stock19`) VALUES (?, ?, ?)";
            $sql3 = "INSERT INTO `production_bottle_stock`(`date`, `stock05`, `stock19`) VALUES (?, ?, ?)";
        }

        //update the stock of the preforms
        $req = $bd ->prepare($sql2);
        $req->execute(array($currentDate, $newPreformStock05, $newPreformStock19));
        //update the stock of the bottles
        $req = $bd ->prepare($sql3);
        $req->execute(array($currentDate, $newBottleStock05, $newBottleStock19));

        //if erything is aight, commit the transaction
        $bd->commit();
        header("location: ../../../technic_homepage.php?production_monitoring&action=new&add=success");
    }
    catch(Exception $e){
        //on annule la transation
        $bd->rollback();
        //on affiche un message d'erreur ainsi que les erreurs
        //echo 'Tout ne s\'est pas bien passé, voir les erreurs ci-dessous<br />';    
        //echo 'Erreur : '.$e.'<br />';
        //echo 'N° : '.$e->getCode();
        //on arrête l'exécution s'il y a du code après
        //exit();
        header("location: ../../../technic_homepage.php?production_monitoring&action=new&add=error&code=".$e->getCode());        
    }
}

function checkQuery($date){
    $bd=connect();
    $req = $bd->prepare("select id_monitoring from production_monitoring where date = ?");
    $req -> execute(array($date));
    if($req->rowCount() < 1)
        return "INSERT INTO `production_monitoring`(`id_monitoring`, `date`, `conducteur05`, `conducteur19`, `starting_time05`, `starting_time19`, `ending_time05`, `ending_time19`, `production05`, `production19`, `delivery05`, `delivery19`, `rebus05`, `rebus19`, `visa05`, `visa19`, `responsable05`, `responsable19`) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    else{
        while($data=$req->fetch(PDO::FETCH_ASSOC))  
            return "UPDATE `production_monitoring` SET `date`=?, `conducteur05`=?, `conducteur19`=?, `starting_time05`=?, `starting_time19`=?, `ending_time05`=?, `ending_time19`=?, `production05`=?, `production19`=?, `delivery05`=?, `delivery19`=?, `rebus05`=?, `rebus19`=?, `visa05`=?, `visa19`=?, `responsable05`=?, `responsable19`=? WHERE id_monitoring = ".$data['id_monitoring'];
    }
}