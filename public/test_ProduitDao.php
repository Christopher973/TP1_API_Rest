<?php
require_once 'config/Connexion.php';
require_once 'modele/entities/Produit.php';
require_once 'modele/dao/ProduitDao.php';

// Création d'une instance de ProduitDao
$produitDao = new ProduitDao();

// Test de la méthode create
$nouveauProduit = new Produit(null, "Test Produit", "Description test", 19.99, date('Y-m-d H:i:s'));
$idInsere = $produitDao->create($nouveauProduit);
echo "Produit créé avec l'ID : " . $idInsere . "\n";

// Test de la méthode findAll
$produits = $produitDao->findAll();
echo "Nombre total de produits : " . count($produits) . "\n";

// Test de la méthode findById
$produitTrouve = $produitDao->findById($idInsere);
echo "Produit trouvé : " . $produitTrouve['nom'] . "\n";

// Test de la méthode update
$produitAModifier = new Produit($idInsere, "Produit Modifié", "Nouvelle description", 29.99, date('Y-m-d H:i:s'));
$resultatUpdate = $produitDao->update($produitAModifier);
echo "Mise à jour réussie : " . ($resultatUpdate ? "Oui" : "Non") . "\n";

// Test de la méthode delete
$resultatDelete = $produitDao->delete($idInsere);
echo "Suppression réussie : " . ($resultatDelete ? "Oui" : "Non") . "\n";

// Vérification finale
$produitSupprime = $produitDao->findById($idInsere);
echo "Le produit existe toujours : " . ($produitSupprime ? "Oui" : "Non") . "\n";