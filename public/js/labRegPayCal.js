let labPayVat = document.querySelector("#lab-pay-vat");
let toBePaid = document.querySelector("#to-be-paid");
function testFeeInput(e){
    let testFee = parseFloat(e.value);
    if(!isNaN(parseFloat(testFee))){
        const vat = parseFloat(e.value) * (15/100);
        labPayVat.value = vat.toFixed(2);
        toBePaid.value = (parseFloat(e.value) + vat).toFixed(2);
    }else{
        alert("Test Fee must be a numeric value")
        e.value = ""
    }
}