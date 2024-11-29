<?php 

namespace Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService {
    private static $secretKey = "votre_cle_secrete"; // Clé secrète pour signer le token
    private static $algorithm = "HS256"; // Algorithme utilisé pour encoder le token

    // Générer un token
    public static function generateToken($payload) {
        $payload['iat'] = time(); // Date de création
        $payload['exp'] = time() + (60 * 60); // Expiration dans 1 heure
        return JWT::encode($payload, self::$secretKey, self::$algorithm);
    }

    // Valider et décoder un token
    public static function validateToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
        } catch (\Exception $e) {
            throw new \Exception("Token invalide : " . $e->getMessage());
        }
    }
}
