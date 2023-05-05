// DOM
const TBODY = document.getElementById("body-pec");
const INPUT_SEARCH = document.getElementById("recherche");

const TYPE = document.getElementById("type");
const DUREE = document.getElementById("duree");
const PRIX = document.getElementById("prix");

// BTN
const BTN_NEW_PEC = document.getElementById("btn-pec-confirm");

// READY
document.addEventListener("DOMContentLoaded", () => {
  // Chargement des données
  let formData = new FormData();
  formData.append("action", "loadInfosPec");

  let url = window.location.href;

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (data.data.length > 0) {
        showPec(data);
        createErrorMessageBlock(data.message, data.success);
      } else {
        createErrorMessageBlock(
          "Pas de prise en charge dans la base de donnée",
          data.success
        );
      }
    })
    .catch((error) => {
      console.error(error);
      createErrorMessageBlock(error);
    });

  // Nouvelle prise en charge
  BTN_NEW_PEC.addEventListener("click", () => {
    let formData = new FormData();
    formData.append("action", "createPec");
    formData.append("type", TYPE.value);
    let selectValue = getSelectValue(DUREE);
    formData.append("duree", selectValue);
    formData.append("prix", PRIX.value);

    let url = window.location.href;

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        createErrorMessageBlock(data.message, data.success);
        location.href = location.href;
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
  });

  // Barre de recherche
  listeningSearchBar(INPUT_SEARCH);
});

function showPec(data) {
  let pecData = data.data;
  for (let i = 0; i < pecData.length; i++) {
    tableRow(TBODY, i, pecData[i]);
    listeningDelete(pecData[i]);
  }
}

function tableRow(tableBody, index, data) {
  let row = tableBody.insertRow(index);

  let cell0 = row.insertCell(0);
  cell0.innerHTML = data.id;

  let cell1 = row.insertCell(1);
  cell1.innerHTML = data.type;

  let cell2 = row.insertCell(2);
  cell2.innerHTML = data.duree;

  let cell3 = row.insertCell(3);
  cell3.innerHTML = data.prix;

  let cell4 = row.insertCell(4);
  cell4.innerHTML =
    "<button id='pec-delete-" +
    data.id +
    "' class='btn btn-outline-danger mt-auto' type='button' data-id='" +
    data.id +
    "'>Supprimer</button>";

  // Possibilité d'ajouter un switch actif
  // let cell4 = row.insertCell(4);
  // cell4.innerHTML += "<div class='form-check form-switch'>"
  //               +"<input class='form-check-input custom-control-input' type='checkbox' id='actif-"+data.id +"'" +(data.actif ? "checked" : "") +" data-id='" +data.id +"'>"
  //               +"<label class='form-check-label' for='actif-"+data.id+"'></label>"
  //               +"</div>";
}

function listeningDelete(data) {
  const BTN = document.getElementById("pec-delete-" + data.id);

  BTN.addEventListener("click", () => {
    let formData = new FormData();
    formData.append("action", "deletePec");
    formData.append("idPec", data.id);

    url = window.location.href;

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        createErrorMessageBlock(data.message, data.success);
        location.href = location.href;
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
  });
}

function sortTable(columnIndex) {
  let tableBody = document.getElementById("body-pec");
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