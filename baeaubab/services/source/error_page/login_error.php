<?php 
if(isset($_GET['err'])){
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    if($_GET['err'] == "pwrd"){
        ?>
        <script>
            swal("Erreur", "Mot de passe incorrect", "error");
        </script>
        <?php
    }
    else if($_GET['err'] == 'usrnme'){
        ?>
        <script>
            swal("Erreur", "Attention! Cet utilisateur n'existe pas", "error");
        </script>
        <?php
        
    }
}
?>