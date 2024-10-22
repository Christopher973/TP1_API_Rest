<?php
namespace Modele\Dao;

// require_once __DIR__ . '/../vendor/autoload.php';

use Config\Connexion;
use Modele\Entities\Produit;
use PDO;
use PDOException;

class ProduitDao {
    private $connexion;

    public function __construct() {
        $this->connexion = Connexion::getConnexion();
    }

    public function create(Produit $produit) {
        $query = "INSERT INTO T_PRODUIT (nom, description, prix, date_creation) VALUES (:nom, :description, :prix, :date_creation)";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([
            ':nom' => $produit->getNom(),
            ':description' => $produit->getDescription(),
            ':prix' => $produit->getPrix(),
            ':date_creation' => $produit->getDateCreation()
        ]);
        return $this->connexion->lastInsertId();
    }

    public function findAll() {
        $query = "SELECT * FROM T_PRODUIT";
        $stmt = $this->connexion->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM T_PRODUIT WHERE id = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(Produit $produit) {
        $query = "UPDATE T_PRODUIT SET nom = :nom, description = :description, prix = :prix WHERE id = :id";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':id' => $produit->getId(),
            ':nom' => $produit->getNom(),
            ':description' => $produit->getDescription(),
            ':prix' => $produit->getPrix()
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM T_PRODUIT WHERE id = :id";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}