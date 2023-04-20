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