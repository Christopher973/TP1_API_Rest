<?php
// Définir l’URL
$url = "http://localhost/Marie-Angelique_apiRestPHP_TP3/api/v1.0/produit/listone/16";
// Initialiser une session CURL
$ch = curl_init();
// Définir les options de transmission CURL : url, méthode, données, …
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Exécuter la session CURL et récupérer la réponse
$response = curl_exec($ch);
// Afficher la réponse du service WEB REST
var_dump($response);
// Fermer la session CURL
curl_close($ch);
