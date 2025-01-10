<?php

use App\Config\Database;
use App\Controllers\ClassController;

$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$classController = new ClassController($db);

if (isset($_GET['id'])) {
    $classId = $_GET['id'];
    echo $classId;
    try {
        $classController->deleteClass($classId);
        header('Location: /classes');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Class ID not provided.';
}
?>
