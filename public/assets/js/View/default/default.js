
/**
 * Affiche un message d'erreur (rouge) ou de succès (vert) 
 * @param {string} response 
 * @param {boolean} success 
 */
function createErrorMessageBlock(response, success=false) {
    const content = document.getElementById("content");
    let alertBoxContainer = document.querySelector('#alertBoxContainer');
    if (alertBoxContainer !== null) {
        alertBoxContainer.remove();
    }
    let boxColor = "alert-danger"
    if(success){
        boxColor = "alert-success"
    }
    const alertBox = '<div id="alertBoxContainer"><div id="alertBox" class="alert '+boxColor+' alert-dismissible fade show" role="alert"><strong>' + response + '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = alertBox;
    content.appendChild(tempDiv);
}
/**
 * Transforme une date en string formatée
 * @param {*} dateNaissance 
 * @returns string
 */
function formateDate(date, action){
    let formatedDate = "";
    if (action === "date"){
        let year = date.getFullYear();
        let month = ('0' + (date.getMonth() + 1)).slice(-2); // extraire le mois (2 chiffres) et ajouter un 0 devant si nécessaire
        let day = ('0' + date.getDate()).slice(-2); // extraire le jour (2 chiffres) et ajouter un 0 devant si nécessaire
        formatedDate = `${day} - ${month} - ${year}`;
    }
    if (action === "date_time"){
        let year = date.getFullYear();
        let month = ('0' + (date.getMonth() + 1)).slice(-2); // extraire le mois (2 chiffres) et ajouter un 0 devant si nécessaire
        let day = ('0' + date.getDate()).slice(-2); // extraire le jour (2 chiffres) et ajouter un 0 devant si nécessaire
        let hours = ('0' + date.getHours()).slice(-2); // extraire les heures (2 chiffres) et ajouter un 0 devant si nécessaire
        let minutes = ('0' + date.getMinutes()).slice(-2); // extraire les minutes (2 chiffres) et ajouter un 0 devant si nécessaire
        let seconds = ('0' + date.getSeconds()).slice(-2); // extraire les secondes (2 chiffres) et ajouter un 0 devant si nécessaire
        formatedDate = `le ${day} - ${month} - ${year} à ${hours}:${minutes}:${seconds}`;
    }
    return formatedDate;
}


function sortTable(body, columnIndex) {
    let tableRows = Array.from(body.rows);
    
    // Remove sort icons
    removeSortIcons();

    let order = "asc";
    if (body.getAttribute("data-sort-order") === "asc") {
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
      body.appendChild(row);
    });
  
    body.setAttribute("data-sort-order", order);
  
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
