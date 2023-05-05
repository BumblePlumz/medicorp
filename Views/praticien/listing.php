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

<style>
  .table-active {
    background-color: greenyellow !important;
  }
</style>