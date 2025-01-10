<?php

use App\Config\Database;
use App\Controllers\BulletinController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$bulletinController = new BulletinController($db);

if (isset($_GET['id'])) {
    $bulletinId = $_GET['id'];
    try {
        $bulletinController->deleteBulletin($bulletinId);
        echo 'Bulletin deleted successfully.';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Bulletin ID not provided.';
}
?>
