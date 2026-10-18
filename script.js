// script.js

document.addEventListener('DOMContentLoaded', () => {
 // Format Card Number with spaces
 const cardInput = document.getElementById('card_number');
 cardInput.addEventListener('input', function (e) {
 let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
 let formattedValue = '';
 for (let i = 0; i < value.length; i++) {
 if (i > 0 && i % 4 === 0) {
 formattedValue += ' ';
 }
 formattedValue += value[i];
 }
 e.target.value = formattedValue;
 });

 // Format Expiry Date (add slash)
 const expiryInput = document.getElementById('expiry');
 expiryInput.addEventListener('input', function (e) {
 let value = e.target.value.replace(/\D/g, '');
 if (value.length >= 2) {
 value = value.substring(0, 2) + '/' + value.substring(2, 4);
 }
 e.target.value = value;
 });

 // Handle Form Submit
 const form = document.getElementById('paymentForm');
 form.addEventListener('submit', function() {
 const btn = document.getElementById('payBtn');
 btn.textContent = "Processing...";
 btn.disabled = true;
 });
});
