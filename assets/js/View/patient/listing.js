// DOM
const TBODY = document.getElementById("body-patients");


document.addEventListener("DOMContentLoaded", ()=>{
    console.log("Doc loaded");

    let formData = new FormData();
    formData.append("action", "load_patients");

    let url = window.location.href;

    fetch(url, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        //  TODO afficher listing Patient
        showPatients(data);
        createErrorMessageBlock(data.message, data.success);
    })
    .catch(error => {
        console.error(error);
        createErrorMessageBlock(error);
    })
});


function showPatients(data)
{
    console.log("début")
    let patientData = data.data;
    let tbody = document.getElementById("body-patient");
    console.log(patientData[0].date_naissance);
    for (let i=0;i<patientData.length;i++) {
        console.log("boucle : "+i);
        tableRow(tbody, i, patientData[i]);
    }
}

function tableRow(tableBody, index, data)
{
    let row = tableBody.insertRow(index);

    let cell1 = row.insertCell(0);
    cell1.innerHTML = data.id;

    let cell2 = row.insertCell(1);
    cell2.innerHTML = data.nom;
    
    let cell3 = row.insertCell(2);
    cell3.innerHTML = data.prenom;
    
    let cell4 = row.insertCell(3);
    cell4.innerHTML = data.date_naissance;
    
    let cell5 = row.insertCell(4);
    cell5.innerHTML = data.ville;
    
    let cell6 = row.insertCell(5)
    cell6.innerHTML = data.adresse;
    
    let cell7 = row.insertCell(6);
    cell7.innerHTML = data.email;
    
    let cell8 = row.insertCell(7);
    cell8.innerHTML = data.telephone;
    
    let cell9 = row.insertCell(8);
    cell9.innerHTML = data.actif;
    
    let cell10 = row.insertCell(9);
    cell10.innerHTML = data.created_at;
}