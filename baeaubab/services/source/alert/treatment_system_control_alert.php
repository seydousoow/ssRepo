<script>
    Date.prototype.toFrench= function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();
    var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    return [(dd > 9 ? '' : '0') + dd,
        month[mm-1],
        this.getFullYear()
        
    ].join(' ');
};
</script>

<?php
if(isset($_GET['state'])){
    if(filter_var($_GET['state'], FILTER_SANITIZE_STRING) == "success"){
        ?>
        <script>
        swal('SUCCES', 'Le contrôle du ' + new Date().toFrench() + ' a bien été enregistré!', 'success');
        </script>
        <?php
    }
    else if(filter_var($_GET['state'], FILTER_SANITIZE_STRING) == "error"){
        ?>
        <script>
        var error = <?php echo json_encode($_GET["code"]);?>;
        swal('ERREUR', 'Une erreur s\'est produite lors de l\'enregistrement du contrôle. Veuillez réessayer plus tard s\'il vous plaît!', 'success');
        </script>
        <?php
    }
}
?>