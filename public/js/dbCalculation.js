/*========================================== 
dashboard ordered product calculation 
==========================================*/
const productQty = document.querySelectorAll(".ordered-product-qty");
const productUnitPrice = document.querySelectorAll(".ordered-product-unit-price");
const productSubtotalPrice = document.querySelectorAll(".ordered-product-subtotal-price");
let productTotalPrices = document.querySelector(".ordered-product-total-price");
let productVat = document.querySelector(".product-vat");
// let productShipping = document.querySelector(".product-shipping-cost");
let productGrandtotal = document.querySelector(".ordered-product-grandtotal-price");

// find subtotal price
let qtyArr = [];
for(let pq of productQty){
  qtyArr.push(parseInt(pq.innerText));   
}
let unitPriceArr = [];
for(let pup of productUnitPrice){
  unitPriceArr.push(parseFloat(pup.innerText));
}
const subtotalPrice = qtyArr.map((elm, i) => unitPriceArr[i] * elm);
subtotalPrice.forEach((elm, i) => productSubtotalPrice[i].innerText = elm);

let totalPrices = subtotalPrice.reduce((r, c, i) => r + c, 0);
productTotalPrices.innerText = totalPrices;

// vat
const vat = totalPrices * (15/100);
productVat.innerText = vat;

// find grandtotal price
productGrandtotal.innerText = totalPrices + vat;
// ==============================================