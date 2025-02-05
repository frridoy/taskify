function passToggle(e){
  let toggleIcon = e.children[0];
  let passInput = e.parentElement.children[0];

  if(toggleIcon.classList.value.includes("bi-eye-slash-fill")){
    toggleIcon.classList.remove("bi-eye-slash-fill");
    toggleIcon.classList.add("bi-eye-fill");
    passInput.type = "text";
  }else{
    toggleIcon.classList.add("bi-eye-slash-fill");
    toggleIcon.classList.remove("bi-eye-fill");
    passInput.type = "password";
  }
}