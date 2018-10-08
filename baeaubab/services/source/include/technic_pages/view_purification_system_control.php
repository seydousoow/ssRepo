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
        font-size: 12px;
        font-family: Georgia, serif !important;
        background-color: #ffffff;
        color: #000000;
        border-color: inherit;
        text-align: center;
        padding-top: 4px;
        padding-bottom: 4px;
        /* vertical-align: top */
    }

    .tg .tg-hmp3{
        font-size: 12px;
        font-family: Georgia, serif !important;
        color: #000000;
        border-color: inherit;
        text-align: center;
        /* vertical-align: top; */
        background-color:#D2E4FC;
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

<?php date_default_timezone_set("Africa/Dakar"); ?>

<div id="selectDateContainer" style="margin-bottom: 7px;">
    <input type="text" name="dateSelector" id="dateSelector" placeholder="
    <?php 
    echo isset($_GET['date1']) ? (isset($_GET['date2']) && strlen($_GET['date2']) > 0 ?
        Date("
        d-F-Y ", strtotime($_GET['date1'])) . " - " . Date(
        " d-F-Y",
        strtotime($_GET['date2'])
    ) : Date("d-F-Y", strtotime($_GET['date1'])))
        : "Sélectionnez la ou les date(s) à afficher"; ?>" >
    <input type="button" class="btn btn-primary" id="showBtn" value="Afficher">
</div>

<?php 

try {
    require("source/model/init.php");
    //get the connexion
    $bd = connect();
    //begin a transaction
    $bd->beginTransaction();

    $date1 = filter_var($_GET['date1'], FILTER_SANITIZE_NUMBER_INT);
    $date2 = filter_var($_GET['date2'], FILTER_SANITIZE_NUMBER_INT);

    //get the counters
    $req = $bd->prepare("SELECT * FROM `water_purification_counter`");
    $req->execute(array());
    $listCounter = [];
    while ($data = $req->fetch(PDO::FETCH_ASSOC))
        array_push($listCounter, [$data['id_counter'], $data['designation']]);

    // get the data of the selected date
    $req = $bd->prepare("SELECT * FROM `water_purification_system` where `date` >= ? and `date` <= ?");
    $req->execute(array($date1, $date2));
    $arrayData = [];
    if ($req->rowCount() > 0) {
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            array_push($arrayData, [$data['date'], $data['compteur'], $data['m3'], $data['omega_in'], $data['omega_out'], $data['omega_membrane'], $data['h2o_in'], $data['h2o_out'], $data['h2o_membrane'], $data['omega_permeate'], $data['omega_rejet'], $data['h2o_permeate'], $data['h2o_rejet'], $data['air'], $data['oxygene']]);
        }
    }
    $bd->commit();

} catch (PDOException $e) {
    $bd->rollback();
    ?>
<script>
    swal({
        title: "Erreur",
        text: "Une erreur est survenue, veuillez réessayer! Si le problème persiste, veuillez contacter votre administrateur et lui donner le code d'erreur suivant: : <?php echo $e->getCode(); ?>! Voulez-vous réessayer maintenant?",
        icon: "error",
        buttons: ["Non, plus tard!", "Oui"],
        dangerMode: false
    }).then((value) => {
        if (value) {
            //refresh the page
            location.reload(true);
        }
    });
</script>
<?php

}
?>

<script>
    //create a date prototype to get the desired date format
    Date.prototype.yyyymmdd = function () {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();
        return [this.getFullYear(),
            (mm > 9 ? '' : '0') + mm,
            (dd > 9 ? '' : '0') + dd,
        ].join('-');
    };

    var firstDate = "",
        lastDate = "";

    //create and instanciate flatpickr
    flatpickr("#dateSelector", {
        dateFormat: "d-F-Y",
        minDate: "01-01-2017",
        maxDate: new Date(),
        "locale": {
            "firstDayOfWeek": 1 // start week on Monday
        },
        // mode: "multiple",
        mode: "range",
        onChange: function (selectedDates) {
            if (selectedDates.length > 1) {
                firstDate = selectedDates[0].yyyymmdd();
                lastDate = selectedDates[1].yyyymmdd();
            } else {
                firstDate = selectedDates[0].yyyymmdd();
                lastDate = "";
            }
        }
    });

    //do the correct action when the user click on the button
    document.getElementById("showBtn").addEventListener("click", function () {
        //check if at least one date has been seleted
        if (firstDate == "")
            swal("Erreur",
                "Veillez choisir une date ou une range de date a afficher SVP!",
                "error");
        else if (lastDate != "")
            location.href =
            "technic_homepage.php?purification-system&action=view&date1=" +
            firstDate + "&date2=" + lastDate;
        else
            location.href =
            "technic_homepage.php?purification-system&action=view&date1=" +
            firstDate + "&date2=" + firstDate;
    });

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
</script>

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
        <?php

        for ($i = 0; $i < count($arrayData); $i++) {
            $class = (($i % 2) == 0) ? "tg-lowg" : "tg-hmp3";
            echo "<tr>";
            for ($j = 0; $j < 15; $j++) {
                if ($j == 0)
                    echo "<td class=$class><script>document.write(new Date(\"" . $arrayData[$i][$j] . "\").frenchDate());</script></td>";
                else if ($j == 1) {
                    for ($k = 0; $k < count($listCounter); $k++) {
                        if ($arrayData[$i][$j] == $listCounter[$k][0]) {
                            echo "<td class=$class>" . $listCounter[$k][1] . "</td>";
                            break;
                        }
                    }
                } else if ($j >= 3 and $j <= 8)
                    echo "<td class=$class>" . $arrayData[$i][$j] . " PSI</td>";
                else if ($j >= 9 and $j <= 12)
                    echo "<td class=$class>" . $arrayData[$i][$j] . " LBM</td>";
                else if ($j > 12)
                    echo "<td class=$class>" . $arrayData[$i][$j] . " BAR/g/l</td>";
                else
                    echo "<td class=$class>" . $arrayData[$i][$j] . "</td>";

            }
            echo "</tr>";
        }

        ?>
    </table>
</div>