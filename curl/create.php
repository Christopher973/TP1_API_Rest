<?php
// Définir l'URL
$url = "http://localhost/TP1_API_Rest/api/v1.0/produit/new/";  // Notez le changement d'URL

// Donnée à transmettre au format JSON : nouveau produit
$data = json_encode(array(
    'nom' => 'test du nouveau produit', 
    'description' => 'Description nouveau produit', 
    'prix' => 100.99
));

// Initialiser une session CURL
$ch = curl_init();

// Définir les options de transmission CURL : url, méthode, données, …
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  // Changé de "CREATE" à "POST"
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data)
));

// Exécuter la session CURL et récupérer la réponse
$response = curl_exec($ch);

// Afficher la réponse du service WEB REST
var_dump($response);

// Fermer la session CURL
curl_close($ch);