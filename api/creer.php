<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Modele\Entities\Produit;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = Connexion::getConnexion();
    $produitDao = new ProduitDao($database);

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->nom) && !empty($data->description) && !empty($data->prix)) {
        $produit = new Produit(null, $data->nom, $data->description, $data->prix, date('Y-m-d H:i:s'));
        
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
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
}