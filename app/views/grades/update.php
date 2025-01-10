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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gradeId = $_POST['id'];
    $data = [
        'grade' => $_POST['grade'],
    ];

    try {
        $gradeController->updateGrade($gradeId, $data);
        $subject_id = $gradeController->readGrade($gradeId)->subject_id;
        header("Location: /students?subject_id=$subject_id");
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    if (isset($_GET['id'])) {
        $gradeId = $_GET['id'];
        $grade = $gradeController->readGrade($gradeId);
    }
}
?>

<?php  ?>
    <h3>Updating Grade page</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($grade) ? $grade->id : ''; ?>">
<div class="form-row">
    <div class="form-group">
    <label for="grade">Grade:</label>
    <input type="number" id="grade" name="grade" step="0.01" value="<?php echo isset($grade) ? $grade->grade : ''; ?>" required>
    </div>
</div>
<center>
    <div class="form-group center">
    <button type="submit">Update Grade</button>
    </div>
</center>
    </form>
    <?php  ?>
