let cashContainer = document.querySelector(".cash-container");
let challanContainer = document.querySelector(".challan-container");
// let payInvoiceBtn = document.querySelector(".pay-invoice-btn");

function payWithCash() {
    challanContainer.classList.add("d-none");
    challanContainer.classList.remove("d-block");
    cashContainer.classList.add("d-block");
    cashContainer.classList.remove("d-none");
    // payInvoiceBtn.classList.add("d-block");
    // payInvoiceBtn.classList.remove("d-none");
}

function payWithChallan() {
    challanContainer.classList.remove("d-none");
    challanContainer.classList.add("d-block");
    cashContainer.classList.remove("d-block");
    cashContainer.classList.add("d-none");
    // payInvoiceBtn.classList.add("d-block");
    // payInvoiceBtn.classList.remove("d-none");
}

function payWithOnline() {
    challanContainer.classList.remove("d-block");
    challanContainer.classList.add("d-none");
    cashContainer.classList.remove("d-block");
    cashContainer.classList.add("d-none");
    // payInvoiceBtn.classList.remove("d-block");
    // payInvoiceBtn.classList.add("d-none");
}