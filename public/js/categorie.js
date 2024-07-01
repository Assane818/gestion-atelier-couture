document.addEventListener('DOMContentLoaded', async (event) => {
    const categories = await getDataCategorie();
    listeCategorie(categories);
    const inputCategorie = document.getElementById('inputTypeCategorie');
    const btnAdd = document.getElementById('addTypeCategorie');

    btnAdd.addEventListener('click', async function() {
        const newCategorie = {nomCategorie: inputCategorie.value};
        alert(newCategorie.nomCategorie);
        const result = await setCategorie(newCategorie);
        alert(result.message);
        const newReponse = await fetch("http://localhost:8000/?action=api-save-categorie&controller=api-categorie");
        const newCategories = await newReponse.json();
        listeCategorie(newCategories);
    })

});

function listeCategorie(categories) {
    const divPrincipal = document.createElement("div");
    divPrincipal.classList.add('flex', 'items-center', 'justify-center', 'h-[calc(100vh-5rem)]');

    const divCard = document.createElement("div");
    divCard.classList.add('container', 'mx-auto', 'flex', 'flex-col', 'items-center', 'justify-center', 'gap-10');

    const divcontainer = document.createElement("div");
    divcontainer.classList.add('bg-white', 'p-10', 'rounded-lg', 'shadow-lg', 'max-w-2xl', 'w-full', 'overflow-hidden', 'mb-5', 'mt-5');

    const h1 = document.createElement("h1");
    h1.classList.add('text-2xl', 'font-bold', 'mb-6');
    h1.innerHTML = 'Gestion des Categories';

    const formAdd = document.createElement("form");
    formAdd.classList.add('mb-6');
    // formAdd.action = 'http://localhost:8000/save';
    formAdd.method = "post";

    const divAdd = document.createElement("div");
    divAdd.classList.add('flex', 'items-center');

    const inputCategorie = document.createElement("input");
    inputCategorie.name = "nomCategorie";
    inputCategorie.id = "inputTypeCategorie";
    inputCategorie.classList.add('block', 'w-full', 'border', 'border-gray-300', 'rounded-md', 'shadow-sm', 'py-2', 'px-3', 'focus:outline-none', 'focus:ring-[#a6c1ee]', 'focus:border-[#a6c1ee]', 'sm:text-sm');
    inputCategorie.placeholder = "Nom d la nouvelle categorie";

    const btnAdd = document.createElement("button");
    btnAdd.classList.add('ml-4', 'bg-[#eea6af]', 'text-white', 'px-5', 'py-2', 'rounded-full', 'hover:bg-[#c2c9fb]', 'transition', 'duration-300');
    btnAdd.id = "addTypeCategorie";
    btnAdd.type = "button";
    btnAdd.innerHTML = 'Ajouter';

    const divError = document.createElement("div");
    divError.classList.add('text-red-500', 'text-sm', 'mt-2');
    divError.id = "errorTypeCategorie";

    const divTable = document.createElement("div");
    divTable.classList.add('overflow-x-auto', 'max-h-[300px]', 'overflow-y-auto');

    const table = document.createElement("table");
    table.classList.add('min-w-full', 'bg-white');

    const thead = document.createElement("thead");
    thead.classList.add('bg-[#eea6af]', 'text-white');

    const trTitre = document.createElement("tr");

    const thName = document.createElement("th");
    thName.classList.add('px-4', 'py-2', 'border-b');
    thName.innerHTML = 'Nom du type';

    const thAction = document.createElement("th");
    thAction.classList.add('px-4', 'py-2', 'border-b');
    thAction.innerHTML = 'Actions';

    const tbody = document.createElement("tbody");

    categories.forEach(categorie => {
        const tr = document.createElement("tr");
        tr.classList.add('border-b', 'hover:bg-gray-100');

        const tdname = document.createElement("td");
        tdname.classList.add('py-3', 'px-6', 'text-center');
        tdname.innerHTML = categorie.nomCategorie;

        const tdAction = document.createElement("td");
        tdAction.classList.add('px-4', 'py-2', 'text-center', 'flex', 'justify-center', 'gap-4');

        const formUpdate = document.createElement("form");
        formUpdate.action = 'http://localhost:8000/update';
        formUpdate.method = "post";

        const divUpdate = document.createElement("div");
        divUpdate.classList.add('p-2', 'bg-blue-100', 'rounded-full');

        const btnUpdate = document.createElement("button");
        btnUpdate.type = "submit";
        btnUpdate.innerHTML = '<i class="fa-regular fa-pen-to-square text-blue-500 cursor-pointer hover:text-blue-600 transition duration-300"></i>';

        const formDelete = document.createElement("form");
        formDelete.action = 'http://localhost:8000/delete';
        formDelete.method = "post";

        const divDelete = document.createElement("div");
        divDelete.classList.add('p-2', 'bg-red-100', 'rounded-full');

        const btnDelete = document.createElement("button");
        btnDelete.type = "submit";
        btnDelete.innerHTML = '<i class="fa-solid fa-trash text-red-500 cursor-pointer hover:text-red-600 transition duration-300"></i>';

        divUpdate.appendChild(btnUpdate);
        formUpdate.appendChild(divUpdate);

        divDelete.appendChild(btnDelete);
        formDelete.appendChild(divDelete);
        tdAction.appendChild(formUpdate);
        tdAction.appendChild(formDelete);

        tr.appendChild(tdname);
        tr.appendChild(tdAction); 
        tbody.appendChild(tr);
    });
    
    trTitre.appendChild(thName);
    trTitre.appendChild(thAction);
    thead.appendChild(trTitre);

    table.appendChild(thead);
    table.appendChild(tbody);
    divTable.appendChild(table);

    divAdd.appendChild(inputCategorie);
    divAdd.appendChild(btnAdd);
    divAdd.appendChild(divError);

    formAdd.appendChild(divAdd);

    divcontainer.appendChild(h1);
    divcontainer.appendChild(formAdd);
    divcontainer.appendChild(divTable);

    divCard.appendChild(divcontainer);
    divPrincipal.appendChild(divCard);

    document.body.appendChild(divPrincipal);
}

async function  getDataCategorie () {
    const reponse = await fetch("http://localhost:8000/?action=api-liste-categorie&controller=api-categorie");
    const categories = await reponse.json();
    return categories;
}

async function setCategorie (categorie) {
    const reponse = await fetch("http://localhost:8000/?action=api-save-categorie&controller=api-categorie", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(categorie)
    });
    const result = await reponse.json();
    return result;
}
