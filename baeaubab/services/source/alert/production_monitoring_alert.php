<script>
Date.prototype.mmddyyyy = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();
    var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    return [(dd > 9 ? '' : '0') + dd,
        month[mm-1],
        this.getFullYear()
        
    ].join(' ');
};
<<<<<<< HEAD

//date to french
Date.prototype.frenchDate = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();
    var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    return [(dd > 9 ? '' : '0') + dd,
        month[mm - 1],
        this.getFullYear()

    ].join(' ');
};
</script>
<?php
if (isset($_GET['add'])) {
    if ($_GET['add'] == "success") {
        ?>
    <script>
        swal("Enregistré", "L'ajout de la feuille de suivie de la production du "+new Date(<?php echo json_encode($date); ?>).frenchDate()+" s'est effectué avec succés", "success");
    </script>
    <?php

} else if ($_GET['add'] == 'error') {
    ?>
    <script>
        swal("Échec", "L'ajout de la feuille de suivie de la production du "+new Date(<?php echo json_encode($date); ?>).frenchDate)+" a échoué. Veillez rééssayer plus tard SVP! Si le problème persiste, veillez contacter votre administrateur et lui donne le code erreur suivant: "+<?php echo json_encode($_GET['code']); ?>, "error");
    </script>
    <?php

}
}

//show production monitoring
if (isset($_GET['date1']) && isset($_GET['date2'])) {
    if (validateDate($_GET['date1']) === true) {
        if (validateDate($_GET['date2']) === true && $entries == 0)
            $text = "Aucun enregistrement n'a été trouvé entre le xxx et le yyy";
        else if ($entries == 0)
            $text = "Aucun enregistrement n'a été trouvé pour la date du xxx";
    } else
        $text = "Veillez sélectionner une date valide SVP!";
    ?>
<script>
    var text = <?php echo json_encode(isset($text) ? $text : ""); ?>;
    var date1 = <?php echo json_encode($_GET['date1']); ?>;
    var date2 = <?php echo json_encode($_GET['date2']); ?>;
=======
</script>
<?php
if(isset($_GET['add'])){
    if($_GET['add'] == "success"){
    ?>
    <script>
        swal("Enregistré", "L'ajout de la feuille de suivie de la production du "+new Date().mmddyyyy()+" s'est effectué avec succés", "success");
    </script>
    <?php
    }
    else if($_GET['add'] == 'error'){
    ?>
    <script>
        swal("Échec", "L'ajout de la feuille de suivie de la production du "+new Date().mmddyyyy()+" a échoué. Veillez rééssayer plus tard SVP! Si le problème persiste, veillez contacter votre administrateur et lui donne le code erreur suivant: "+<?php echo json_encode($_GET['code']);?>, "error");
    </script>
    <?php
    }
}

//show production monitoring
if(isset($_GET['date1']) && isset($_GET['date2'])){
    if( validateDate($_GET['date1']) === true ){
        if(validateDate($_GET['date2']) === true && $entries == 0)
            $text = "Aucun enregistrement n'a été trouvé entre le xxx et le yyy";
        else if($entries == 0)
            $text = "Aucun enregistrement n'a été trouvé pour la date du xxx";
    }
    else
    $text = "Veillez sélectionner une date valide SVP!";
?>
<script>
    var text = <?php echo json_encode(isset($text)?$text:"");?>;
    var date1 = <?php echo json_encode($_GET['date1']);?>;
    var date2 = <?php echo json_encode($_GET['date2']);?>;
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd

    var d1 = new Date(date1).mmddyyyy(),
        d2 = new Date(date2).mmddyyyy();
    text = text.replace("xxx", d1);
    text = text.replace("yyy", d2);
    if(text.length > 10)
        swal("Info", text, "info");
</script>
<<<<<<< HEAD
<?php 
} ?>
=======
<?php } ?>
>>>>>>> e3f7cfcebdcf605c51133963f7ed652a0efe73dd
