<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Modele\Entities\Produit;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $database = Connexion::getConnexion();
    $produitDao = new ProduitDao($database);

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->id) && !empty($data->nom) && !empty($data->description) && !empty($data->prix)) {
        $produit = new Produit($data->id, $data->nom, $data->description, $data->prix, $data->date_creation);
        
        if ($produitDao->update($produit)) {
            http_response_code(200);
            echo json_encode(["message" => "Modification effectuée"]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Impossible de traiter la requête"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Données incomplètes"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
}