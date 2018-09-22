<script>
    if (!(window.location.href.indexOf("week") != -1 && window.location.href.indexOf("year") != -1)) {
        Date.prototype.getWeek = function() {
            var date = new Date(this.getTime());
            date.setHours(0, 0, 0, 0);
            // Thursday in current week decides the year.
            date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
            // January 4 is always in week 1.
            var week1 = new Date(date.getFullYear(), 0, 4);
            // Adjust to Thursday in week 1 and count number of weeks from date to week1.
            return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
        }

        var currentWeek = new Date().getWeek(),
            currentYear = new Date().getFullYear();

        window.location.href = "delivery_homepage.php?view_weekly_absence&week=" + currentWeek + "&year=" + currentYear;
    }

</script>

<?php
if(isset($_GET['week']) && isset($_GET['year'])){
    
    //set the default date function language to fr_FR
    setlocale(LC_ALL, 'fr_FR');
    //set default timezone to greenWitch meridian time
    date_default_timezone_set("Africa/Dakar");
    
    $listday = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $listMonthEn = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $listMonthFr = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Otobre', 'Novembre', 'Décembre'];
    $listWeekDay = [];
    $listOfDays = [];
    
    foreach($listday as $day){
        $datex = date( 'd F Y', strtotime("$day this week" ) );
        array_push($listOfDays, date('Y-m-d', strtotime("$day this week")));
        for($i=0;$i<12;$i++){
            if (strpos($datex, $listMonthEn[$i]) !== false) { //first we check if the url contains the string 
                $datex = str_replace($listMonthEn[$i], $listMonthFr[$i], $datex); //if yes, we simply replace it with en
            }
        }
        array_push($listWeekDay, $datex);
    }
    //get the and last day of the week for the table caption
    $firstday = substr($listWeekDay[0], 0, -5);
    $lastday = substr($listWeekDay[6], 0, -5);

    require_once("source/model/delivery/M_absence_view.php");
    $list_employe = get_list_employe();
    $list_absence = [];
    
    for($i=0;$i<count($listOfDays);$i++){
        array_push($list_absence, get_list_absent_of_date($listOfDays[$i]));
    }
    
    //this list contains the full nam eof the employe and the reason of his absence
    $final_list = [];
    
    for($i=0;$i<count($list_absence);$i++){
        //if there is at least one absence record on that day
        if(count($list_absence[$i]) > 0){
            for($j=0;$j<count($list_absence[$i]);$j++){
                for($k=0;$k<count($list_employe);$k++){
                    //get the full name of each absence and the reason and add them to the final list
                    if($list_employe[$k][2] == $list_absence[$i][$j][0] )
                        $final_list[$i][$j] = [$list_employe[$k][0], $list_employe[$k][1], $list_absence[$i][$j][1]];
                }
            }
        }
        else{
            array_push($final_list, "Pas d'absent"); 
        }
    }   
}

?>

<div>
    <div style="margin-top: 30px;">
        <table class="table table-striped table-sm table-bordered table-absence">
            <caption>La liste des absents de la semaine du <?php echo "$firstday au $lastday"?>
            </caption>
            <thead>
                <tr>
                    <?php
                    for($i=0;$i<7;$i++){
                        echo "<th>$listWeekDay[$i]</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '<tr>';
                foreach($final_list as $s){
                    if($s == "Pas d'absent"){
                        echo "<td class='td-no-absence'>Pas d'absent</td>";
                    }
                    else{
                        $ss = [];
                        $ss= $s;
                        echo "<td class='td-absence'>";
                        for($i=0;$i<count($ss);$i++){
                            $reason = (strlen($ss[$i][2]) < 2) ? ' Aucun' : $ss[$i][2];
                            
                            echo "<span class='absence-span1'>".$ss[$i][1]." ".$ss[$i][0]."</span><hr class='hr-absence'><span class='span_absence'>Motif</span> : ".$reason." <hr class='hr-absence2'>";  
                        }
                        echo "</td>";
                    }
                    
                }
                echo "</tr>";
                ?>
            </tbody>
        </table>
    </div>
</div>
