<?php

use App\Config\Database;
use App\Controllers\UserController;





$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$userController = new UserController($db);

// Déconnecter l'utilisateur
$userController->logout();
header('Location: /login');
exit;
?>
