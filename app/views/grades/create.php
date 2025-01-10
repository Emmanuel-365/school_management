<?php

use App\Config\Database;
use App\Controllers\GradeController;
use App\Controllers\StudentController;
use App\Controllers\SubjectController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$gradeController = new GradeController($db);
$studentController = new StudentController($db);
$subjectController = new SubjectController($db);

// Récupérer tous les étudiants et matières pour le formulaire
$students = $studentController->readAllStudents();
$subjects = $subjectController->readAllSubjects();

$type_note = $_GET['type_note'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'student_id' => $_POST['student_id'],
        'subject_id' => $_POST['subject_id'],
        'grade' => $_POST['grade'],
        'type_note' => $_GET['type_note'],
    ];

    $subject_id = $_POST['subject_id'];
    try {
        $gradeController->createGrade($data);
        header("Location: /students?subject_id=$subject_id");
        exit() ;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<?php  ?>
    <h3>Adding Grade page</h3>
    <form method="POST" action="">
        <input type="text" id="subject_id" name="subject_id" value="<?=$_GET['subject_id'] ?>" hidden>

        <input type="text" id="student_id" name="student_id" value="<?=$_GET['student_id'] ?>" hidden>

        <div class="form-row">
    <div class="form-group">
    <label for="grade">Grade:</label>
    <input type="number" id="grade" name="grade" step="0.01" required>
    </div>
</div>
        <center>
            <div class="form-group center">
            <button type="submit">Add Grade</button>
            </div>
        </center>
    </form>
    <?php  ?>