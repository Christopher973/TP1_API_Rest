<?php

namespace Modele\Dao;

use Config\Connexion;
use Modele\Entities\Token;
use PDO;

class TokenDao {
    private $connexion;

    public function __construct() {
        $this->connexion = Connexion::getConnexion();
    }

    public function createToken(Token $token) {
        $query = "INSERT INTO T_TOKEN (token, date_expiration, domaine, actif) VALUES (:token, :date_expiration, :domaine, :actif)";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':token' => $token->getToken(),
            ':date_expiration' => $token->getDateExpiration(),
            ':domaine' => $token->getDomaine(),
            ':actif' => $token->getActif(),
        ]);
    }

    public function getTokenByValue($tokenValue) {
        $query = "SELECT * FROM T_TOKEN WHERE token = :token";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':token' => $tokenValue]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
