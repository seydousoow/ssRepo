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
        font-weight: bold;
        padding: 10px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: #999;
        color: #fff;
        background-color: #26ADE4;
    }

    .tg .tg-9qbm {
        background-color: #d2e4fc;
        font-weight: bold;
        font-size: 15px;
        font-family: Georgia, serif !important;
        text-align: center;
        vertical-align: bottom
    }

    .tg .tg-h4mb {
        font-size: 20px;
        font-family: Georgia, serif !important;
        background-color: #662d91;
        color: #ffffff;
        border-color: #662d91;
        text-align: center;
        vertical-align: top
    }

    .tg .tg-lowg {
        font-size: 14px;
        font-family: Georgia, serif !important;
        background-color: #ffffff;
        color: #000000;
        border-color: inherit;
        text-align: center;
        vertical-align: top
    }

    @media screen and (max-width: 767px) {
        .tg {
            width: auto !important;
        }

        .tg col {
            width: auto !important;
        }

        .tg-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: auto 0px;
        }

    }
</style>

<?php 

require("source/model/init.php");
$bd = connect();
$queryDate = isset($_GET['selectedDate']) ? $_GET['selectedDate'] : date("Y-m-d");

//get the counters
$req = $bd->prepare("SELECT * FROM `water_purification_counter`");
$req->execute(array());
$listCounter = [];
while ($data = $req->fetch(PDO::FETCH_ASSOC))
    array_push($listCounter, [$data['id_counter'], $data['designation']]);

//get the data of the selected date
$req = $bd->prepare("SELECT * FROM `water_purification_system` where date=?");
$req->execute(array($queryDate));
if ($req->rowCount() > 0) {
    while ($data = $req->fetch(PDO::FETCH_ASSOC))
        $arrayData = [$data['m3'], $data['omega_in'], $data['omega_out'], $data['omega_membrane'], $data['h2o_in'], $data['h2o_out'], $data['h2o_membrane'], $data['omega_permeate'], $data['omega_rejet'], $data['h2o_permeate'], $data['h2o_rejet'], $data['air'], $data['oxygene'], $data['compteur']];
}
?>

