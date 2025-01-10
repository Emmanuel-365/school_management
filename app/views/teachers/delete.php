<?php

use App\Config\Database;
use App\Controllers\TeacherController;


$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$teacherController = new TeacherController($db);

if (isset($_GET['id'])) {
    $teacherId = $_GET['id'];
    try {
        $teacherController->deleteTeacher($teacherId);
        header('Location: /teachers');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Teacher ID not provided.';
}
?>
