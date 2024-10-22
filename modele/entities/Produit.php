<?php

namespace Modele\Entities;

class Produit {
    private $id;
    private $nom;
    private $description;
    private $prix;
    private $date_creation;

    public function __construct($id = null, $nom = null, $description = null, $prix = null, $date_creation = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->date_creation = $date_creation;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getDescription() { return $this->description; }
    public function getPrix() { return $this->prix; }
    public function getDateCreation() { return $this->date_creation; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setDescription($description) { $this->description = $description; }
    public function setPrix($prix) { $this->prix = $prix; }
    public function setDateCreation($date_creation) { $this->date_creation = $date_creation; }
}