<div class="tg-wrap">
    <table class="tg" style="table-layout: fixed">
        <colgroup>
            <col style="width: 130px">
            <col style="width: 115px">
            <col style="width: 80px">
            <col style="width: 70px">
            <col style="width: 70px">
            <col style="width: 80px">
            <col style="width: 70px">
            <col style="width: 70px">
            <col style="width: 80px">
            <col style="width: 85px">
            <col style="width: 75px">
            <col style="width: 85px">
            <col style="width: 75px">
            <col style="width: 70px">
            <col style="width: 80px">
        </colgroup>
        <tr>
            <td class="tg-h4mb" colspan="15">CONTROLE DU SYSTE&#769;ME DE
                PURIFICATION D'EAU<br></td>
        </tr>
        <tr>
            <td class="tg-9qbm" rowspan="3">DATE</td>
            <td class="tg-9qbm" colspan="2" rowspan="2">COMPTEUR</td>
            <td class="tg-9qbm" colspan="6">Pre&#769;ssion osmoseur</td>
            <td class="tg-9qbm" colspan="4">Eau pure<br></td>
            <td class="tg-9qbm" colspan="2">Ozonateur</td>
        </tr>
        <tr>
            <td class="tg-9qbm" colspan="3">Osmose Ome&#769;ga</td>
            <td class="tg-9qbm" colspan="3">Osmose H<sub>2</sub>O</td>
            <td class="tg-9qbm" colspan="2">Ome&#769;ga</td>
            <td class="tg-9qbm" colspan="2">H<sub>2</sub>O</td>
            <td class="tg-9qbm" rowspan="2">Air</td>
            <td class="tg-9qbm" rowspan="2">Oxygène</td>
        </tr>
        <tr>
            <td class="tg-9qbm">Type</td>
            <td class="tg-9qbm">m<sup>3</sup></td>
            <td class="tg-9qbm">In</td>
            <td class="tg-9qbm">Out</td>
            <td class="tg-9qbm">Membrane</td>
            <td class="tg-9qbm">In</td>
            <td class="tg-9qbm">Out</td>
            <td class="tg-9qbm">Membrane</td>
            <td class="tg-9qbm">Perme&#769;ate</td>
            <td class="tg-9qbm">Rejet</td>
            <td class="tg-9qbm">Perme&#769;ate</td>
            <td class="tg-9qbm">Rejet</td>
        </tr>
        <tr>
            <form action="source/model/technic/M_add_purification_system_control.php"
                method="POST" id="form">
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm"
                        name="date" id="date" readonly autocomplete="off"></td>
                <td class="tg-lowg">
                    <select name="compteur" id="compteur" class="form-control col-form-label-sm">
                        <option value="unselected">Se&#769;lectionner</option>
                        <?php 
                        for ($i = 0; $i < count($listCounter); $i++) {
                            $j = $i + 1;
                            $selected = (isset($arrayData) && $arrayData[13] == $j) ? 'selected' : '';
                            echo "<option value=" . $listCounter[$i][0] . " $selected>" . $listCounter[$i][1] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="m3" id="m3" autofocus value="<?php echo isset($arrayData) ? $arrayData[0] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="OmegaIn" id="OmegaIn" value="<?php echo isset($arrayData) ? $arrayData[1] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="OmegaOut" id="OmegaOut" value="<?php echo isset($arrayData) ? $arrayData[2] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="OmegaMembrane" id="OmegaMembrane" value="<?php echo isset($arrayData) ? $arrayData[3] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="H2OIn" id="H2OIn" value="<?php echo isset($arrayData) ? $arrayData[4] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="H2OOut" id="H2OIOut" value="<?php echo isset($arrayData) ? $arrayData[5] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="H2OMembrane" id="H2OMembrane" value="<?php echo isset($arrayData) ? $arrayData[6] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="OmegaPermeate" id="OmegaPermeate" value="<?php echo isset($arrayData) ? $arrayData[7] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="OmegaRejet" id="OmegaRejet" value="<?php echo isset($arrayData) ? $arrayData[8] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="H2OPermeate" id="H2OPermeate" value="<?php echo isset($arrayData) ? $arrayData[9] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="H2ORejet" id="H2ORejet" value="<?php echo isset($arrayData) ? $arrayData[10] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="Air" id="Air" value="<?php echo isset($arrayData) ? $arrayData[11] : ''; ?>"
                        autocomplete="off"></td>
                <td class="tg-lowg"><input type="text" class="form-control col-form-label-sm input-text-area"
                        name="Oxygene" id="Oxygene" value="<?php echo isset($arrayData) ? $arrayData[12] : ''; ?>"
                        autocomplete="off"></td>
            </form>

        </tr>
    </table>
    <div style="width: 300px;
            display: flex;
            justify-content: space-between;
            padding-top: 30px;
            float: right;
            margin-right: 150px;">
        <button type="button" id="btn-submit" class="btn btn-primary btn-lg form-btn">Enregistrer</button>
        <button type="button" id="btn-reset" class="btn btn-danger btn-lg form-btn">Re&#769;initialiser</button>
    </div>
</div>

<script>
    //date to french
    Date.prototype.frenchDate = function () {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();
        var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre',
            'Décembre'
        ];
        return [(dd > 9 ? '' : '0') + dd,
            month[mm - 1],
            this.getFullYear()

        ].join(' ');
    };

    //set default date
    document.getElementById("date").value = new Date().frenchDate();

    //check if all the inputs has been filled
    document.querySelectorAll(".input-text-area").forEach(function (element) {
        element.addEventListener('keyup', function (event) {
            checkIfItsInteger(element);
            if (event.which == 13 || event.keyCode == 13)
                document.getElementById("btn-submit").click();
        });
    });

    //verify if the current character entered by the user is an integer
    function checkIfItsInteger(element) {
        var list = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            inputVal = element.value,
            inputLen = element.value.length;
        if (inputLen > 0) {
            if (!(inputVal.charAt(inputLen - 1) in list)) {
                swal("ERROR", "Ce champ ne peut contenir que des chiffres",
                    "error").then((value) => {
                    element.focus();
                });
                if (inputLen == 1)
                    element.value = "";
                else
                    element.value = inputVal.substring(0, inputLen - 1);
                return false;
            } else return true;
        }
    }

    document.getElementById("btn-submit").addEventListener('click', function () {
        var test = true,
            test2 = false;
        //check the comptor
        if (document.getElementById("compteur").value !== "unselected")
            test2 = true;

        //check the input that must be filled
        document.querySelectorAll(".input-text-area").forEach(function (
            element) {
            if (element.value.length < 1) {
                test = false;
                element.style.borderBottom = "2px solid red";
                element.style.borderRadius = ".25rem";
            } else {
                element.style.borderBottom =
                    "1px solid #ced4da";
                element.style.borderRadius = ".25rem";
            }
        });
        if (!(test2))
            swal("Erreur", "Veuillez sélectionner un compteur!",
                "error");
        else if (!(test))
            swal("Erreur",
                "Tous les champs en rouge doivent être remplis. Si aucune valeur n'est disponible pour un champ, veuillez mettre un zéro (0).",
                "error");
        else
            document.getElementById("form").submit();
    });
</script>