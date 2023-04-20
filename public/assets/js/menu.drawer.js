// "use strict";
// window.addEventListener("DOMContentLoaded", (event) => {
//   /* MENU */
//   const LeMenu = document.getElementById("LeMenu");
//   const CmdMenu = document.getElementById("CmdMenu");
//   CmdMenu.addEventListener('click',function(){
//     LeMenu.style.display = (LeMenu.style.display == 'none')? '':'none';
//   });
//   // au chargement de la page
//   window.onload = function(){
//     // on teste la largeur de la fenêtre
//     var ww = window.innerWidth; // en pixels
//     LeMenu.style.display = ( ww > 768 )? '':'none';
//     CmdMenu.style.display = ( ww > 768 )? 'none':'';
//   };
//   // au redimensionnement de la fenêtre
//   window.onresize = function(){
//     // on teste la largeur de la fenêtre
//     var ww = window.innerWidth; // en pixels
//     LeMenu.style.display = ( ww > 768 )? '':'none';
//     CmdMenu.style.display = ( ww > 768 )? 'none':'';
//   };

// });

// $(document).ready(function () {
//   $('#toggle').click(function() {
//      $(this).toggleClass('active');
//      $('#fullnav').toggleClass('open');
//     });
//   });

const drawer = document.getElementById("drawer");
const btn = document.getElementById("button-drawer");
let id = null;


btn.addEventListener('click', () => {
  if (drawer.classList.contains("toggle")) {
    moveBackward();
    drawer.classList.remove("toggle");
  } else {
    moveForward();
    drawer.classList.add("toggle");
  }
});

function moveForward() {
  let elem = document.getElementById("drawer");
  let left = -200;
  clearInterval(id);
  id = setInterval(frame, 1);
  function frame(){
    if (left == 0) { 
      clearInterval(id);
    } else {
      left += 2;
      drawer.style.left = left + 'px';
    }
  }
}
function moveBackward() {
  let elem = document.getElementById("drawer");
  let left = 0;
  clearInterval(id);
  id = setInterval(frame, 1);
  function frame(){
    if (left == -200) {
      clearInterval(id);
    } else {
      left -= 2;
      drawer.style.left = left + 'px';
    }
  }
}