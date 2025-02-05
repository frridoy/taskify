/*=================================== 
Customer dashboard cart calculation
===================================*/
const singleProductPrice = document.querySelectorAll(".dashboard-cart-single-item-price");
let cartSubtotal = document.querySelector(".dashboard-cart-subtotal-price");
let cartVat = document.querySelector(".dashboard-cart-vat");
let cartTotal = document.querySelector(".dashboard-cart-total-price");

let subTotal = 0;
for (let singlePrice of singleProductPrice) {
  subTotal += parseFloat(singlePrice.innerText)
}
cartSubtotal.innerText = subTotal;
let vat = subTotal * (15 / 100);
cartVat.innerText = vat;
cartTotal.innerText = subTotal + vat;
// =====================================================
