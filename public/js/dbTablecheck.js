const tableHeader = document.getElementById("flexCheckDefault");
const tableContent = document.querySelectorAll(".table-check");

tableHeader.addEventListener("change", function(){
    if(this.checked){
        for(let content of tableContent){
            content.checked = true;
        }
    }else{
        for(let content of tableContent){
            content.checked = false;
        }
    }
    
})