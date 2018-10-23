<?php
require_once("../init.php");
if (isset($_POST['currentDate'])) {
    //sanitize the $_POST
    extract($_POST);

    //sanitize et set empty variables to zero or empty string
    $currentDate = (strlen($currentDate) > 0) ? filter_var($currentDate, FILTER_SANITIZE_NUMBER_INT) : date("Y-m-d");
    $conductor = filter_var($conductor, FILTER_SANITIZE_NUMBER_INT);
    $start05 = (strlen($start05) > 0) ? substr(filter_var($start05, FILTER_SANITIZE_STRING), 0, -3) : "00:00";
    $start19 = (strlen($start19) > 0) ? substr(filter_var($start19, FILTER_SANITIZE_STRING), 0, -3) : "00:00";
    $end05 = (strlen($end05) > 0) ? substr(filter_var($end05, FILTER_SANITIZE_STRING), 0, -3) : "00:00";
    $end19 = (strlen($end19) > 0) ? substr(filter_var($end19, FILTER_SANITIZE_STRING), 0, -3) : "00:00";
    $produc05 = (strlen($produc05) > 0) ? filter_var($produc05, FILTER_SANITIZE_NUMBER_INT) : 0;
    $produc19 = (strlen($produc19) > 0) ? filter_var($produc19, FILTER_SANITIZE_NUMBER_INT) : 0;
    $deliv05 = (strlen($deliv05) > 0) ? filter_var($deliv05, FILTER_SANITIZE_NUMBER_INT) : 0;
    $deliv19 = (strlen($deliv19) > 0) ? filter_var($deliv19, FILTER_SANITIZE_NUMBER_INT) : 0;
    $rebus05 = (strlen($rebus05) > 0) ? filter_var($rebus05, FILTER_SANITIZE_NUMBER_INT) : 0;
    $rebus19 = (strlen($rebus19) > 0) ? filter_var($rebus19, FILTER_SANITIZE_NUMBER_INT) : 0;
    $newPreformStock05 = (strlen($newPreformStock05) > 0) ? filter_var($newPreformStock05, FILTER_SANITIZE_NUMBER_INT) : 0;
    $newPreformStock19 = (strlen($newPreformStock19) > 0) ? filter_var($newPreformStock19, FILTER_SANITIZE_NUMBER_INT) : 0;
    $newBottleStock05 = (strlen($newBottleStock05) > 0) ? filter_var($newBottleStock05, FILTER_SANITIZE_NUMBER_INT) : 0;
    $newBottleStock19 = (strlen($newBottleStock19) > 0) ? filter_var($newBottleStock19, FILTER_SANITIZE_NUMBER_INT) : 0;
    $visa05 = (strlen($visa05) > 0) ? filter_var($visa05, FILTER_SANITIZE_STRING) : "";
    $visa19 = (strlen($visa19) > 0) ? filter_var($visa19, FILTER_SANITIZE_STRING) : "";
    $resp05 = (strlen($resp05) > 0) ? filter_var($resp05, FILTER_SANITIZE_STRING) : "";
    $resp19 = (strlen($resp19) > 0) ? filter_var($resp19, FILTER_SANITIZE_STRING) : "";

    if ($form_state == 0) {
        //new record
        $sqlBottle = "INSERT INTO `production_bottle_stock`(`date`, `stock05`, `stock19`) VALUES (?, ?, ?)";
        $sqlPreform = "INSERT INTO `production_preform_stock`(`date`, `stock05`, `stock19`) VALUES (?, ?, ?)";
        $sqlProduction = "INSERT INTO `production_monitoring`(`id_monitoring`, `date`, `conducteur05`, `conducteur19`, `starting_time05`, `starting_time19`, `ending_time05`, `ending_time19`, `production05`, `production19`, `delivery05`, `delivery19`, `rebus05`, `rebus19`, `visa05`, `visa19`, `responsable05`, `responsable19`) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    } else {
        //old record
        $sqlPreform = "UPDATE `production_preform_stock` SET `date`=?, `stock05`=?,`stock19`=? WHERE `date`=\"$currentDate\"";
        $sqlBottle = "UPDATE `production_bottle_stock` SET `date`=?, `stock05`=?,`stock19`=? WHERE `date` = \"$currentDate\"";
        $sqlProduction = "UPDATE `production_monitoring` SET `date`=?, `conducteur05`=?, `conducteur19`=?, `starting_time05`=?, `starting_time19`=?, `ending_time05`=?, `ending_time19`=?, `production05`=?, `production19`=?, `delivery05`=?, `delivery19`=?, `rebus05`=?, `rebus19`=?, `visa05`=?, `visa19`=?, `responsable05`=?, `responsable19`=? WHERE `date`=\"$currentDate\"";
    }

    //transaction to db
    try {
        $bd = connect();
        //start the transaction
        $bd->beginTransaction();
        
        //production monitoring
        $req = $bd->prepare($sqlProduction);
        $req->execute(array($currentDate, $conductor, $conductor, $start05, $start19, $end05, $end19, $produc05, $produc19, $deliv05, $deliv19, $rebus05, $rebus19, $visa05, $visa19, $resp05, $resp19));

        //the stock of the preforms
        $req = $bd->prepare($sqlPreform);
        $req->execute(array($currentDate, $newPreformStock05, $newPreformStock19));

        //the stock of the bottles
        $req = $bd->prepare($sqlBottle);
        $req->execute(array($currentDate, $newBottleStock05, $newBottleStock19));

        //if erything is aight, commit the transaction
        $bd->commit();
        header("location: ../../../technic_homepage.php?production_monitoring&action=new&add=success&date=" . $currentDate);
    } catch (Exception $e) {
        //on annule la transation
        $bd->rollback();
        //on affiche un message d'erreur ainsi que les erreurs
        //echo 'Tout ne s\'est pas bien passé, voir les erreurs ci-dessous<br />';    
        //echo 'Erreur : ' . $e->getMessage() . '<br />';
        //echo 'N° : '.$e->getCode();
        //on arrête l'exécution s'il y a du code après
        //exit();
        header("location: ../../../technic_homepage.php?production_monitoring&action=new&add=error&code=" . $e->getCode());
    }
}