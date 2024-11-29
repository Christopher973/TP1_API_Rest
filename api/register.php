<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Modele\Dao\UtilisateurDao;
use Modele\Entities\Utilisateur;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->nom) && !empty($data->prenom) && !empty($data->login) && !empty($data->password)) {
        $utilisateurDao = new UtilisateurDao();

        $utilisateur = new Utilisateur(
            null,
            $data->nom,
            $data->prenom,
            $data->login,
            $data->password
        );

        if ($utilisateurDao->createUser($utilisateur)) {
            http_response_code(201);
            echo json_encode(["message" => "Utilisateur enregistré avec succès."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Impossible d'enregistrer l'utilisateur."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Données incomplètes."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée."]);
}
