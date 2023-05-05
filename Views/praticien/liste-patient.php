<?php

use App\Core\GlobalFunctions;
use App\Models\UserDAO;

GlobalFunctions::addScript("/View/praticien/listing", "defer");
GlobalFunctions::addScript("/lodash/lodash", "defer");


?>

<h1 class="text-center">Mes patients</h1>

<div class="input-group mb-3">
  <span class="input-group-text" id="searchBar">Recherche : </span>
  <input id="recherche" type="text" class="form-control" placeholder="Rechercher..." aria-label="recherche" aria-describedby="searchBar">
</div>
<div class="table-responsive">
  <table id="table-patient" class="table table-striped table-bordered table-hover">
    <thead class="thead">
      <tr>
        <th scope="col" onclick="sortTable(0)" class="table-active">
          <span>#id</span>
          <i id="sort-icon-0" class="fas fa-chevron-down">
        </th>
        <th scope="col" onclick="sortTable(1)">Patient </th>
        <th scope="col" onclick="sortTable(2)">Date de naissance <i id="sort-icon-3"></th>
        <th scope="col" onclick="sortTable(3)">Adresse <i id="sort-icon-5"></th>
        <!-- TODO si besoin et si le temps -->
        <!-- <th scope="col" onclick="sortTable(4)">Rendez-vous <i id="sort-icon-5"></th> -->
        <th scope="col" onclick="sortTable(4)">actif <i id="sort-icon-8"></th>
        <th scope="col" onclick="sortTable(5)">Date d'enregistrement <i id="sort-icon-9"></th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody id="body-patient">
    </tbody>
  </table>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Précédent">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Suivant">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>
<!-- Modal -->
<div class="modal modal-lg fade" id="modal-update" tabindex="-1" aria-labelledby="modal-update-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modal-update-label">Formulaire de mise à jour du patient</h1>
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

        </form>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button id="btn-update-confirm" type="submit" class="btn btn-success">Valider</button>
        </div>

      </div>
    </div>
  </div>
  <style>
    .table-active {
      background-color: greenyellow !important;
    }
  </style>