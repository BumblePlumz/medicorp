<?php
use App\Core\GlobalFunctions;
use App\Models\UserDAO;

GlobalFunctions::addScript("/View/patient/listing", "defer");


?>

<h1 class="text-center">Mes patients</h1>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#id</th>
      <th scope="col">Nom</th>
      <th scope="col">Prénom</th>
      <th scope="col">Date de naissance</th>
      <th scope="col">Ville</th>
      <th scope="col">Adresse</th>
      <th scope="col">Email</th>
      <th scope="col">Téléphone</th>
      <th scope="col">actif</th>
      <th scope="col">Date d'enregistrement</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="body-patient">
  </tbody>
</table>