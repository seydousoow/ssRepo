<<<<<<< HEAD
<?php date_default_timezone_set("Africa/Dakar");?>

<div id="selectDateContainer" style="margin-bottom: 7px;">
    <input type="text" name="dateSelector" id="dateSelector" placeholder="<?php 
    echo isset($_GET['date1'])?( isset($_GET['date2']) && strlen($_GET['date2'])>0? Date("d-F-Y", strtotime($_GET['date1']))." - ".Date("d-F-Y", strtotime($_GET['date2'])): Date("d-F-Y", strtotime($_GET['date1']))):"Sélectionnez la ou les date(s) à afficher";?>" >
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

//functon that check if the date are correct
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

?>
=======
<div class="tg-wrap">
    <table id="tg-dt5fY" class="tg">
        <thead>
            <tr>
                <td class="tg-r1kb" colspan="20">FICHE DE CONTROLE DU SYSTEME DE TRAITEMENT EAU N<sup>o</sup> 1 DU
                    <?php date_default_timezone_set("Africa/Dakar");
                            echo date("d/m/Y");
                    ?>
                </td>
            </tr>
            <tr>
                <td class="tg-nn11" colspan="10">PRESSIONS</td>
                <td class="tg-nn11" colspan="3">Dureté d'eau</td>
                <td class="tg-nn11" colspan="5">TDS Eau</td>
                <td class="tg-nn11" colspan="2">Test Chlore</td>
            </tr>
            <tr>
                <td class="tg-kqiv" colspan="2">Pompe</td>
                <td class="tg-kqiv" colspan="2">Filtre Amiad</td>
                <td class="tg-kqiv" colspan="2">CP213 Macro</td>
                <td class="tg-kqiv" colspan="2">CP213 Charbon<br></td>
                <td class="tg-kqiv" colspan="2">CP213 Adouci</td>
                <td class="tg-kqiv" rowspan="2">Brute</td>
                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                <td class="tg-kqiv" rowspan="2">Osmosée</td>
                <td class="tg-kqiv" rowspan="2">Brute</td>
                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                <td class="tg-kqiv" rowspan="2">Osmosée 1</td>
                <td class="tg-kqiv" rowspan="2">Osmosée 2</td>
                <td class="tg-kqiv" rowspan="2">Minéralisé</td>
                <td class="tg-kqiv" rowspan="2">IN</td>
                <td class="tg-kqiv" rowspan="2">OUT</td>
            </tr>
            <tr>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
            </tr>
            <tr>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
            </tr>

        </tbody>
    </table>
</div>

>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
<div class="tg-wrap">
    <table id="tg-dt5fY" class="tg">
        <thead>
            <tr>
<<<<<<< HEAD
                <td class="tg-r1kb" style="font-size:20px" colspan="21">CONTROLE DU SYSTEME DE TRAITEMENT EAU N<sup>o</sup> 
                <?php echo intVal($_GET['sheet']);
                if(isset($_GET['date1'])){?>
                <script>
                document.write("du "+new Date(<?php echo json_encode($_GET['date1']);?>).frenchDate());
                </script>
                <?php
                }
                if(isset($_GET['date2']) && strlen($_GET['date2']) > 0){?>
                <script>
                document.write(" au "+new Date(<?php echo json_encode($_GET['date2']);?>).frenchDate());
                </script>
                <?php
                }
                ?>
=======
                <td class="tg-r1kb" colspan="20">FICHE DE CONTROLE DU SYSTEME DE TRAITEMENT EAU N<sup>o</sup> 2 DU
                    <?php date_default_timezone_set("Africa/Dakar");
                            echo date("d/m/Y");
                    ?>
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
                </td>
            </tr>
            <!-- unite de mesure : PSI for pression
                durete : G
                TDS eau : PPM
                test chlore : mg/l    
                add to tds mineralisee

                alert:
                durete eau if adoucie>0 and osmose>0
                tds osmose 1 and 2 if >23
                chlore if >0,5
        -->
            <tr>
<<<<<<< HEAD
                <td class="tg-nn11" rowspan="3">Date</td>
=======
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
                <td class="tg-nn11" colspan="10">PRESSIONS</td>
                <td class="tg-nn11" colspan="3">Dureté d'eau</td>
                <td class="tg-nn11" colspan="5">TDS Eau</td>
                <td class="tg-nn11" colspan="2">Test Chlore</td>
            </tr>
            <tr>
                <td class="tg-kqiv" colspan="2">Pompe</td>
                <td class="tg-kqiv" colspan="2">Filtre Amiad</td>
                <td class="tg-kqiv" colspan="2">CP213 Macro</td>
                <td class="tg-kqiv" colspan="2">CP213 Charbon<br></td>
                <td class="tg-kqiv" colspan="2">CP213 Adouci</td>
                <td class="tg-kqiv" rowspan="2">Brute</td>
                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                <td class="tg-kqiv" rowspan="2">Osmosée</td>
                <td class="tg-kqiv" rowspan="2">Brute</td>
                <td class="tg-kqiv" rowspan="2">Adoucie</td>
                <td class="tg-kqiv" rowspan="2">Osmosée 1</td>
                <td class="tg-kqiv" rowspan="2">Osmosée 2</td>
                <td class="tg-kqiv" rowspan="2">Minéralisé</td>
                <td class="tg-kqiv" rowspan="2">IN</td>
                <td class="tg-kqiv" rowspan="2">OUT</td>
            </tr>
            <tr>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
                <td class="tg-7cwe">IN</td>
                <td class="tg-7cwe">OUT</td>
            </tr>
        </thead>
        <tbody>
<<<<<<< HEAD
            <?php
            if(isset($list))
            for($i=0; $i<count($list);$i++){
                echo "<tr>";
                ?>
                <script>
                    var date = <?php echo json_encode($list[$i][0]);?>;
                    document.write("<td class=\"tg-0lax\">"+new Date(date).frenchDate()+"</td>");
                </script>
                <?php
                for($j=1;$j<count($list[$i]);$j++){
                    if( ($j == 12 || $j == 13) && intval($list[$i][$j]) > 0){
                        echo "<td class=\"tg-0lax\" style=\"background-color:red;color:black;font-size:14px;font-weight:bold\">".$list[$i][$j]."</td>";
                    }
                    else if( ($j == 16 || $j == 17) && intval($list[$i][$j]) >= 23){
                        echo "<td class=\"tg-0lax\" style=\"background-color:red;color:black;font-size:14px;font-weight:bold\">".$list[$i][$j]."</td>";
                    }
                    else if( ($j == 19 || $j == 20) && intval($list[$i][$j]) > 0.5){
                        echo "<td class=\"tg-0lax\" style=\"background-color:red;color:black;font-size:14px;font-weight:bold\">".$list[$i][$j]."</td>";
                    }
                    else if(($i%2) == 0)
                        echo "<td class=\"tg-0lax\">".$list[$i][$j]."</td>";
                    else
                        echo "<td class=\"tg-hmp3\">".$list[$i][$j]."</td>";
                    
                }
                echo "</tr>";
            }
            
            ?>
        </tbody>
    </table>
</div>
=======
            <tr>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
                <td class="tg-0lax">100</td>
            </tr>
            <tr>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
                <td class="tg-hmp3">200</td>
            </tr>
        </tbody>
    </table>
</div>
<script src="js/treatment_control.js"></script>
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
