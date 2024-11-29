<?php
// URL de l'API (remplacez 123 par un ID valide de produit)
$url = "http://localhost/Marie-Angelique_apiRestPHP_TP3/api/v1.0/produit/update/";

// Donnée à transmettre au format JSON : nouveau produit
$data = json_encode(array(
    'id' => '16', 
    'nom' => 'test du nouveau produit curl', 
    'description' => 'Description nouveau produit curl', 
    'date_creation' => '22/11/2023', 
    'prix' => 100.99
));

// Initialiser cURL
$ch = curl_init();

// Configurer les options cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

// Exécuter la requête et récupérer la réponse
$response = curl_exec($ch);

// Vérifier les erreurs
if(curl_errno($ch)){
    echo 'Erreur cURL : ' . curl_error($ch);
}

// Fermer la session cURL
curl_close($ch);

// Afficher la réponse
var_dump($response);


curl_close($ch);
