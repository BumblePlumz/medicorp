<?php

use App\Core\GlobalFunctions;

GlobalFunctions::addScript("/View/profil/praticien", "defer");

?>

<section class="container text-center">
    <div class="header">
        <h2>Profil Praticien</h2>
        <p>afficher / éditer</p>
        <?php print_r($_SESSION) ?>
    </div>
    <div class="row">
        
        <div class="col-6 row mt-5">
            <h3>Informations Utilisateurs <button class="btn btn-sm btn-outline-primary col-6">Edit</button></h3>
            <div class="row">
                <p class="col-6">Nom :</p>
                <p id="nom" class="col-6 text-left">Nguyen</p>
            </div>
            <p>Prénom :</p>
            <p>Date de naissance :</p>
            <p>Adresse :</p>
            <p>Ville :</p>
            <p>Code postal :</p>
            <p>Email :</p>
            <p>Téléphone :</p>
            <p>Mot de passe :</p>
            <p>Actif :</p>
            <p>Date de création :</p>
        </div>
        <div class="col-6 row mt-5">
            <h3>Informations Praticien <button class="btn btn-sm btn-outline-primary col-6">Edit</button></h3>
            <p>Type d'activité : </p>
            <p>Numéro adéli :</p>
            <p>Actif :</p>
        </div>
    </div>
</section>

