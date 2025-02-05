function dbActionConfirmation(e, text){
    const agree = confirm("Do you want to confirm this action?");
    if(agree){
        e.setAttribute("disabled", true);
        e.classList.add("btn-outline-success");
        e.innerText = text;
    }
}