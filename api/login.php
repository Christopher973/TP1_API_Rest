<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Modele\Dao\UtilisateurDao;
use Modele\Dao\TokenDao;
use Modele\Entities\Token;
use Services\TokenService;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->login) && !empty($data->password)) {
        $utilisateurDao = new UtilisateurDao();
        $tokenDao = new TokenDao();

        $utilisateur = $utilisateurDao->findUserByLogin($data->login);

        if ($utilisateur && password_verify($data->password, $utilisateur['password'])) {
            $payload = ["id" => $utilisateur['id'], "login" => $utilisateur['login']];
            $tokenValue = TokenService::generateToken($payload);

            $token = new Token(null, $tokenValue, date('Y-m-d H:i:s', time() + (60 * 60)), $_SERVER['HTTP_HOST'], true);

            $tokenDao->createToken($token);

            http_response_code(200);
            echo json_encode(["token" => $tokenValue]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Login ou mot de passe incorrect."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Données incomplètes."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée."]);
}
