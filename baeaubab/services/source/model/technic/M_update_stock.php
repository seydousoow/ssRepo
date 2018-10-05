<?php
if (isset($_POST['newStock05']) && isset($_POST['newStock19'])) {
    extract($_POST);
    $newStock05 = filter_var($newStock05, FILTER_SANITIZE_NUMBER_INT);
    $newStock19 = filter_var($newStock19, FILTER_SANITIZE_NUMBER_INT);
    try {
        require_once("../init.php");
        $bd = connect();
        //check if there is a record for the current date
        $sql = "INSERT INTO `production_preform_stock`(`date`, `stock05`, `stock19`) VALUES (?, ?, ?)";
        //start the transaction
        $bd->beginTransaction();
        $req = $bd->prepare($sql);
        date_default_timezone_set("Africa/Dakar");
        $date = date("Y-m-d");
        $req->execute(array($date, $newStock05, $newStock19));

        $bd->commit();
        //redirection
        header("location: ../../../technic_homepage.php?stock&update=success");
    } catch (Exception $e) {
        //if there is a problem
        $bd->rollback();
        //redirection
        header("location: ../../../technic_homepage.php?stock&update=error&code=" . $e->getCode());
    }
}