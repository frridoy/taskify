/*=================== 
Main navbar sticky 
===================*/
window.onscroll = function() {myFunction()};

var navbar = document.querySelector(".navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky-navbar");
  } else {
    navbar.classList.remove("sticky-navbar");
  }
}
// ================================================