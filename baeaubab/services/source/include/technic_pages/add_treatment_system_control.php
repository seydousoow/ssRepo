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
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control1" name="" id="" value="" maxlength="7" disabled required ></td>
            </tr>
            
        </tbody>
    </table>
    <button class="btn btn-success" id="editTreatmentControlBtn1">Editer</button>
</div>

<div class="tg-wrap">
    <table id="tg-dt5fY" class="tg">
        <thead>
            <tr>
                <td class="tg-r1kb" colspan="20">FICHE DE CONTROLE DU SYSTEME DE TRAITEMENT EAU N<sup>o</sup> 2 DU
                    <?php echo date("d/m/Y");?>
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
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
                <td class="tg-hmp3"><input type="text" class="control2" name="" id="" value="" maxlength="7" disabled required ></td>
            </tr>
        </tbody>
    </table>
    <button class="btn btn-success" id="editTreatmentControlBtn2">Editer</button>
</div>
<script src="source/include/technic_pages/js/treatment_control_form.js"></script>