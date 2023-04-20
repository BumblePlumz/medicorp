// DOM
const FORM = document.getElementById("form-patient");
const ALERT = document.getElementById("alert");

// FORM 
const NOM = document.getElementById("nom");
const PRENOM = document.getElementById("prenom");
const DATE_NAISSANCE = document.getElementById("date-de-naissance");
const ADR = document.getElementById("adresse");
const VILLE = document.getElementById("ville");
const CP = document.getElementById("cp");
const EMAIL = document.getElementById("email");
const TEL = document.getElementById("telephone");

document.addEventListener("DOMContentLoaded", ()=>{
    // Listening on the form
    FORM.addEventListener("submit", (event)=>{
        event.preventDefault();

        let formData = new FormData();
        formData.append("action", "register");
        formData.append("nom", NOM.value);
        formData.append("prenom", PRENOM.value);
        formData.append("date-de-naissance", DATE_NAISSANCE.value);
        formData.append("adresse", ADR.value);
        formData.append("ville", VILLE.value);
        formData.append("cp", CP.value);
        formData.append("email", EMAIL.value);
        formData.append("telephone", TEL.value);

        // let url = window.location.origin+"/public/patient/test"; 
        let url = window.location.href;

        fetch(url, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            createErrorMessageBlock(data.message, data.success);
            if (data.success != true){

            } 
        })
        .catch(error => console.error(error))
    })
    
})