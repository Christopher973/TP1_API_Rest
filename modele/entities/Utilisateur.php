<?php

namespace Modele\Entities;

class Utilisateur {
    private $id;
    private $nom;
    private $prenom;
    private $login;
    private $password;

    // Constructeur
    public function __construct($id = null, $nom = null, $prenom = null, $login = null, $password = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->password = $password;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getLogin() { return $this->login; }
    public function getPassword() { return $this->password; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setLogin($login) { $this->login = $login; }
    public function setPassword($password) { $this->password = $password; }
}
