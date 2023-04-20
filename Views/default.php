<?php
use App\Core\GlobalFunctions;

// Pour afficher les erreurs si le serveur est mal configuré /etc/php/phpXX/apache2/php.ini
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

GlobalFunctions::my_print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Styles de base sur toutes les pages | Décommenter debug.css pour débugger le CSS -->
    <!-- <link rel="stylesheet" href="../assets/css/View/default/debug.css">  -->
    <link rel="stylesheet" href="/assets/css/View/default/default.css">

    <!-- Library CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="/assets/css/fontawesome/fontawesome.min.css">

    <!-- Feuilles de style personnalisées par page -->
    <?php
        // Afficher les feuilles de style ajoutées
        foreach (GlobalFunctions::$feuillesDeStyleAjoutees as $feuilleDeStyle) {
            echo $feuilleDeStyle;
        }
    ?>

    <!-- Library JS -->
    <script src="/assets/js/View/default/default.js" defer></script>
    <script src="/assets/js/bootstrap/bootstrap.bundle.min.js" defer></script>

    <!-- Feuilles de Script personnalisées par page -->
    <?php
        // Afficher les feuilles de style ajoutées
        foreach (GlobalFunctions::$feuillesDeScriptAjoutees as $feuilleDeScript) {
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
                    <img src="/assets/img/logo/logo.png" alt="" width="30" height="24">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/public/">Accueil</a>
                        </li>
                        <?php if (isset($_SESSION["user"]) && !empty($_SESSION["user"]["idPraticien"])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" aria-current="page" href="/public/patient/patient" id="navbarPatientDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Patients</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarPatientDropdown">
                                    <li><a class="dropdown-item" href="/public/patient/listing">Gérer les patients</a></li>
                                    <li><a class="dropdown-item" href="/public/patient/register_patient">Enregistrer un nouveau patient</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if(isset($_SESSION["user"]) && !empty($_SESSION["user"])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarRdvDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mes rendez-vous
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarRdvDropdown">
                                    <li><a class="dropdown-item" href="/public/rdv/rdvPraticien">Calendrier des rendez-vous</a></li>
                                    <li><a class="dropdown-item" href="/public/rdv/register_rdv">Enregistrer un rendez-vous</a></li>
                                </ul>
                            </li>
                        <?php } else if (isset($_SESSION['user']) && !empty($_SESSION['user']['idPatient'])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarRdvDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-disabled="true">
                                    Mes rendez-vous
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarRdvDropdown">
                                    <li><a class="dropdown-item" href="/public/rdv/rdvPraticien">Calendrier des rendez-vous</a></li>
                                </ul>
                            </li>
                        <?php } else {?>
                            <li class="nav-item dropdown disabled" href="/users/login" tabindex="-1" aria-disabled="true">Mes rendez-vous
                            </li>
                        <?php } ?>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <?php if(isset($_SESSION['user']) && !empty($_SESSION['user']['email'])): ?>
                            <li class="nav-item">
                                <?php if (isset($_SESSION['user']['idPraticien'])) { ?>
                                    <a class="nav-link" href="/public/profil/praticien">Profil</a>
                                <?php } else { ?>
                                    <a class="nav-link" href="/public/profil/client">Profil</a>
                                <?php } ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/public/users/logout">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/public/users/login">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/public/users/register_praticien">Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Modal -->
        <div class="modal fade" id="modal-connexion" tabindex="-1" aria-labelledby="modal-connexion-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-connexion-label">Connexion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Connexion</button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="content" class="container content">
        <?= $contenu; ?>
    </main>
    <footer class="text-center mt-5">
        <p>Dernière mise à jour le 19/09/2022</p>
        <p>
            Copyright © des images ci-dessus sont détenus par
            <a href="">Voir la liste</a>
        </p>
    </footer>
</body>

</html>