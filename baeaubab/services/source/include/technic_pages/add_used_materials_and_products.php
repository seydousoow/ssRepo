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

    .tg .tg-phtq {
        background-color: #D2E4FC;
        border-color: inherit;
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

    .tg .tg-0pky {
        height: 400px !important;
        overflow: scroll
    }

    .material_product_container {
        width: 100%;
        height: 400px;
        overflow: auto;
        overflow-x: hidden;
    }
</style>
<?php
//get the list of materials and products
require_once("source/model/init.php");
$bd=connect();

$sql = "SELECT id, designation FROM `technic_product_list` order by designation asc";
$req = $bd->prepare($sql);
$req->execute(array());
$listProduct = [];
while($data = $req->fetch(PDO::FETCH_ASSOC))
    array_push($listProduct, [ 'id' => $data['id'], 'nom' => $data['designation'] ]);

$sql = "SELECT id, designation FROM `technic_material_list` order by designation asc";
$req = $bd->prepare($sql);
$req->execute(array());
$listMaterial = [];
while($data = $req->fetch(PDO::FETCH_ASSOC))
    array_push($listMaterial, ['id' => $data['id'], 'nom' => $data['designation'] ]);

?>
<form action="source/model/technic/M_add_used_materials_and_products.php" method="post">
    <table class="tg">
        <colgroup>
            <col style="width: 190px">
            <col style="width: 400px">
            <col style="width: 400px">
        </colgroup>
        <tr>
            <td class="tg-7miv" colspan="3">MATÉRIELS ET PRODUITS UTILISÉS POUR L'ENTRETIEN <br>DES RÉSERVOIRS D'EAU ET
                DES
                LIGNE D'EMBOUTEILLAGE</td>
        </tr>
        <tr>
            <td class="tg-4x11">DATE<br></td>
            <td class="tg-leys">PRODUITS</td>
            <td class="tg-leys">MATERIELS</td>
        </tr>
        <tr>
            <input type="hidden" name="lenprod" value="<?php echo count($listProduct);?>">
            <input type="hidden" name="lenmat" value="<?php echo count($listMaterial);?>">
            <td class="tg-0pky"><input type="date" name="date" style="width:100%"></td>
            <td class="tg-0pky">
                <div class="material_product_container">
                    <?php
            for($i=0;$i<count($listProduct);$i++)
                echo "<input type='checkbox' name='product$i' value=\"".$listProduct[$i]['id']."\" >".$listProduct[$i]['nom']."</br>";    
            ?>
                </div>
            </td>
            <td class="tg-0pky">
                <div class="material_product_container">
                    <?php
            for($i=0;$i<count($listMaterial);$i++){
                echo "<input type='checkbox' name='material$i' value=\"".$listMaterial[$i]['id']."\" >".$listMaterial[$i]['nom']."</br>";    
            }?>
                </div>
            </td>

        </tr>
    </table>
    <input type="submit" name="validate" value="Enregistrer" ;>
</form>