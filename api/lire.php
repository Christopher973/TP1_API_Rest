<?php
use OpenApi\Annotations as OA;
/**
* @OA\Info(title="Mon API", version="1.0.0")
*/
/**
* @OA\Post(
* path="/LabREST_03/api/produit/new",
* summary="Création d'un produit",
* @OA\Response(
* response=200,
* description="Création d'un produit à partir des données envoyées"
* ),
* @OA\Response(
* response=503,
* description="Le service n'est pas disponible"
* ),
* @OA\Response(
* response="default",
* description="Une erreur non prévue"
* )
* )
*/

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Modele\Entities\Produit;

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Vérifier que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // Obtenir la connexion
    $database = Connexion::getConnexion();

    // Instancier l'objet produit
    $produitDao = new ProduitDao($database);

    // Récupérer les produits
    $produits = $produitDao->findAll();

    // Vérifier s'il y a des produits
    if($produits){
        // Envoyer le code réponse 200 OK
        http_response_code(200);

        // Envoyer les produits au format json
        echo json_encode($produits);
    }
    else{
        // Envoyer le code réponse 404 Not found
        http_response_code(404);

        // Informer l'utilisateur qu'aucun produit n'a été trouvé
        echo json_encode(array("message" => "Aucun produit trouvé."));
    }
}
else{
    // Envoyer le code réponse 405 Method Not Allowed
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée."));
}