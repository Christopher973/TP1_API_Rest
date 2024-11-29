<?php

use Config\Connexion;

require_once '../config/Connexion.php';

try {
    $connexion = Connexion::getConnexion();
    echo "Connexion à la base de données réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}