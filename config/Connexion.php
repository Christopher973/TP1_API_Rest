<?php
namespace Config;

// require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use PDOException;

class Connexion {
    private static $connexion = null;

    private function __construct() {}

    public static function getConnexion() {
        if (self::$connexion === null) {
            try {
                self::$connexion = new PDO(
                    'mysql:host=localhost;dbname=tp1_api_rest;charset=utf8',
                    'root',  
                    ''       
                );
                self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$connexion;
    }
}