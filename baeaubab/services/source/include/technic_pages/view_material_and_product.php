<style type="text/css">
    .tg {
        border-collapse: collapse;
        border-spacing: 0;
        border-color: #999;
        margin: 0px auto;
    }

    .tg td {
        font-family: Arial, sans-serif;
        font-size: 14px;
        padding: 10px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: #999;
        color: #444;
        background-color: #F7FDFA;
    }

    .tg th {
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: normal;
        padding: 10px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: #999;
        color: #fff;
        background-color: #26ADE4;
    }

    .tg .tg-hmp3 {
        background-color: #D2E4FC;
        text-align: left;
        vertical-align: top
    }

    .tg .tg-7miv {
        font-weight: bold;
        font-size: 16px;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;
        ;
        background-color: #375a72;
        color: #ffffff;
        border-color: inherit;
        text-align: center
    }

    .tg .tg-4x11 {
        background-color: #375a72;
        font-weight: bold;
        font-size: 20px;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;
        ;
        color: #ffffff;
        border-color: inherit;
        text-align: center
    }

    .tg .tg-leys {
        background-color: #375a72;
        font-weight: bold;
        font-size: 20px;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;
        ;
        color: #ffffff;
        border-color: inherit;
        text-align: center;
        vertical-align: top
    }

    .tg .tg-0pky {
        border-color: inherit;
        text-align: left;
        vertical-align: top
    }
</style>

<?php date_default_timezone_set("Africa/Dakar");?>

<div id="selectDateContainer" style="margin-bottom: 7px;">
    <input type="text" name="dateSelector" id="dateSelector" placeholder="<?php 
    echo isset($_GET['date1'])?( isset($_GET['date2']) && strlen($_GET['date2'])>0? Date("
        d-F-Y", strtotime($_GET['date1']))." - ".Date(" d-F-Y", strtotime($_GET['date2'])): Date("d-F-Y",
        strtotime($_GET['date1']))):"Sélectionnez la ou les date(s) à afficher";?>" >
    <input type="button" class="btn btn-primary" id="showBtn" value="Afficher">
</div>
<script src="source/include/technic_pages/js/show_treatment_control_system.js"></script>

<?php 
if(isset($_GET['date1']) && isset($_GET['date2'])){
    //if the first date is valid
    if(validateDate($_GET['date1']) === true){
        require_once("source/model/init.php");
        $bd=connect();
        $table = "water_system_control".filter_var($_GET['sheet'], FILTER_SANITIZE_NUMBER_INT);
        $date1 = filter_var($_GET['date1'], FILTER_SANITIZE_NUMBER_INT);
        //if the second date is valid
        if(validateDate($_GET['date2']) === true){
        $date2 = filter_var($_GET['date2'], FILTER_SANITIZE_NUMBER_INT);
            //the user selected a range
            $sql = "SELECT * FROM $table WHERE `date`>=? and `date` <=? order by `date` asc";
            $req = $bd->prepare($sql);
            $req->execute(array($date1, $date2));
        }
        else{
            //there is only one date to show
            $sql = "select * from $table where date=?";
            $req = $bd->prepare($sql);
            $req->execute(array($date1));
        }
        
        //list of data
        $list = [];
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
            array_push($list, [ $data['date'], $data['pressionPompeIn'], $data['pressionPompeOut'], $data['pressionAmiadeIn'], $data['pressionAmiadeOut'], $data['pressionMacroIn'], $data['pressionMacroOut'], $data['pressionCharbonIn'], $data['pressionCharbonOut'], $data['pressionAdouciIn'], $data['pressionAdouciOut'], $data['dureteBrute'], $data['dureteAdoucie'], $data['dureteOsmosee'], $data['tdsBrute'], $data['tdsAdoucie'], $data['tdsOsmosee1'], $data['tdsOsmosee2'], $data['tdsMineralise'], $data['chloreIn'], $data['chloreOut'] ]);
        }
        
    }
}
?>

<table class="tg" style="undefined;table-layout: fixed; width: 1000px">
<colgroup>
<col style="width: 184px">
<col style="width: 408px">
<col style="width: 408px">
</colgroup>
  <tr>
    <td class="tg-7miv" colspan="3">MATÉRIELS ET PRODUITS UTILISÉS POUR L'ENTRETIEN <br>DES RÉSERVOIRS D'EAU ET DES LIGNE D'EMBOUTEILLAGE</td>
  </tr>
  <tr>
    <td class="tg-4x11">DATE<br></td>
    <td class="tg-leys">PRODUITS</td>
    <td class="tg-leys">MATERIELS</td>
  </tr>
  <tr>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
    <td class="tg-0pky"></td>
  </tr>
  <tr>
    <td class="tg-hmp3"></td>
    <td class="tg-hmp3"></td>
    <td class="tg-hmp3"></td>
  </tr>
</table>