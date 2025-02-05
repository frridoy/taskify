function uploadPhoto(i, d){
  let input = document.getElementById(i);
  let display = document.getElementById(d);
  input.addEventListener("change", () => {
    display.innerText = input.files[0].name;
  });
}