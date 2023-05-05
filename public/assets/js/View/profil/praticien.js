// FORM
const NOM = document.getElementById("nom");
const PRENOM = document.getElementById("prenom");
const DATE_N = document.getElementById("dateN");
const ADR = document.getElementById("adr");
const VILLE = document.getElementById("ville");
const CP = document.getElementById("cp");
const EMAIL = document.getElementById("email");
const TEL = document.getElementById("tel");
const ACTIVITE = document.getElementById("activite");
const ADELI = document.getElementById("adeli");
const ACTIF = document.getElementById("actif");
const DATE_C = document.getElementById("dateC");

// BTN
const BTN_EDIT_SAVE = document.getElementById("btn-edit-save");

const BTN_DISABLE = document.getElementById("btn-disable");
const BTN_DISABLE_CONFIRM = document.getElementById("btn-disable-confirm");

const BTN_ACTIVATE = document.getElementById("btn-activate");
const BTN_ACTIVATE_CONFIRM = document.getElementById("btn-activate-confirm");

const BTN_MDP_CONFIRM = document.getElementById("btn-mdp-confirm");

// Attente du chargement du document
document.addEventListener("DOMContentLoaded", () => {
  loadInfos();
  editInfos(BTN_EDIT_SAVE);
  disableAccount(BTN_DISABLE_CONFIRM);
  activateAccount(BTN_ACTIVATE_CONFIRM);
  changePwd(BTN_MDP_CONFIRM);
});

function loadInfos() {
  let formData = new FormData();
  formData.append("action", "loadInfosPraticien");

  let url = window.location.href;

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      let praticien = data.data[0];

      if (data.success.subProcess){
        createErrorMessageBlock(data.message, data.success.subProcess);
      } else {
        createErrorMessageBlock(data.message, data.success);
      }

      //  TODO afficher les infos Patient
      NOM.innerHTML += "<br>" + praticien.nom;
      PRENOM.innerHTML += "<br>" + praticien.prenom;

      // Gestion de la mise en forme de la date
      // Fonction globale dans /view/default/default.js
      let dateNaissance = new Date(praticien.date_naissance.date);
      let formatedDateN = formateDate(dateNaissance, "date");
      console.log(formatedDateN);
      DATE_N.innerHTML += "<br><p>" + formatedDateN+"</p>";
      ADR.innerHTML += "<br><p>" + praticien.adresse+"</p>";
      VILLE.innerHTML += "<br><p>" + praticien.ville+"</p>";
      CP.innerHTML += "<br><p>" + praticien.code_postal+"</p>";
      EMAIL.innerHTML += "<br><p>" + praticien.email+"</p>";
      TEL.innerHTML += "<br><p>" + praticien.telephone+"</p>";
      ACTIVITE.innerHTML += "<br><p>" + praticien.activite+"</p>";
      ADELI.innerHTML += "<br><p>" + praticien.numero_adeli+"</p>";
      if (praticien.actif === 1) {
        ACTIF.innerHTML +=
          "<p class='text-success'>Compte actif</p>" +
          "<button id='desactiver' class='btn btn-outline-danger mt-auto' type='button' data-bs-toggle='modal' data-bs-target='#modal-disable'>Désactiver mon compte</button>";
      } else {
        ACTIF.innerHTML +=
          "<p class='text-danger'>Compte inactif</p>" +
          "<button id='activer' class='btn btn-outline-success mt-auto' type='button' data-bs-toggle='modal' data-bs-target='#modal-activate'>Réactiver mon compte</button>";
      }

      // Gestion de la mise en forme de la date
      let dateCreation = new Date(praticien.date_creation.date);
      DATE_C.innerHTML += "<br>" + dateCreation;
    })
    .catch((error) => {
      console.error(error);
      createErrorMessageBlock(error);
    });
}

function editInfos(domObject) {
  const NOM = document.getElementById("edit-nom");
  const PRENOM = document.getElementById("edit-prenom");
  const DATE_N = document.getElementById("edit-date-n");
  const ADR = document.getElementById("edit-adresse");
  const VILLE = document.getElementById("edit-ville");
  const CP = document.getElementById("edit-cp");
  const EMAIL = document.getElementById("edit-email");
  const TEL = document.getElementById("edit-tel");
  const ACTIVITE = document.getElementById("edit-activite");
  const ADELI = document.getElementById("edit-adeli");

  domObject.addEventListener("click", (event) => {
    let formData = new FormData();
    formData.append("action", "editInfosPraticien");
    formData.append("nom", NOM.value);
    formData.append("prenom", PRENOM.value);
    formData.append("date_naissance", DATE_N.value);
    formData.append("adresse", ADR.value);
    formData.append("ville", VILLE.value);
    formData.append("code_postal", CP.value);
    formData.append("email", EMAIL.value);
    formData.append("telephone", TEL.value);
    formData.append("activite", ACTIVITE.value);
    formData.append("numero_adeli", ADELI.value);

    let url = window.location.href;
    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        location.href = location.href;
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
  });
}

function disableAccount(domObject) {
  domObject.addEventListener("click", (event) => {
    let formData = new FormData();
    formData.append("action", "disableAccount");

    let url = window.location.href;
    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        location.href = location.href;
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
  });
}

function activateAccount(domObject) {
  domObject.addEventListener("click", (event) => {
    let formData = new FormData();
    formData.append("action", "activateAccount");
    let url = window.location.href;
    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        location.href = location.href;
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
  });
}

function changePwd(domObject){
  const PWD = document.getElementById("password");
  const PWD_CONFIRM = document.getElementById("password-confirm");
  const PWD_OLD = document.getElementById("password-old");

  domObject.addEventListener("click", (e) =>{
    console.log("ça marche");
    if (PWD.value == PWD_CONFIRM.value){
      let formData = new FormData();
      formData.append("action", "changePwd");
      formData.append("pwd", PWD_CONFIRM.value);
      formData.append("oldPwd", PWD_OLD.value);

      let url = window.location.href;
      fetch(url, {
        method: "POST",
        body: formData,
      })
      .then((response) => response.json())
      .then((data) => {
        location.href = location.href;
      })
      .catch((error) => {
        console.error(error);
        createErrorMessageBlock(error);
      });
    } else {
      createErrorMessageBlock("Les mots de passes ne sont pas identiques")
    }

  })
}