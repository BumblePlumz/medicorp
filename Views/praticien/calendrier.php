<section class="text-center mb-5 mt-5">
    <p class="h6">Veuillez choisir votre date</p>
    <input type="date" class="form-control" id="dateInput" name="dateInput">
    <button class="btn btn-outline-primary">Valider</button>
</section>

<section class="table-responsive">
  <table id="table-patient" class="table table-striped table-bordered table-hover">
    <thead class="thead">
      <tr>
        <th scope="col" onclick="sortTable(0)" class="table-active">
          <span>#id</span>
          <i id="sort-icon-0" class="fas fa-chevron-down">
        </th>
        <th scope="col" onclick="sortTable(1)">Heures</th>
        <th scope="col" onclick="sortTable(2)">Rendez-vous <i id="sort-icon-3"></th>
        <th scope="col" onclick="sortTable(3)">Patient <i id="sort-icon-5"></th>
        <th scope="col" onclick="sortTable(4)">Prise en charge <i id="sort-icon-5"></th>
        <th scope="col" onclick="sortTable(5)">Etat <i id="sort-icon-8"></th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody id="body-calendrier">
        
    </tbody>
  </table>
</section>