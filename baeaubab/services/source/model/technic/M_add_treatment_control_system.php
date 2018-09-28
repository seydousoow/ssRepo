<?php 
require_once("../init.php");
if(isset($_POST)){
    extract($_POST);
    $table = "water_system_control".filter_var($version, FILTER_SANITIZE_NUMBER_INT) ;
    $date = filter_var ( $date, FILTER_SANITIZE_NUMBER_INT);
    //get the data and sanitizze them all as float
    $arrayData = [];
    foreach($_POST as $key => $value){
        array_push($arrayData, filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT));
    }
    
    try{
        $bd=connect();
        //check if there is a record for the current date
        $sql = getCorrectRequest($date, $table);
        //start the transaction
        $bd->beginTransaction();
        $req = $bd ->prepare($sql);
        

        $req->execute(array($arrayData[2], $arrayData[3], $arrayData[4], $arrayData[5], $arrayData[6], $arrayData[7], $arrayData[8], $arrayData[9], $arrayData[10], $arrayData[11], $arrayData[12], $arrayData[13], $arrayData[14], $arrayData[15], $arrayData[16], $arrayData[17], $arrayData[18], $arrayData[19], $arrayData[20], $arrayData[21] ));
        
        //if erything is aight, commit the transaction
        $bd->commit();
        //redirection
        header("location: ../../../technic_homepage.php?water-treatment&action=new&state=success");
    }catch(PDOException $e){
        //if there is a problem
        $bd->rollback();
        //redirection
        //echo $e->getMessage();
        header("location: ../../../technic_homepage.php?water-treatment&action=new&state=error&code=".$e->getCode());
    }

}

function getCorrectRequest($date, $table){
    $sql = "select date from $table where date=?";
    $bd=connect();
    $req = $bd->prepare($sql);
    $req->execute(array($date));
    if($req->rowCount() > 0){
        return "UPDATE $table SET `pressionPompeIn`=?,`pressionPompeOut`=?,`pressionAmiadeIn`=?,`pressionAmiadeOut`=?,`pressionMacroIn`=?,`pressionMacroOut`=?,`pressionCharbonIn`=?,`pressionCharbonOut`=?, `pressionAdouciIn`=?,`pressionAdouciOut`=?,`dureteBrute`=?,`dureteAdoucie`=?,`dureteOsmosee`=?,`tdsBrute`=?,`tdsAdoucie`=?, `tdsOsmosee1`=?,`tdsOsmosee2`=?,`tdsMineralise`=?,`chloreIn`=?,`chloreOut`=? WHERE `date`=\"$date\"";
    }
    else{
        return "INSERT INTO `$table` (`date`, `pressionPompeIn`, `pressionPompeOut`, `pressionAmiadeIn`, `pressionAmiadeOut`, `pressionMacroIn`, `pressionMacroOut`, `pressionCharbonIn`, `pressionCharbonOut`, `pressionAdouciIn`, `pressionAdouciOut`, `dureteBrute`, `dureteAdoucie`, `dureteOsmosee`, `tdsBrute`, `tdsAdoucie`, `tdsOsmosee1`, `tdsOsmosee2`, `tdsMineralise`, `chloreIn`, `chloreOut`) VALUES (\"$date\", ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }
}