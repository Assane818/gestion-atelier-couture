const inputTypeCategorie = document.getElementById('inputTypeCategorie');
const errorTypeCategorie = document.getElementById('errorTypeCategorie');
const btnAddTypeCategorie = document.querySelector('#addTypeCategorie');
function checkInputTypeCategorie(event) {
    let isValid = true;
    if (inputTypeCategorie.value.trim() === '') {
        inputTypeCategorie.classList.add('border-red-500');
        inputTypeCategorie.classList.remove('border-green-500');
        errorTypeCategorie.textContent = 'Ce champ est requis';
        isValid = false;
    } else {
        inputTypeCategorie.classList.remove('border-red-500');
        inputTypeCategorie.classList.add('border-green-500');
        errorTypeCategorie.textContent = '';
    }
    if (!isValid) {
        event.preventDefault();
    }
}
inputTypeCategorie.addEventListener('input', function() {
    if (this.value.trim() !== '') {
        this.classList.remove('border-red-500', 'border-green-500')
        errorTypeCategorie.textContent = '';
    }
});
btnAddTypeCategorie.addEventListener('click',checkInputTypeCategorie);