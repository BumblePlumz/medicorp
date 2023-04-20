<?php

use App\Core\GlobalFunctions;

GlobalFunctions::addScript("/View/profil/praticien", "defer");

?>

<section class="container text-center">
    <div class="header">
        <h2>Profil Praticien</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <button id="edit-info-praticien" class="btn btn-outline-primary col-6" type="button" data-bs-toggle="modal" data-bs-target="#modal-edit">Editer les informations</button>
        </div>
        <div class="col-12 col-xl-6 row mt-5">
            <h3>Information Utilisateur</h3>
            <div class="col-6">
                <p id="nom" class="border rounded shadow bg-light"><u>Nom :</u></p>
            </div>
            <div class="col-6">
                <p id="prenom" class="border rounded shadow bg-light"><u>Prénom :</u></p>
            </div>
            <div class="col-6">
                <p id="dateN" class="border rounded shadow bg-light"><u>Date de naissance :</u></p>
                <p id="email" class="border rounded shadow bg-light"><u>Email :</u></p>
                <p id="tel" class="border rounded shadow bg-light"><u>Téléphone :</u></p>
            </div>
            <div class="col-6">
                <p id="adr" class="border rounded shadow bg-light"><u>Adresse :</u></p>
                <p id="ville" class="border rounded shadow bg-light"><u>Ville :</u></p>
                <p id="cp" class="border rounded shadow bg-light"><u>Code postal :</u></p>
            </div>
        </div>
        <div class="col-12 col-xl-6 row mt-5">
            <h3>Informations Praticien</h3>
            <div class="col-12 ">
                <p id="activite" class=" border rounded shadow bg-light"><u>Type d'activité :</u></p>
            </div>
            <div class="col-12">
                <p id="adeli" class="border rounded shadow bg-light"><u>Numéro adéli :</u></p>
            </div>
        </div>
        <div class="row justify-content-around bg-gray">
            <div class="form-group col col-md-5 mb-3 pb-3 pt-3 border rounded shadow bg-light">
                <p class="">Modifier mon mot de passe</p>
                <button class="btn btn-outline-primary mt-auto" type='button' data-bs-toggle='modal' data-bs-target='#modal-mdp'>Changer mot de passe</button>
            </div>
            <div id="actif" class="col-5 col-md-5 mb-3 pt-3 pb-3 border rounded shadow bg-light">
                <u>Actif :</u>
            </div>
            <div id="dateC" class="col-12 border rounded shadow bg-light pt-3 pb-3">
                <u>Date de création :</u>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-edit-label">Modifier les informations personnelles</h1>
                </div>
                <div class="modal-body">
                    <form id="form-edit" class="">
                        <div class="mb-3 row">
                            <label for="nom" class="col-sm-2 col-form-label">Nom :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-nom" name="nom" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="prenom" class="col-sm-2 col-form-label">Prénom :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-prenom" name="prenom" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="date-n" class="col-sm-2 col-form-label">Date de naissance :</label>
                            <div class="col-sm-10">
                                <input type="date" id="edit-date-n" name="date-n" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="adresse" class="col-sm-2 col-form-label">Adresse :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-adresse" name="adresse" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ville" class="col-sm-2 col-form-label">Ville :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-ville" name="ville" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="cp" class="col-sm-2 col-form-label">Code Postal :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-cp" name="cp" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Email :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-email" name="email" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tel" class="col-sm-2 col-form-label">Téléphone :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-tel" name="tel" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="activite" class="col-sm-2 col-form-label">Type d'activité :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-activite" name="activite" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="adeli" class="col-sm-2 col-form-label">Numéro Adéli :</label>
                            <div class="col-sm-10">
                                <input type="text" id="edit-adeli" name="adeli" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button id="btn-edit-save" type="submit" class="btn btn-success">Sauvegarder les changements</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-disable" tabindex="-1" aria-labelledby="modal-disable-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-disable-label">Désactivation de votre compte</h1>
                </div>
                <div class="modal-body">
                    <p>Etes-vous sur de vouloir désactiver votre compte ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button id="btn-disable-confirm" type="submit" class="btn btn-danger">Désactiver mon compte</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-activate" tabindex="-1" aria-labelledby="modal-activate-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-activate-label">Désactivation de votre compte</h1>
                </div>
                <div class="modal-body">
                    <p>Etes-vous sur de vouloir réactiver votre compte ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button id="btn-activate-confirm" type="submit" class="btn btn-success">Activé mon compte</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-mdp" tabindex="-1" aria-labelledby="modal-mdp-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-mdp-label">Modification du mot de passe</h1>
                </div>
                <div class="modal-body">
                <div class="input-group mb-3">
                        <div class="input-group-prepend w-50">
                            <span class="input-group-text text-danger" id="password-old-span">Ancien mot de passe : </span>
                        </div>
                        <input type="text" class="form-control" id="password-old" aria-describedby="password-span">
                    </div>

                    <!-- <label for="password">Nouveau mot de passe</label> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-50">
                            <span class="input-group-text text-danger" id="password-span">Nouveau mot de passe : </span>
                        </div>
                        <input type="text" class="form-control" id="password" aria-describedby="password-span">
                    </div>

                    <!-- <label for="password-confirm">Confirmer mot de passe</label> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-50">
                            <span class="input-group-text text-danger" id="password-c-span">Confirmer mot de passe : </span>
                        </div>
                        <input type="text" class="form-control" id="password-confirm" aria-describedby="password-c-span">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button id="btn-mdp-confirm" type="submit" class="btn btn-success">Valider</button>
                </div>
            </div>
        </div>
    </div>
</section>