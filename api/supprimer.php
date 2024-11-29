<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Services\TokenService;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Étape 1 : Vérification de la méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

// Étape 4 : Récupérer l'ID du produit à supprimer
$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id)) {
        $id = $data->id;
    }
}

if ($id === null) {
    http_response_code(400);
    echo json_encode(["message" => "ID du produit manquant"]);
    exit();
}

// Étape 5 : Vérifier si le produit existe
if (!$produitDao->findById($id)) {
    http_response_code(204);
    echo json_encode(["message" => "Produit n'existe pas"]);
} else {
    // Étape 6 : Tenter de supprimer le produit
    if ($produitDao->delete($id)) {
        http_response_code(200);
        echo json_encode(["message" => "Suppression effectuée"]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Impossible de traiter la requête"]);
    }
}
