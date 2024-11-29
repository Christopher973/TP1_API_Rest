<?php

namespace Modele\Entities;

class Token {
    private $id;
    private $token;
    private $date_expiration;
    private $domaine;
    private $actif;

    // Constructeur
    public function __construct($id = null, $token = null, $date_expiration = null, $domaine = null, $actif = true) {
        $this->id = $id;
        $this->token = $token;
        $this->date_expiration = $date_expiration;
        $this->domaine = $domaine;
        $this->actif = $actif;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getToken() { return $this->token; }
    public function getDateExpiration() { return $this->date_expiration; }
    public function getDomaine() { return $this->domaine; }
    public function getActif() { return $this->actif; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setToken($token) { $this->token = $token; }
    public function setDateExpiration($date_expiration) { $this->date_expiration = $date_expiration; }
    public function setDomaine($domaine) { $this->domaine = $domaine; }
    public function setActif($actif) { $this->actif = $actif; }
}
