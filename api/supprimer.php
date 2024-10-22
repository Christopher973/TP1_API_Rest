<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Modele\Entities\Produit;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $database = Connexion::getConnexion();
    $produitDao = new ProduitDao($database);

    // Récupérer l'ID du produit à supprimer
    $id = null;

    // Vérifier si l'ID est dans l'URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } 
    // Sinon, vérifier dans le corps de la requête
    else {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id)) {
            $id = $data->id;
        }
    }

    // Si aucun ID n'est fourni, retourner une erreur
    if ($id === null) {
        http_response_code(400);
        echo json_encode(["message" => "ID du produit manquant"]);
        exit();
    }

    // Vérifier si le produit existe avant de tenter la suppression
    if (!$produitDao->findById($id)) {
        http_response_code(204);
        echo json_encode(["message" => "Produit n'existe pas"]);
    } else {
        // Tenter de supprimer le produit
        if ($produitDao->delete($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Suppression effectuée"]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Impossible de traiter la requête"]);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
}