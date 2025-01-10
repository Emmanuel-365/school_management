<?php

use App\Config\Database;
use App\Controllers\GradeController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$gradeController = new GradeController($db);

if (isset($_GET['id'])) {
    $gradeId = $_GET['id'];
    try {
        $subject_id = $gradeController->readGrade($gradeId)->subject_id;
        $gradeController->deleteGrade($gradeId);
        header("Location: /students?subject_id=$subject_id");
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Grade ID not provided.';
}
?>
