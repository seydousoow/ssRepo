<?php
if(isset($_GET['add_emp_status'])){
    if($_GET['add_emp_status'] == "succes"){
    ?>
    <script>
        swal("Enregistré", "L'ajout du nouvel employé s'est effectué avec succés", "success");
    </script>
    <?php
    }
    else if($_GET['add_emp_status'] == 'fail'){
    ?>
    <script>
        swal("Échec", "L'ajout du nouvel employé a échoué. Veillez rééssayer plus tard SVP!", "error");
    </script>
    <?php
    }
}

if(isset($_GET['edit_emp_status'])){
    if($_GET['edit_emp_status'] == "succes"){
    ?>
    <script>
        swal("Enregistré", "La modification s'est effectué avec succées", "success");
    </script>
    <?php
    }
    else if($_GET['edit_emp_status'] == 'fail'){
    ?>
    <script>
        swal("Échec", "La modification a échoué. Veillez rééssayer plus tard SVP!", "error");
    </script>
    <?php
    }
}

if(isset($_GET['del_emp_status'])){
    if($_GET['del_emp_status'] == "succes"){
    ?>
    <script>
        swal("Supprimer", "La suppression s'est effectué avec succées", "success");
    </script>
    <?php
    }
    else if($_GET['del_emp_status'] == 'fail'){
    ?>
    <script>
        swal("Échec", "La suppression a échoué. Veillez rééssayer plus tard SVP!", "error");
    </script>
    <?php
    }
}

?>