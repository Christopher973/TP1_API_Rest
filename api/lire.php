<?php
use OpenApi\Annotations as OA;

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Services\TokenService;

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Étape 1 : Vérification de la méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
    exit();
}

// Étape 2 : Vérification de l'authentification via le token
$headers = getallheaders();
if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(["message" => "Token manquant"]);
    exit();
}

// Extraction du token
$token = str_replace("Bearer ", "", $headers['Authorization']);

try {
    // Validation du token
    $decoded = TokenService::validateToken($token);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(["message" => "Token invalide : " . $e->getMessage()]);
    exit();
}

// Étape 3 : Connexion à la base de données et récupération des produits
$database = Connexion::getConnexion();
$produitDao = new ProduitDao($database);

$produits = $produitDao->findAll();

if ($produits) {
    http_response_code(200);
    echo json_encode($produits);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Aucun produit trouvé."]);
}
