/*=========================== 
upload template logo
===========================*/
function templateLogoUpload(i,d){
  const input = document.getElementById(i);
  const display = document.getElementById(d);
    if (input) {
      input.addEventListener("change", () => {
        let reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.addEventListener("load", () => {
          display.src = reader.result;
        });
      });
    }
}
// ====================================================