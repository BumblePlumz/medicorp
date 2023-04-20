// DOM
const TBODY = document.getElementById("body-patient");

// Tableau d'id



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
    .then(()=>{
        // Switch actif
        const SWITCHES = document.querySelectorAll(".custom-control-input");

        // Ecoute des switches de type actif
        SWITCHES.forEach((element) => {
        listeningSwitchActif(element);
  });
    })
    .catch((error) => {
      console.error(error);
      createErrorMessageBlock(error);
    });

    // Triage
    const thActive = document.querySelector('.active');
    thActive.addEventListener('click', () => {
        sortPatientsByActive();
    });

});

function showPatients(data) {
  let patientData = data.data;
  let tbody = document.getElementById("body-patient");
  for (let i = 0; i < patientData.length; i++) {
    tableRow(tbody, i, patientData[i]);
  }
}

function tableRow(tableBody, index, data) {
  let row = tableBody.insertRow(index);

  let cell1 = row.insertCell(0);
  cell1.innerHTML = data.id;

  let cell2 = row.insertCell(1);
  cell2.innerHTML = data.nom;

  let cell3 = row.insertCell(2);
  cell3.innerHTML = data.prenom;

  let cell4 = row.insertCell(3);
  const dateString = data.dateNaissance.date.split(" ")[0]; // sépare la date et l'heure et récupère la date uniquement
  cell4.innerHTML = dateString;

  let cell5 = row.insertCell(4);
  cell5.innerHTML = data.ville;

  let cell6 = row.insertCell(5);
  cell6.innerHTML = data.adresse;

  let cell7 = row.insertCell(6);
  cell7.innerHTML = data.email;

  let cell8 = row.insertCell(7);
  cell8.innerHTML = data.telephone;

  let cell9 = row.insertCell(8);
  cell9.innerHTML += "<div class='form-check form-switch'>" 
                +"<input class='form-check-input custom-control-input' type='checkbox' id='actif-"+data.id +"'" +(data.actif ? "checked" : "") +" data-id='" +data.id +"'>" 
                +"<label class='form-check-label' for='actif-"+data.id+"'></label>"
                +"</div>";
  let cell10 = row.insertCell(9);
  cell10.innerHTML = data.dateCreation.date;
}

function listeningSwitchActif(domObject) {
  domObject.addEventListener("click", () => {
    console.log("début switch");
    const input = document.getElementById("actif-" + data.id);
    const dataId = input.getAttribute("data-id");

    let formData = new FormData();
    formData.append("action", "switchActif");
    formData.append("idPatient", );

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
      if (columnIndex === 3) {
        cellValue = new Date(cellValue).getTime();
      } else if (columnIndex === 8) {
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
}
  
  
function removeSortIcons() {
    let ths = document.querySelectorAll('th');
    ths.forEach(th => {
      let upIcon = th.querySelector("i.fa-chevron-up:first-child");
      let downIcon = th.querySelector("i.fa-chevron-down:first-child");
      if (upIcon) {
        th.removeChild(upIcon);
      }
      if (downIcon) {
        th.removeChild(downIcon);
      }
      th.innerHTML = th.textContent.trim();
    });
}
  
  