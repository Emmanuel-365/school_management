<?php


use App\Config\Database;
use App\Controllers\StudentController;

$database = new Database();

$db = $database->getConnection();

// Initialisation des contrôleurs
$studentController = new StudentController($db);

if (isset($_GET['id'])) {
    $studentId = $_GET['id'];
    try {
        $studentController->deleteStudent($studentId);
        header("Location: /students");
        exit();        
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Student ID not provided.';
}
?>
