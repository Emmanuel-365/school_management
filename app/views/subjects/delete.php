<?php

use App\Config\Database;
use App\Controllers\SubjectController;


$database = new Database();

$db = $database->getConnection();

// Initialisation des contrôleurs
$subjectController = new SubjectController($db);

if (isset($_GET['id'])) {
    $subjectId = $_GET['id'];
    try {
        $subjectController->deleteSubject($subjectId);
        header('Location: /subjects');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Subject ID not provided.';
}
?>
