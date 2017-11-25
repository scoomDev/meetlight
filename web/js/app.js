// ------------------------------
// "Mon compte" page
// ------------------------------
// Change address button
const formAddress = document.getElementById('change-address');
const inputAddress = document.getElementById('user_input_autocomplete_address');
const btnAddress = document.getElementById('change-address-btn');

if (formAddress.style.display !== "none") {
    formAddress.style.display = "none";
}

btnAddress.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    if (formAddress.style.display !== "block") {
        formAddress.style.display = "block";
        inputAddress.focus();
    }
});