// DOM
const TBODY = document.getElementById("body-patient");
const INPUT_SEARCH = document.getElementById("recherche");

// Modal update
const NOM = document.getElementById("edit-nom");
const PRENOM = document.getElementById("edit-prenom");
const DATE_N = document.getElementById("edit-date-n");
const ADR = document.getElementById("edit-adresse");
const VILLE = document.getElementById("edit-ville");
const CP = document.getElementById("edit-cp");
const EMAIL = document.getElementById("edit-email");
const TEL = document.getElementById("edit-tel");


document.addEventListener("DOMContentLoaded", () => {
  // Chargement des patients à l'ouverture de la page
  let formData = new FormData();
  formData.append("action", "loadPatients");

  let url = window.location.href;

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (data.data.length > 0) {
        showPatients(data);
        createErrorMessageBlock(data.message, data.success);
      } else {
        createErrorMessageBlock(
          "Pas de patient dans la base de donnée",
          data.success
        );
      }
    })
    .catch((error) => {
      console.error(error);
      createErrorMessageBlock(error);
    });
    // Fin FETCH
    // Barre de recherche
    listeningSearchBar(INPUT_SEARCH);
});

function showPatients(data) {
  let patientData = data.data;
  for (let i = 0; i < patientData.length; i++) {
    tableRow(TBODY, i, patientData[i]);
    listeningSwitchActif(patientData[i]);
    listeningDeletePatient(patientData[i]);
    listeningUpdatePatient(patientData[i]);
  }
}

function tableRow(tableBody, index, data) {
  let row = tableBody.insertRow(index);

  let cell0 = row.insertCell(0);
  cell0.innerHTML = data.id;

  let cell1 = row.insertCell(1);
  cell1.innerHTML = data.nom+" "+data.prenom;
  cell1.innerHTML += "<br>";
  cell1.innerHTML += "Email : "+data.email;
  cell1.innerHTML += "<br>";
  cell1.innerHTML += "Téléphone : "+data.telephone;


  let cell2 = row.insertCell(2);
  const dateString = data.dateNaissance.date.split(" ")[0]; // sépare la date et l'heure et récupère la date uniquement
  cell2.innerHTML = dateString;

  let cell3 = row.insertCell(3);
  cell3.innerHTML = data.ville;
  cell3.innerHTML += "<br>";
  cell3.innerHTML += data.adresse;

  let cell4 = row.insertCell(4);
  cell4.innerHTML += "<div class='form-check form-switch'>" 
                +"<input class='form-check-input custom-control-input' type='checkbox' id='actif-"+data.id +"'" +(data.actif ? "checked" : "") +" data-id='" +data.id +"'>" 
                +"<label class='form-check-label' for='actif-"+data.id+"'></label>"
                +"</div>";

  let cell5 = row.insertCell(5);
  cell5.innerHTML = data.dateCreation.date;

  let cell6 = row.insertCell(6);
  cell6.innerHTML = "<div class='d-flex flex-column align-items-center'>"
                  +"<button id='patient-update-"+data.id+"' class='btn btn-warning mx-auto w-100' type='button' data-id='"+data.id+"' data-bs-toggle='modal' data-bs-target='#modal-update'>Modifier</button>"
                  +"<button id='patient-delete-"+data.id+"' class='btn btn-danger mx-auto w-100' type='button' data-id='"+data.id+"'>Supprimer</button>"
                  +"</div>";
}

function listeningDeletePatient(data){
  const BTN = document.getElementById('patient-delete-'+data.id);
  BTN.addEventListener("click", ()=>{
    let formData = new FormData();
    formData.append("action", "deletePatient");
    formData.append("idPatient", data.id);

    url = window.location.href;

    fetch(url, {
      method: "POST",
      body: formData,
    })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.error(error);
      createErrorMessageBlock(error);
    });
  })
}

