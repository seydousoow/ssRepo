<!doctype HTML>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- website title -->
    <title>BA EAU BAB - Service Livraison</title>

    <!-- fav ico generator-->
    <link rel="apple-touch-icon" sizes="57x57" href="source/images/icons/fav-ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="source/images/icons/fav-ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="source/images/icons/fav-ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="source/images/icons/fav-ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="source/images/icons/fav-ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="source/images/icons/fav-ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="source/images/icons/fav-ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="source/images/icons/fav-ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="source/images/icons/fav-ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="source/images/icons/fav-ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="source/images/icons/fav-ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="source/images/icons/fav-ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="source/images/icons/fav-ico/favicon-16x16.png">
    <link rel="manifest" href="source/images/icons/fav-ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="source/images/icons/fav-ico/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--Playfair font-->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">

    <!--font-awesome -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--main jquery -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> -->
    <script src="js/jquery-3.3.1.js"></script>

    <!-- bootstrap css-->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.4.1.3.css">

    <!-- main animation css -->
    <link rel="stylesheet" href="css/animate.css">

    <!-- main css-->
    <link rel="stylesheet" href="css/technical_main.css">

    <!-- main sidr css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sidr@2.2.1/dist/stylesheets/jquery.sidr.dark.min.css">

    <!-- main swal sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!--flatpickr date picker -->
    <script src="js/flatPickR.js"></script>
    <link rel="stylesheet" href="css/flatPickR.css">

</head>

<body style="background-color: #72DBFF;">
    <!-- page loader -->
    <div class="loader"></div>
    <!-- end of the loader -->

    <!-- including the header -->
    <?php include("source/include/technic_pages/technic_header.php"); ?>
    <!-- end of the header -->

    <!-- including the alert page for the delivery section -->
    <?php //include("source/alert/delivery-alert.php"); ?>
    <!-- end of the alert inclusion -->

    <div style="margin-bottom: 35px;">
        <?php
        if(isset($_GET['production_monitoring'])){
            if(isset($_GET['action']) && $_GET['action'] == "new")
                require_once('source/include/technic_pages/production_monitoring.php');
            else if(isset($_GET['action']) && $_GET['action'] == "view")
                require_once('source/include/technic_pages/show_production_monitoring.php');
        }
        else if(isset($_GET['stock'])){
            if(isset($_GET['action']) && $_GET['action'] == "view")
                require_once("source/include/technic_pages/view_stock.php");
            else if(isset($_GET['action']) && $_GET['action'] == "update")
                require_once("source/include/technic_pages/update_stock.php");
        }
        else if(isset($_GET['water-treatment'])){
            if(isset($_GET['action']) && $_GET['action'] == "new")
                require_once('source/include/technic_pages/add_treatment_system_control.php');
            if(isset($_GET['action']) && $_GET['action'] == "view")
                require_once('source/include/technic_pages/view_treatment_system_control.php');                
        }
        else if(isset($_GET['maintenance'])){
            if(isset($_GET['section']) && $_GET['section'] == 'disinfection'){
                if( isset($_GET['action']) && $_GET['action'] == "add")
                    require_once("source/include/technic_pages/add_new_desinfection.php");
                if( isset($_GET['action']) && $_GET['action'] == "add")
                    require_once("source/include/technic_pages/view_desinfection.php");
            }
            else if(isset($_GET['section']) && $_GET['section'] == "mat_prod"){
                if( isset($_GET['action']) && $_GET['action'] == "add")
                    require_once("source/include/technic_pages/add_used_materials_and_products.php");
                if( isset($_GET['action']) && $_GET['action'] == "view")
                    require_once("source/include/technic_pages/view_used_material_and_product.php");
            }
        }    

        ?>
        <!-- Return to Top -->
        <a href="javascript:" class="wow fadeInBigDown" data-wow-duration="2s" id="return-to-top"><i class="fas fa-chevron-circle-up"></i></a>
    </div>

    <!-- include the footer -->
    <?php include("source/include/footer.php");?>
    <!--end of footer -->

    <!-- javascript inclusion -->
    <!--main jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    <!-- main popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <!-- main bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- main sidr -->
    <script src="https://cdn.jsdelivr.net/npm/sidr@2.2.1/dist/jquery.sidr.min.js"></script>

    <!-- main wow -->
    <script src="js/wow.min.js"></script>

    <!-- main loader -->
    <script src="js/loader.js"></script>
</body>

</html>
