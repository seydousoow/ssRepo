<?php
require("../init.php");

if (isset($_POST)) {
    //extract the datas
    extract($_POST);
    //sanitize the datas
    $date = set_date(filter_var($date, FILTER_SANITIZE_STRING));
    $compteur = filter_var($compteur, FILTER_SANITIZE_NUMBER_INT);
    $m3 = filter_var($m3, FILTER_SANITIZE_NUMBER_INT);
    $OmegaIn = filter_var($OmegaIn, FILTER_SANITIZE_NUMBER_INT);
    $OmegaOut = filter_var($OmegaOut, FILTER_SANITIZE_NUMBER_INT);
    $OmegaMembrane = filter_var($OmegaMembrane, FILTER_SANITIZE_NUMBER_INT);
    $H2OIn = filter_var($H2OIn, FILTER_SANITIZE_NUMBER_INT);
    $H2OOut = filter_var($H2OOut, FILTER_SANITIZE_NUMBER_INT);
    $H2OMembrane = filter_var($H2OMembrane, FILTER_SANITIZE_NUMBER_INT);
    $OmegaPermeate = filter_var($OmegaPermeate, FILTER_SANITIZE_NUMBER_INT);
    $OmegaRejet = filter_var($OmegaRejet, FILTER_SANITIZE_NUMBER_INT);
    $H2OPermeate = filter_var($H2OPermeate, FILTER_SANITIZE_NUMBER_INT);
    $H2ORejet = filter_var($H2ORejet, FILTER_SANITIZE_NUMBER_INT);
    $Air = filter_var($Air, FILTER_SANITIZE_NUMBER_INT);
    $Oxygene = filter_var($Oxygene, FILTER_SANITIZE_NUMBER_INT);


    if (checkRecord($date))
        $sql = "UPDATE `water_purification_system` SET `compteur`=?, `m3`=?, `omega_in`=?, `omega_out`=?, `omega_membrane`=?, `h2o_in`=?, `h2o_out`=?, `h2o_membrane`=?, `omega_permeate`=?, `omega_rejet`=?, `h2o_permeate`=?, `h2o_rejet`=?, `air`=?, `oxygene`=? WHERE `date` = \"$date\"";
    else
        $sql = "INSERT INTO `water_purification_system`(`date`, `compteur`, `m3`, `omega_in`, `omega_out`, `omega_membrane`, `h2o_in`, `h2o_out`, `h2o_membrane`, `omega_permeate`, `omega_rejet`, `h2o_permeate`, `h2o_rejet`, `air`, `oxygene`) VALUES (\"$date\", ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
    try {
        //get the connexion
        $bd = connect();
        //begin a transaction
        $bd->beginTransaction();
        //create a prepared statement
        $req = $bd->prepare($sql);
        //execute the statement
        $req->execute(array($compteur, $m3, $OmegaIn, $OmegaOut, $OmegaMembrane, $H2OIn, $H2OOut, $H2OMembrane, $OmegaPermeate, $OmegaRejet, $H2OPermeate, $H2ORejet, $Air, $Oxygene));
        //commit the transaction
        $bd->commit();
        //redirect
        header("location: ../../../technic_homepage.php?purification-system&action=new&state=success");
    } catch (PDOException $e) {
        //if there is a problem
        $bd->rollback();
        //redirection
        // echo $e->getMessage();
        header("location: ../../../technic_homepage.php?purification-system&action=new&state=error&code=" . $e->getCode());
    }
}

// check if there is a record with the selected date
function checkRecord($date)
{
    try {
        $bd = connect();
        $bd->beginTransaction();
        $req = $bd->prepare("SELECT * FROM `water_purification_system` WHERE `date`=?");
        $req->execute(array($date));
        if ($req->rowCount() > 0)
            $hasrecord = true;
        else
            $hasrecord = false;
        $bd->commit();
    } catch (PDOException $e) {
        //cancel changement that has been made in the database if there is a problem
        $bd->rollback();
        //redirection
        //echo $e->getMessage();
        header("location: ../../../technic_homepage.php?purification-system&action=new&state=error&code=" . $e->getCode());
    }
    return $hasrecord;
}

//edit the date to give it the good format for the database
function set_date($date)
{
    $frenchMonth = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    $englishMonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $dateExplode = explode(" ", $date);
    for ($i = 0; $i < 12; $i++) {
        if ($frenchMonth[$i] == $dateExplode[1]) {
            $month = $i + 1;
            if (strlen($month) == 1) $month = " 0 " . $month;
            return $dateExplode[2] . '-' . $month . '-' . $dateExplode[0];
        }
    }

}


//     pression in out membrane in psi
//     eau pure LBM
//     ozonateur BAR / psi / g / l