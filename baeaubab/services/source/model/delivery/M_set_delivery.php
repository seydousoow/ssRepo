<?php 
//show error
ini_set('display_errors', 1);
error_reporting(E_ALL);

//set the general date
date_default_timezone_set("Africa/Dakar");
define("defaultDate", isset($_GET['date']) ? filter_var($_GET['date'], FILTER_SANITIZE_NUMBER_INT) : date("Y-m-d"));
$message = $title = "";

require("source/model/init.php");

if (isset($_GET['operation'])) {
    if ($_GET['operation'] == "add") {
        if ($_GET['state'] == "success") {
            $title = "Enregistré";
            $message = "L'ajout de la ligne " . $_GET['line'] . " du \"+new Date(\"" . defaultDate . "\").frenchDate()+\" a réussi.";
        } else if ($_GET['state'] == "fail") {
            $title = "Échec";
            $message = "L'ajout de la ligne " . $_GET['line'] . " du \"+new Date(\"" . defaultDate . "\").frenchDate()+\" a échoué.";
        }
    } else if ($_GET['operation'] == "update") {
        if ($_GET['state'] == "success") {
            $title = "Enregistré";
            $message = "La mise à jour de la ligne " . $_GET['line'] . " du \"+new Date(\"" . defaultDate . "\").frenchDate()+\" a réussi.";
        } else if ($_GET['state'] == "fail") {
            $title = "Échec";
            $message = "La mise à jour de la ligne " . $_GET['line'] . " du \"+new Date(\"" . defaultDate . "\").frenchDate()+\" a échoué.";
        }
    }
    ?>
    <script>
        var title = "<?php echo $title; ?>";
        var message = "<?php echo $message; ?>";
        swal(title, message, ((title == "Enregistré") ? "success" : "error")).
        then((value) => { location.href = "delivery_homepage.php?new_delivery&date=<?php echo defaultDate; ?>"; }); 
    </script>
    <?php

}

//get list of employe
function get_list_employe()
{
    $bd = connect();

    $query = "select id_personel as id, nom, prenom, matricule, intitule as poste from personel_livraison inner join poste_livraison on personel_livraison.poste=poste_livraison.id_poste order by nom, prenom";

    $req = $bd->prepare($query);
    $req->execute(array());
    $list = [];

    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        array_push($list, [$data['id'], $data['nom'], $data['prenom'], $data['poste'], $data['matricule']]);
    }
    return $list;
}

//function to retrieve data of the selected date
function selectedDateData($num_line, $date)
{
    $sql = "SELECT `mat_livreur` as a1, `mat_aide_livreur` as a2, `mat_chauffeur` as a3, `b_chargees` as a4, `b_livrees` as a5, `b_consignees` as a6, `b_deconsignees` as a7, `retour_b_pleines` as a8, `retour_b_vides` as a9, `retour_b_pretees` as a10, `b_pretees` as a11, `b_percees_voiture` as a12, `b_percees_entrepot` as a13, `b_perdues` as a14, `client_livre_sur_demande` as a15, `remarques` as a16 FROM `delivery_line$num_line` WHERE `date_delivery`=?";
    $bd = connect();
    $req = $bd->prepare($sql);
    $req->execute(array($date));
    $line_data = [];
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        for ($i = 1; $i < 17; $i++)
            array_push($line_data, $data["a$i"]);
    }
    return $line_data;
}

//get list of regions
function getListRegions()
{
    $sql = "SELECT `id_region`, `nom` FROM `delivery_list_region` ORDER BY `nom` ASC";
    try {
        require_once("source/model/init.php");
        $bd = connect();
        $req = $bd->prepare($sql);
        $req->execute(array());
        $list_region = [];
        while ($data = $req->fetch(PDO::FETCH_ASSOC))
            array_push($list_region, ['id' => $data['id_region'], 'nom' => $data['nom']]);
        return $list_region;
    } catch (PDOException $e) {
        echo "<script>swal('Erreur', 'Une erreur s\'est produite lors de la récupération des données. Veuillez réessayer plus tard! Si le problème persiste, veuillez communiquer le code d\'erreur suivant à votre administrateur: " . $e->getCode() . "','error');</script>";
    }
}

//get the data that already exist for the selected date
function getDataForSelectedDate($listRegion)
{
    $listDataRegion = [[], [], [], [], [], [], []];
    foreach ($listRegion as $region) {
    //delete accent and special character
        $nomRegion = $region['nom'];
        $nomRegion = str_replace(" ", "_", $nomRegion);
        $nomRegion = str_replace(['ê', 'é', 'è'], "e", $nomRegion);
        $tableRegion = "delivery_line_" . $nomRegion;
        $sql = "SELECT `mat_livreur` as a1, `mat_aide_livreur` as a2, `mat_chauffeur` as a3, `b_chargees` as a4, `b_livrees` as a5, `b_consignees` as a6, `b_deconsignees` as a7, `retour_b_pleines` as a8, `retour_b_vides` as a9, `retour_b_pretees` as a10, `b_pretees` as a11, `b_percees_voiture` as a12, `b_percees_entrepot` as a13, `b_perdues` as a14, `client_livre_sur_demande` as a15, `remarques` as a16, `ligne` as a17 FROM $tableRegion WHERE `date_delivery`=?";
        $bd = connect();
        $req = $bd->prepare($sql);
        $req->execute(array(defaultDate));
        if ($req->rowCount() > 0) {
            while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
                $lambda = [];
                array_push($lambda, $region['nom']);
                for ($i = 1; $i <= 17; $i++) {
                    array_push($lambda, $data["a$i"]);
                }
                $listDataRegion[$data['a17']] = $lambda;
            }
        }
    }
    return $listDataRegion;
}