    const btnAddArticle = document.getElementById('addArticle');
    const inputLibelle = document.getElementById('inputLibelle');
    const inputQuantite = document.getElementById('inputQuantite');
    const inputPrix = document.getElementById('inputPrix');
    const errorLibelle = document.getElementById('errorLibelle');
    const errorPrix = document.getElementById('errorPrix');
    const errorQuantite = document.getElementById('errorQuantite');


    function checkForm(event) {
        let isValid = true;
        if (inputLibelle.value.trim() === '') {
            inputLibelle.classList.add('border-red-500');
            inputLibelle.classList.remove('border-green-500');
            errorLibelle.textContent = 'Ce champ est requis';
            isValid = false;
        } else {
            inputLibelle.classList.remove('border-red-500');
            inputLibelle.classList.add('border-green-500');
            errorLibelle.textContent = '';
        }

        if (inputQuantite.value.trim() === '') {
            inputQuantite.classList.add('border-red-500');
            inputQuantite.classList.remove('border-green-500');
            errorQuantite.textContent = 'Ce champ est requis';
            isValid = false;
        } else {
            inputQuantite.classList.remove('border-red-500');
            inputQuantite.classList.add('border-green-500');
            errorQuantite.textContent = '';
        }

        if (inputPrix.value.trim() === '') {
            inputPrix.classList.add('border-red-500');
            inputPrix.classList.remove('border-green-500');
            errorPrix.textContent = 'Ce champ est requis';
            isValid = false;
        } else {
            inputPrix.classList.remove('border-red-500');
            inputPrix.classList.add('border-green-500');
            errorPrix.textContent = '';
        }
        if (!isValid) {
            event.preventDefault();
        }
    }
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

    inputLibelle.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            this.classList.remove('border-red-500', 'border-green-500')
            errorLibelle.textContent = '';
        }
    });
    inputQuantite.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            this.classList.remove('border-red-500', 'border-green-500')
            errorQuantite.textContent = '';
        }
    });
    inputPrix.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            this.classList.remove('border-red-500', 'border-green-500')
            errorPrix.textContent = '';
        }
    });

    btnAddArticle.addEventListener('click',checkForm);
