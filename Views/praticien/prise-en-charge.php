<?php

use App\Core\GlobalFunctions;

GlobalFunctions::addScript("View/praticien/priseEnCharge", "defer");
GlobalFunctions::addScript("lodash/lodash", "defer");
?>
<section>
  <p class="h1 text-center">Prise en charge</p>
  <div class="text-center">
    <button class="btn btn-outline-primary mx-auto mt-3 mb-3" type='button' data-bs-toggle='modal' data-bs-target='#modal-pec'>Nouvelle prise en charge</button>
  </div>
  <div class="input-group mb-3">
    <span class="input-group-text" id="searchBar">Recherche : </span>
    <input id="recherche" type="text" class="form-control" placeholder="Rechercher..." aria-label="recherche" aria-describedby="searchBar">
  </div>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col" onclick="sortTable(0)">#id</th>
        <th scope="col" onclick="sortTable(1)">Type</th>
        <th scope="col" onclick="sortTable(2)">Durée (en min)</th>
        <th scope="col" onclick="sortTable(3)">Prix (en euros)</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody id="body-pec">
    </tbody>
  </table>
</section>
<div class="modal fade" id="modal-pec" tabindex="-1" aria-labelledby="modal-pec-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modal-pec-label">Formulaire de prise en charge</h1>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <div class="input-group-prepend w-50">
            <span class="input-group-text" id="type-span">Type : </span>
          </div>
          <input type="text" class="form-control" id="type" aria-describedby="type-span">
        </div>

        <!-- <label for="password-confirm">Confirmer mot de passe</label> -->
        <div class="input-group mb-3">
          <div class="input-group-prepend w-50">
            <span class="input-group-text" id="prix-span">Prix : </span>
          </div>
          <input type="text" class="form-control" id="prix" aria-describedby="prix-span">
        </div>
        
        <!-- <label for="password">Nouveau mot de passe</label> -->
        <div class="input-group mb-3">
          <!-- <div class="input-group-prepend w-50">
            <span class="input-group-text" id="duree-span">Durée (en min) : </span>
          </div>
          <input type="text" class="form-control" id="duree" aria-describedby="duree-span"> -->
          <select id="duree" class="form-select" aria-label="Default select example">
            <option selected hidden>Durée (en min) :</option>
            <option value="30">30 minutes</option>
            <option value="60">60 minutes</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button id="btn-pec-confirm" type="submit" class="btn btn-success">Valider</button>
      </div>
    </div>
  </div>
</div>