function listeningUpdatePatient(data){
  const BTN = document.getElementById('patient-update-'+data.id);
  const BTN_VALID = document.getElementById("btn-update-confirm");
  const idPatient = data.id;

  BTN_VALID.setAttribute("data-id", idPatient);

  BTN.addEventListener("click", ()=>{
    console.log(idPatient);
    BTN_VALID.addEventListener("click", ()=>{
      let formData = new FormData();
      formData.append("action", "updatePatient");
      formData.append("idPatient", idPatient);
      formData.append("nom", NOM.value);
      formData.append("prenom", PRENOM.value);
      formData.append("dateDeNaissance", DATE_N.value);
      formData.append("adresse", ADR.value);
      formData.append("ville", VILLE.value);
      formData.append("cp", CP.value);
      formData.append("email", EMAIL.value);
      formData.append("telephone", TEL.value);

      url = window.location.href;
  
      fetch(url, {
        method: "POST",
        body: formData,
      })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
    })
  })

}

function listeningSwitchActif(data) {
  const input = document.getElementById("actif-" + data.id);
  input.addEventListener("click", () => {
    console.log("début switch");
    const dataId = input.getAttribute("data-id");

    let formData = new FormData();
    formData.append("action", "switchActif");
    formData.append("idPatient", data.id);

    const url = window.location.href;

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
  });
}

function sortTable(columnIndex) {
  let tableBody = document.getElementById("body-patient");
  let tableRows = Array.from(tableBody.rows);
  
  // Remove sort icons
  removeSortIcons();

  let order = "asc";
  if (tableBody.getAttribute("data-sort-order") === "asc") {
    order = "desc";
  }

  let sortedRows = _.orderBy(tableRows, (row) => {
    let cellValue = row.cells[columnIndex].textContent.trim().toLowerCase();
    if (columnIndex === 2) {
      cellValue = new Date(cellValue).getTime();
    } else if (columnIndex === 4) {
      cellValue = row.cells[columnIndex].querySelector("input").checked;
    } else {
      cellValue = isNaN(cellValue) ? cellValue : parseFloat(cellValue);
    }
    return cellValue;
  }, order);

  _.forEach(sortedRows, (row) => {
    tableBody.appendChild(row);
  });

  tableBody.setAttribute("data-sort-order", order);

  let arrow = order === "asc" ? "fa-chevron-up" : "fa-chevron-down";
  
  // Récupère le nth child du tablehead par son Index de colonne.
  let th = document.querySelector(`th:nth-child(${columnIndex + 1})`);
  let arrowIcon = document.createElement("i");
  arrowIcon.classList.add("fas", arrow);
  th.appendChild(arrowIcon);
  th.classList.add("table-active");
}

function removeSortIcons() {
  let ths = document.querySelectorAll('th');
  ths.forEach(th => {
    let upIcon = th.querySelector("i.fa-chevron-up:first-child");
    let downIcon = th.querySelector("i.fa-chevron-down:first-child");
    th.classList.remove("table-active");
    if (upIcon) {
      th.removeChild(upIcon);
    }
    if (downIcon) {
      th.removeChild(downIcon);
    }
    th.innerHTML = th.textContent.trim();
  });
}

function listeningSearchBar(domObject){
console.log("début search");
domObject.addEventListener("keydown", (event)=>{
  if (event.keyCode === 13) {
    event.preventDefault();
    var valeur = domObject.value.toLowerCase();
    rechercher(valeur);
  }
  // const resultat = _.filter(personnes, ({ nom }) => nom.includes('Doe'));
})

function rechercher(valeur) {
  const tbody = document.querySelector('tbody');
  const rows = tbody.querySelectorAll('tr');

  rows.forEach(function(row) {
    const text = row.textContent.toLowerCase();
    const index = text.indexOf(valeur.toLowerCase());

    row.style.display = index > -1 ? 'table-row' : 'none';
  });
}

}

const updateButtons = document.querySelectorAll("button[id^='patient-update-']");

updateButtons.forEach(function(button) {
  button.addEventListener("click", function() {
    let patientId = this.getAttribute("data-id");
    // Utilisez l'ID du patient pour remplir les champs de la modal
    // Ouvrir la modal
  });
});
