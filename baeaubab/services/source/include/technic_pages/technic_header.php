<style>
    .dm1:last-child {
        position: relative;
        top: 100px;
        margin-top: 0px !important;
    }
    .dm1:first-child{
        margin-bottom: 0px !important;
    }
</style>

<header style="margin-bottom: 10px;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:white !important">
        <img id="nav-logo" src="source/images/icons/logo_menu.png" alt="">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Suivi de la production
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="technic_homepage.php?production_monitoring&action=new">Nouvelle
                            fiche de suivi</a>
                        <a class="dropdown-item" href="technic_homepage.php?production_monitoring&action=view">Consuler
                            les suivis</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Gestion du stock
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="technic_homepage.php?stock&action=view">Consulter le stock</a>
                        <a class="dropdown-item" href="technic_homepage.php?stock&action=update">Mettre a jour le stock</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Control du traitement d'eau
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="technic_homepage.php?water-treatment&action=new">Nouveau Control</a>
                        <a class="dropdown-item" href="technic_homepage.php?water-treatment&action=view&sheet=1">Consulter
                            les suivis du systeme N<sup>o</sup> 1</a>
                        <a class="dropdown-item" href="technic_homepage.php?water-treatment&action=view&sheet=2">Consulter
                            les suivis du systeme N<sup>o</sup> 2</a>
                    </div>
                </li>
                <li class="nav-item dropright">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Gestion des entretiens
                    </a>
                    <div class="dropdown-menu dm1" aria-labelledby="navbarDropdownMenuLink">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Désinfection et nettoyage des réservoirs
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="technic_homepage.php?maintenance&section=disinfection&action=add">Nouvel entretien</a>
                            <a class="dropdown-item" href="technic_homepage.php?maintenance&section=disinfectionaction=view">Historique des
                                entretiens</a>
                        </div>
                    </div>
                    <div class="dropdown-menu dm1" aria-labelledby="navbarDropdownMenuLink">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Matériels et produits utilisés
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="technic_homepage.php?maintenance&section=mat_prod&action=add">Nouvel
                                enregistrement</a>
                            <a class="dropdown-item" href="technic_homepage.php?maintenance&section=mat_prod&action=view">Listage des
                                matériaux et produits
                                entretiens</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script>
    $('ul.navbar-nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeIn(100);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeOut(100);
    });
    $('ul.navbar-nav li.dropright').hover(function () {
        $(this).find('.dm1').stop(true, true).delay(0).fadeIn(100);
    }, function () {
        $(this).find('.dm1').stop(true, true).delay(0).fadeOut(100);
    });
    $('.dm1').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeIn(100);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeOut(100);
    });
</script>