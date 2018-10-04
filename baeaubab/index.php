<!doctype HTML>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- website title -->
    <title>BA EAU BAB - Service Livraison</title>

    <!-- fav ico generator-->
    <link rel="apple-touch-icon" sizes="57x57" href="services/source/images/icons/fav-ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="services/source/images/icons/fav-ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="services/source/images/icons/fav-ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="services/source/images/icons/fav-ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="services/source/images/icons/fav-ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="services/source/images/icons/fav-ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="services/source/images/icons/fav-ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="services/source/images/icons/fav-ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="services/source/images/icons/fav-ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="services/source/images/icons/fav-ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="services/source/images/icons/fav-ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="services/source/images/icons/fav-ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="services/source/images/icons/fav-ico/favicon-16x16.png">
    <link rel="manifest" href="services/source/images/icons/fav-ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="services/source/images/icons/fav-ico/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--Playfair font-->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">

    <!--font-awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- bootstrap css-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- main animation css -->
    <link rel="stylesheet" href="services/css/animate.css">

    <!-- main css-->
    <link rel="stylesheet" href="services/css/main.css">

    <!-- main responsive css -->
    <link rel="stylesheet" href="services/css/responsive.css">

    <!-- main swal sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- main sidr css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sidr@2.2.1/dist/stylesheets/jquery.sidr.dark.min.css">
</head>

<body style="background-color: #72DBFF;">
    <!-- page loader -->
    <div class="loader"></div>
    <!-- end of the loader -->

    <?php 
    if (isset($_GET['loggedin']) && $_GET['loggedin'] == "false")
        echo '<script>swal("ERROR","Vous ne pouvez accéder à cette page qu\'après vous être authentifié!","error");</script>';
    else if (isset($_GET['session']) && $_GET['session'] == "expired")
        echo '<script>swal("INFO !", "Votre session a expiré, veuillez vous reconnecter SVP!", "info");</script>';

    require_once("services/source/error_page/login_error.php"); ?>
    <div id="login-main-container">

        <div id="login-form-container">

            <img src="services/source/images/icons/logo-menu%20bleu%20bg.png" alt="BA EAU BAB LOGO" />

            <p>Accès Membre</p>

            <form method="post" action="services/source/model/login.php">

                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" placeholder="Entrer votre login..." autocomplete="off" required>

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="passsword" placeholder="Entrer votre mot de passe..." required>

                <input type="submit" class="btn btn-primary" name="submit-login-form" value="Se connecter">
            </form>
        </div>
        <!-- Return to Top -->
        <a href="javascript:" class="wow fadeInBigDown" data-wow-duration="2s" id="return-to-top"><i class="fas fa-chevron-circle-up"></i></a>
    </div>

    <!-- include the footer -->
    <?php include("services/source/include/footer.php"); ?>
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
    <script src="services/js/wow.min.js"></script>

    <!-- main loader -->
    <script src="services/js/loader.js"></script>
</body>

</html>
