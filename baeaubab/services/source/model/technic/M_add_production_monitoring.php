<?php
require_once("../init.php");
if(isset($_POST)){
    //sanitize the $_POST
    //filter_var_array($_POST, FILTER_SANITIZE_STRING);
    var_dump($_POST);
    extract($_POST);

    //check if the query should be an update or an insert
    $currentDate = date("Y-m-d");
    $sql = checkQuery($currentDate);

    //transaction to db
    try{
        $bd = connect();
        //start the transaction
        $bd->beginTransaction();
        
        //insert into production monitoring
        $req = $bd->prepare($sql);
        $req->execute(array($currentDate, $conduc05, $conduc19, $start05, $start19, $end05, $end19, $produc05, $produc19, $deliv05, $deliv19, $rebus05, $rebus19, $visa05, $visa19, $resp05, $resp19));
        
        //update the stock of the preforms
        $req = $bd ->prepare("INSERT INTO `production_preform_stock`(`date`, `stock05`, `stock19`) VALUES (?, ?, ?)");
        $req->execute(array($currentDate, $newPreformStock05, $newPreformStock19));
        //update the stock of the bottles
        $req = $bd ->prepare("INSERT INTO `production_bottle_stock`(`date`, `stock05`, `stock19`) VALUES (?, ?, ?)");
        $req->execute(array($currentDate, $newBottleStock05, $newBottleStock19));

        //if erything is aight, commit the transaction
        $bd->commit();
        header("location: ../../../technic_homepage.php?add=success");
    }
    catch(Exception $e){
        //on annule la transation
        $pdo->rollback();
        //on affiche un message d'erreur ainsi que les erreurs
        echo 'Tout ne s\'est pas bien passé, voir les erreurs ci-dessous<br />';    
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
        //on arrête l'exécution s'il y a du code après
        exit();
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