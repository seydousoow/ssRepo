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
        text-align: center;
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

    .tg .tg-3594 {
        background-color: #26ade4;
        font-weight: bold;
        font-size: 20px;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;

        color: #000000;
        text-align: center;
        vertical-align: top
    }

    .tg .tg-5u5r {
        background-color: #26ade4;
        font-weight: bold;
        font-size: 20px;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;
        color: #000000;
        text-align: center
    }

    .tg .tg-6g07 {
        font-size: 24px;
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif !important;
        background-color: #1a1818;
        text-align: center;
        color: white;
    }

    .tg .tg-s268 {
        text-align: center;
        vertical-align: middle;
        padding: 7px;
    }

    .tg .tg-0lax {
        text-align: left;
        vertical-align: top
    }

    .tg .tg-hmp3 {
        background-color: #D2E4FC;
        text-align: center;
        vertical-align: middle;
        padding: 7px;
    }

    hr {
        margin: 0 auto;
        border: 1px solid gray;
        width: 30px
    }
</style>

<?php date_default_timezone_set("Africa/Dakar"); ?>

<div id="selectDateContainer" style="margin-bottom: 7px;">
    <p>Sélectionnez une année à afficher</p>
    <select name="dateSelector" id="dateSelector">
        <?php 
        $year = isset($_GET['year']) ? $_GET['year'] : date("Y");
        for ($i = 2016; $i <= intval(date("Y")); $i++) {
            if ($i == intval($year))
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
        location.href =
            "technic_homepage.php?maintenance&section=disinfection&action=view&year=" +
            year;
    });
</script>

<?php
try {
    require_once("source/model/init.php");
    $bd = connect();
    $sql = "SELECT * FROM technic_tank_disinfection_and_cleaning WHERE `eau_brute` between ? and ? order by `eau_brute` asc";
    $req = $bd->prepare($sql);
    $req->execute(array($year . '-01-01', $year . '-12-31'));

    //list of data
    $list = [];
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        array_push($list, [$data['eau_brute'], $data['eau_adoucie'], $data['eau_osmosee_purifiee']]);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}


?>

<table class="tg" style="table-layout: fixed; width: 750px">
    <colgroup>
        <col style="width: 250px">
        <col style="width: 250px">
        <col style="width: 250px">
    </colgroup>
    <tr>
        <td class="tg-6g07" colspan="3"><span style="font-weight:bold">DÉSINFECTION
                ET NETTOYAGE DES RÉSERVOIRS DE L'ANNÉE
                <?php echo $year; ?></span></td>
    </tr>
    <tr>
        <td class="tg-5u5r">Eau brute</td>
        <td class="tg-5u5r">Eau adoucie</td>
        <td class="tg-5u5r">Eau osmosée purifiée</td>
    </tr>
    <?php
    for ($i = 0; $i < count($list); $i++) {
        //get the correct class
        $class = $i % 2 == 0 ? "tg-s268" : "tg-hmp3";
        echo "<tr>";
        echo "<td class=$class><script>document.write(new Date(\"" . $list[$i][0] . "\").frenchDate());</script></td>";
        if ($list[$i][1] != null)
            echo "<td class=$class><script>document.write(new Date(\"" . $list[$i][1] . "\").frenchDate());</script></td>";
        else
            echo "<td class=$class><hr></td>";
        if ($list[$i][2] != null)
            echo "<td class=$class><script>document.write(new Date(\"" . $list[$i][2] . "\").frenchDate());</script></td>";
        else
            echo "<td class=$class><hr></td>";
        echo "</tr>";
    }
    ?>

</table>