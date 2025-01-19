<?php

// Inclure l'autoload si nécessaire
require_once '../vendor/autoload.php';

// Charger la configuration des routes
$routes = require_once '../app/Routes/web.php';


// Récupérer l'URL demandée
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Retirer le préfixe '/public' de l'URL si nécessaire (selon votre structure de dossier)
$requestUri = str_replace('/public', '', $requestUri);

// Vérifier si la route existe et inclure le fichier PHP correspondant
if (array_key_exists($requestUri, $routes)) {
    if(!str_contains($requestUri,needle: 'login') && !str_contains($requestUri,'savepdf') && !str_contains($requestUri,'send') && !str_contains($requestUri, "change-password") && !str_contains($requestUri, "chatbot") && !str_contains($requestUri, "sign") && !str_contains($requestUri, "send")) {
        include '../app/views/haut.php';
    }
    include '../app/Views/' . $routes[$requestUri];
    if(!str_contains($requestUri,'savepdf') && !str_contains($requestUri,'send') && !str_contains($requestUri, "chatbot") && !str_contains($requestUri, "sign") && !str_contains($requestUri, "send")) {
        include '../app/views/bas.php';
    }
} else {
    // Si la route n'existe pas, inclure une page 404
    include '../app/Views/404.php';
}
