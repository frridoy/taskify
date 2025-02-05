let sendCorrectionBtn = document.querySelector(".send-correction-btn");
let savePreviewBtn = document.querySelector(".save-preview-btn");
let remarkCheckField = document.querySelectorAll(".remark-check");
let booleanArr = [];

const modalAttributes = {
    "data-bs-toggle": "modal",
    "data-bs-target": "#remarkModal"
};
function tmRemarkChecked(e){
    // toggle modal
    if(e.checked){  
        Object.keys(modalAttributes).forEach(attribute => {
            e.removeAttribute(attribute);
        });
        booleanArr.push(e.checked);
    }
    else{
        Object.keys(modalAttributes).forEach(attribute => {
            e.setAttribute(attribute, modalAttributes[attribute]);
        });
        booleanArr.pop();
    }
    
    // toggle button
    if(booleanArr.length > 0){
        sendCorrectionBtn.classList.remove("d-none");
        sendCorrectionBtn.classList.add("d-block");
        savePreviewBtn.classList.remove("d-block");
        savePreviewBtn.classList.add("d-none");
    }else{
        sendCorrectionBtn.classList.remove("d-block");
        sendCorrectionBtn.classList.add("d-none");
        savePreviewBtn.classList.remove("d-none");
        savePreviewBtn.classList.add("d-block");
    }
}


