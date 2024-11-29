<?php 

namespace Modele\Dao;

use Config\Connexion;
use Modele\Entities\Utilisateur;
use PDO;

class UtilisateurDao {
    private $connexion;

    public function __construct() {
        $this->connexion = Connexion::getConnexion();
    }

    public function createUser(Utilisateur $utilisateur) {
        $query = "INSERT INTO T_UTILISATEUR (nom, prenom, login, password) VALUES (:nom, :prenom, :login, :password)";
        $stmt = $this->connexion->prepare($query);

        // Hashage du mot de passe avant insertion
        $passwordHash = password_hash($utilisateur->getPassword(), PASSWORD_BCRYPT);

        return $stmt->execute([
            ':nom' => $utilisateur->getNom(),
            ':prenom' => $utilisateur->getPrenom(),
            ':login' => $utilisateur->getLogin(),
            ':password' => $passwordHash,
        ]);
    }

    public function findUserByLogin($login) {
        $query = "SELECT * FROM T_UTILISATEUR WHERE login = :login";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
