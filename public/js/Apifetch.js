// URL de base de l'API
const API_BASE_URL = 'http://localhost/Marie-Angelique_apiRestPHP_TP3/api/v1.0';

// Fonction pour récupérer tous les produits
async function getAllProducts() {
    try {
        const response = await fetch(`${API_BASE_URL}/produit/list/`);
        if (!response.ok) {
            throw new Error('Erreur lors de la récupération des produits');
        }
        const products = await response.json();
        displayProducts(products);
    } catch (error) {
        console.error('Erreur:', error);
        displayProducts([]); // Afficher une liste vide en cas d'erreur
    }
}

// Fonction pour ajouter un produit
async function addProduct(product) {
    try {
        const response = await fetch(`${API_BASE_URL}/produit/new`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(product),
        });
        if (!response.ok) {
            throw new Error('Erreur lors de l\'ajout du produit');
        }
        getAllProducts(); // Rafraîchir la liste après l'ajout
        alert('Produit ajouté avec succès');
    } catch (error) {
        console.error('Erreur:', error);
        alert('Impossible d\'ajouter le produit');
    }
}

// Fonction pour supprimer un produit
async function deleteProduct(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        try {
            const response = await fetch(`${API_BASE_URL}/produit/delete/${id}`, {
                method: 'DELETE',
            });
            if (!response.ok) {
                throw new Error('Erreur lors de la suppression du produit');
            }
            getAllProducts(); // Rafraîchir la liste après la suppression
            alert('Produit supprimé avec succès');
        } catch (error) {
            console.error('Erreur:', error);
            alert('Impossible de supprimer le produit');
        }
    }
}

// Fonction pour modifier un produit
async function updateProduct(id) {
    try {
        // Récupérer les détails du produit
        const response = await fetch(`${API_BASE_URL}/produit/listone/${id}`);
        if (!response.ok) {
            throw new Error('Erreur lors de la récupération du produit');
        }
        const product = await response.json();
        
        // Afficher le formulaire de modification
        showUpdateForm(product);
    } catch (error) {
        console.error('Erreur:', error);
        alert('Impossible de récupérer les détails du produit');
    }
}

// Fonction pour afficher le formulaire de modification
function showUpdateForm(product) {
    const updateForm = `
        <div id="updateFormModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Modifier le produit</h3>
                <form id="updateProductForm">
                    <input type="hidden" id="updateId" value="${product.id}">
                    <input type="text" id="updateNom" value="${product.nom}" class="w-full p-2 mb-2 border rounded" required>
                    <textarea id="updateDescription" class="w-full p-2 mb-2 border rounded" required>${product.description}</textarea>
                    <input type="number" id="updatePrix" value="${product.prix}" step="0.01" class="w-full p-2 mb-2 border rounded" required>
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Modifier</button>
                    <button type="button" onclick="closeUpdateForm()" class="w-full mt-2 bg-gray-300 text-gray-800 p-2 rounded hover:bg-gray-400">Annuler</button>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', updateForm);

    document.getElementById('updateProductForm').addEventListener('submit', handleUpdateSubmit);
}

// Fonction pour gérer la soumission du formulaire de modification
async function handleUpdateSubmit(e) {
    e.preventDefault();
    const updatedProduct = {
        id: document.getElementById('updateId').value,
        nom: document.getElementById('updateNom').value,
        description: document.getElementById('updateDescription').value,
        prix: document.getElementById('updatePrix').value,
    };
    try {
        const response = await fetch(`${API_BASE_URL}/produit/update`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(updatedProduct),
        });
        if (!response.ok) {
            throw new Error('Erreur lors de la modification du produit');
        }
        getAllProducts(); // Rafraîchir la liste après la modification
        closeUpdateForm();
        alert('Produit modifié avec succès');
    } catch (error) {
        console.error('Erreur:', error);
        alert('Impossible de modifier le produit');
    }
}

// Fonction pour fermer le formulaire de modification
function closeUpdateForm() {
    const modal = document.getElementById('updateFormModal');
    if (modal) {
        modal.remove();
    }
}

// Fonction pour afficher les produits
function displayProducts(products) {
    const productList = document.getElementById('productList');
    productList.innerHTML = '';

    if (!products || products.length === 0) {
        const emptyMessage = document.createElement('li');
        emptyMessage.className = 'text-center text-gray-500';
        emptyMessage.textContent = 'Aucun produit disponible';
        productList.appendChild(emptyMessage);
        return;
    }

    products.forEach(product => {
        const li = document.createElement('li');
        li.className = 'bg-gray-50 p-4 rounded shadow flex justify-between items-center mb-4';
        li.innerHTML = `
            <div>
                <h3 class="font-semibold cursor-pointer text-blue-600 hover:text-blue-800" onclick="showProductDetails(${product.id})">${product.nom}</h3>
                <p class="text-sm text-gray-600">${product.description}</p>
                <p class="text-sm font-bold text-blue-600">${product.prix} €</p>
            </div>
            <div>
                <button onclick="updateProduct(${product.id})" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-300 mr-2">Modifier</button>
                <button onclick="deleteProduct(${product.id})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-300">Supprimer</button>
            </div>
        `;
        productList.appendChild(li);
    });
}

function displayProductDetails(product) {
    const detailsHTML = `
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="productModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">${product.nom}</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">${product.description}</p>
                        <p class="text-sm font-bold text-blue-600 mt-2">${product.prix} €</p>
                        <p class="text-xs text-gray-400 mt-2">Créé le : ${product.date_creation}</p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="closeModal" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', detailsHTML);
    document.getElementById('closeModal').onclick = () => {
        document.getElementById('productModal').remove();
    };
}



async function showProductDetails(id) {
    try {
        const response = await fetch(`${API_BASE_URL}/produit/listone/${id}`);
        if (!response.ok) {
            throw new Error('Erreur lors de la récupération du produit');
        }
        const product = await response.json();
        displayProductDetails(product);
    } catch (error) {
        console.error('Erreur:', error);
        alert('Impossible de récupérer les détails du produit');
    }
}

// Écouteur d'événement pour le formulaire d'ajout de produit
document.getElementById('addProductForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const product = {
        nom: document.getElementById('nom').value,
        description: document.getElementById('description').value,
        prix: document.getElementById('prix').value,
    };
    addProduct(product);
    this.reset(); // Réinitialiser le formulaire
});

// Charger les produits au chargement de la page
document.addEventListener('DOMContentLoaded', getAllProducts);