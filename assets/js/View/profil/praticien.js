document.addEventListener("DOMContentLoaded", ()=>{
    let formData = new FormData();
    formData.append("action", "load_infos_praticien");

    let url = window.location.href;

    fetch(url, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        //  TODO afficher listing Patient
        createErrorMessageBlock(data.message, data.success);
    })
    .catch(error => {
        console.error(error);
        createErrorMessageBlock(error);
    })
});