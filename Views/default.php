<?php

use App\Core\AppFonctions;

$emplacement = "dev";
// $emplacement = "prod";

if ($emplacement == "dev") {
    // Si on est en dev
    define('APP_ROOT', "/");
} else {
    // Si on est en prod
    define('APP_ROOT', "/nicolas/E5/medicorp/live/public");
}

// Pour afficher les erreurs si le serveur est mal configuré /etc/php/phpXX/apache2/php.ini
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

AppFonctions::my_print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Styles de base sur toutes les pages | Décommenter debug.css pour débugger le CSS -->
    <!-- <link rel="stylesheet" href="/assets/css/View/default/debug.css">  -->
    <link rel="stylesheet" href="<?= APP_ROOT . "assets/css/View/default/default.css" ?>">

    <!-- Library CSS -->
    <link rel="stylesheet" href="<?= APP_ROOT . "assets/css/bootstrap/bootstrap.min.css" ?>">
    <link rel="stylesheet" href="<?= APP_ROOT . "assets/css/fontawesome/all.min.css" ?>">
    <link rel="stylesheet" href="<?= APP_ROOT . "assets/css/fontawesome/fontawesome.min.css" ?>">

    <!-- Feuilles de style personnalisées par page -->
    <?php
    // Afficher les feuilles de style ajoutées
    foreach (AppFonctions::$feuillesDeStyleAjoutees as $feuilleDeStyle) {
        echo $feuilleDeStyle;
    }
    ?>

    <!-- Library JS -->
    <script src="<?= APP_ROOT . "assets/js/View/default/default.js" ?>" defer></script>
    <script src="<?= APP_ROOT . "assets/js/bootstrap/bootstrap.bundle.min.js" ?>" defer></script>

    <!-- Feuilles de Script personnalisées par page -->
    <?php
    // Afficher les feuilles de style ajoutées
    foreach (AppFonctions::$feuillesDeScriptAjoutees as $feuilleDeScript) {
        echo $feuilleDeScript;
    }
    ?>

    <title>Portfolio</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="<?= APP_ROOT . "assets/img/logo/logo.png" ?>" alt="" width="30" height="24">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= APP_ROOT . "accueil" ?>">Accueil</a>
                        </li>

                        <!-- Connexion Praticien -->
                        <?php if (isset($_SESSION["praticien"]) && !empty($_SESSION["praticien"])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarRdvDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mes rendez-vous
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarRdvDropdown">
                                    <li><a class="dropdown-item" href="<?= APP_ROOT . "praticien/calendrier" ?>">Calendrier des rendez-vous</a></li>
                                    <li><a class="dropdown-item" href="<?= APP_ROOT . "rdv/register_rdv" ?>">Enregistrer un rendez-vous</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" aria-current="page" href="/patient/patient" id="navbarPatientDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Patients</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarPatientDropdown">
                                    <li><a class="dropdown-item" href="<?= APP_ROOT . "praticien/listePatient" ?>">Gérer les patients</a></li>
                                    <li><a class="dropdown-item" href="<?= APP_ROOT . "praticien/enregistrer_patient/test" ?>">Enregistrer un nouveau patient</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/priseEnCharge">Mes prises en charges</a>
                            </li>
                            <!-- Connexion Patient -->
                        <?php } else if (isset($_SESSION['patient']) && !empty($_SESSION['patient'])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarRdvDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-disabled="true">
                                    Mes rendez-vous
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarRdvDropdown">
                                    <li><a class="dropdown-item" href="<?= APP_ROOT . "rdv/rdvPraticien" ?>">Calendrier des rendez-vous</a></li>
                                </ul>
                            </li>
                            <!-- Pas de connexion -->
                        <?php } else { ?>
                            <li class="nav-item dropdown disabled" href="<?= APP_ROOT . "utilisateur/login" ?>" tabindex="-1" aria-disabled="true">Mes rendez-vous
                            </li>
                        <?php } ?>

                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['praticien']) && !empty($_SESSION['praticien'])) : ?>
                            <li class="nav-item">
                                <?php if (isset($_SESSION['praticien'])) { ?>
                                    <a class="nav-link" href="<?= APP_ROOT . "profil/praticien" ?>">Profil</a>
                                <?php } else { ?>
                                    <a class="nav-link" href="<?= APP_ROOT . "profil/client" ?>">Profil</a>
                                <?php } ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_ROOT . "utilisateur/logout" ?>">Déconnexion</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_ROOT . "utilisateur/connexion" ?>">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_ROOT . "utilisateur/inscription_praticien" ?>">Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main id="content" class="container content">
        <?= $contenu; ?>
    </main>

    <footer class="footer shadow bg-dark text-white">
        <hr class="hr hr-blurry">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3>Contactez-nous</h3>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-map-marker"></i> Adresse de la clinique</li>
                        <li><i class="fa fa-phone"></i> Téléphone : <a href="tel:0123456789">0123456789</a></li>
                        <li><i class="fa fa-envelope"></i> Email : <a href="mailto:contact@clinic.com">contact@clinic.com</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3>Nos services</h3>
                    <ul class="list-unstyled">
                        <li><a href="#">Service 1</a></li>
                        <li><a href="#">Service 2</a></li>
                        <li><a href="#">Service 3</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3>Liens utiles</h3>
                    <ul class="list-unstyled">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">À propos</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Contactez-nous</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3>Suivez-nous</h3>
                    <ul class="list-unstyled list-inline">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="text-white text-center pb-2 m-0">&copy; 2023 Clinic. Tous droits réservés.</p>
        </div>
    </footer>
</body>

</html>

<style>
</style>