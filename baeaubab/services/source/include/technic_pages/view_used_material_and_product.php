<script>
    //date to french
    Date.prototype.frenchDate = function () {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();
        var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
            'Octobre', 'Novembre', 'Décembre'
        ];
        return [(dd > 9 ? '' : '0') + dd,
            month[mm - 1],
            this.getFullYear()

        ].join(' ');
    };
</script>
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

    .prodAndMatList{
        list-style-image: url("source/images/icons/blue validation icon.png");
    }

</style>

<?php date_default_timezone_set("Africa/Dakar");?>

<div id="selectDateContainer" style="margin-bottom: 7px;">
    <p>Sélectionnez une année à afficher</p>
    <select name="dateSelector" id="dateSelector">
        <?php 
        $year = isset($_GET['year'])?$_GET['year']: date("Y");
        for ($i = 2014; $i <= intval(date("Y")); $i++){
            if($i == intval($year))
                echo "<option value=$i selected>$i</option>";
            else 
                echo "<option value=$i>$i</option>";   
        }            
        ?>
    </select>
</div>

<script>
    document.getElementById("dateSelector").addEventListener("change", function () {
        var year = document.getElementById("dateSelector").value;
        location.href = "technic_homepage.php?maintenance&section=mat_prod&action=view&year=" + year;
    });
</script>

<?php 
try{
    require_once("source/model/init.php");
    $bd=connect();
        $sql = "SELECT * FROM technic_used_material_and_product WHERE `date` between ? and ? order by `date` asc";
        $req = $bd->prepare($sql);
        $req->execute(array($year.'-01-01', $year.'-12-31'));

    //list of data
    $list = [];
    while($data = $req->fetch(PDO::FETCH_ASSOC)){
        array_push($list, [ $data['date'], $data['used_product'], $data['used_material'] ]);
    }
    
}
catch(Exception $e){
    echo $e->getMessage();
}
?>

<table class="tg" style="undefined;table-layout: fixed; width: 1000px">
    <colgroup>
        <col style="width: 184px">
        <col style="width: 408px">
        <col style="width: 408px">
    </colgroup>
    <tr>
        <td class="tg-7miv" colspan="3">MATÉRIELS ET PRODUITS UTILISÉS POUR L'ENTRETIEN <br>DES RÉSERVOIRS D'EAU ET DES
            LIGNE D'EMBOUTEILLAGE</td>
    </tr>
    <tr>
        <td class="tg-4x11">DATE<br></td>
        <td class="tg-leys">PRODUITS</td>
        <td class="tg-leys">MATERIELS</td>
    </tr>
    <?php
        for($i=0;$i<count($list);$i++){
            //get the correct class
            $class = $i%2==0?"tg-0pky":"tg-hmp3";
            //get the list of data;
            $listMaterials = get_names("technic_material_list", explode(", ", $list[$i][1]));
            $listProducts = get_names("technic_product_list", explode(", ", $list[$i][2]));

            //cell for the date
            echo "<tr><td class=$class><script>document.write(new Date(\"".$list[$i][0]."\").frenchDate());</script></td>";

            //do ordered list for the the two lists
            echo "<td class=$class><ul>";
            for($j=0;$j<count($listMaterials);$j++)
                echo "<li class='prodAndMatList'>$listMaterials[$j]</li>";
            echo "</ul></td>";

            echo "<td class=$class><ul>";
            for($j=0;$j<count($listProducts);$j++)
                echo "<li class='prodAndMatList'>$listProducts[$j]</li>";
            echo "</ul></td>";
        }
    ?>
</table>


<?php
function get_names($type, $listOfID){
    $bd=connect();
    $sql = "select * from $type";
    $req= $bd->prepare($sql);
    $req->execute(array());
    $listReturned = [];
    while($data = $req->fetch(PDO::FETCH_ASSOC)){
        for($i=0;$i<count($listOfID); $i++){
            if($data['id'] == $listOfID[$i])
                array_push($listReturned, $data['designation']); 
        }
    }
    return $listReturned;
}

?>