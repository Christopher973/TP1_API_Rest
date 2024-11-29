<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Modele\Entities\Produit;
use Services\TokenService;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Étape 1 : Vérification de la méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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

// Étape 3 : Connexion à la base de données et préparation
$database = Connexion::getConnexion();
$produitDao = new ProduitDao($database);

// Étape 4 : Récupération des données envoyées
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nom) && !empty($data->description) && !empty($data->prix)) {
    // Création de l'objet Produit
    $produit = new Produit(null, $data->nom, $data->description, $data->prix, date('Y-m-d H:i:s'));
    
    // Étape 5 : Insertion dans la base de données
    if ($produitDao->create($produit)) {
        http_response_code(201);
        echo json_encode(["message" => "Produit a été créé"]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Impossible de traiter la requête"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Données incomplètes"]);
}
