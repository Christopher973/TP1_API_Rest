<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Dao\ProduitDao;
use Modele\Entities\Produit;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = Connexion::getConnexion();
    $produitDao = new ProduitDao($database);

    $id = isset($_GET['id']) ? $_GET['id'] : die();
    $produit = $produitDao->findById($id);

    if ($produit) {
        http_response_code(200);
        echo json_encode($produit);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Produit n'existe pas"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
}