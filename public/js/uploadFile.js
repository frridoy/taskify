/*=========================== 
upload img input 
===========================*/
const display = document.querySelector(".edit-profile-img img");
const input = document.querySelector("#profile-img");

if (input) {
  input.addEventListener("change", () => {
    let reader = new FileReader();
    reader.readAsDataURL(input.files[0]);
    reader.addEventListener("load", () => {
      display.src = reader.result;
    });
  });
}
// ====================================================