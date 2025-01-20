<?php

use App\Config\Database;
use App\Controllers\BulletinController;
use App\Controllers\ClassController;
use App\Controllers\StudentController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$bulletinController = new BulletinController($db);
$studentController = new StudentController($db);
$classController = new ClassController($db);

// Récupérer tous les étudiants et classes pour le formulaire
$students = $studentController->readAllStudents();
$classes = $classController->readAllClasses();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulletinId = $_POST['id'];
    $data = [
        'student_id' => $_POST['student_id'],
        'class_id' => $_POST['class_id'],
        'period' => $_POST['period'],
        'issue_date' => $_POST['issue_date'],
    ];

    try {
        $bulletinController->updateBulletin($bulletinId, $data);
        echo 'Bulletin updated successfully.';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    if (isset($_GET['id'])) {
        $bulletinId = $_GET['id'];
        $bulletin = $bulletinController->readBulletin($bulletinId);
    }
}
?>

<?php ?>
    <h3>Updating Bulletin</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($bulletin) ? $bulletin->id : ''; ?>">

        <div class="form-row">
            <div class="form-group">
            <label for="student_id">Student:</label>
        <select id="student_id" name="student_id" required>
            <?php foreach ($students as $student): ?>
                <option value="<?php echo $student->id; ?>" <?php echo isset($bulletin) && $bulletin->student_id == $student->id ? 'selected' : ''; ?>><?php echo $student->first_name . ' ' . $student->last_name; ?></option>
            <?php endforeach; ?>
        </select>
            </div>
            <div class="form-group">
            <label for="class_id">Class:</label>
        <select id="class_id" name="class_id" required>
            <?php foreach ($classes as $class): ?>
                <option value="<?php echo $class->id; ?>" <?php echo isset($bulletin) && $bulletin->class_id == $class->id ? 'selected' : ''; ?>><?php echo $class->name; ?></option>
            <?php endforeach; ?>
        </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="period">Period:</label>
            <input type="text" id="period" name="period" value="<?php echo isset($bulletin) ? $bulletin->period : ''; ?>" required>
            </div>
            <div class="form-group">
            <label for="issue_date">Issue Date:</label>
            <input type="date" id="issue_date" name="issue_date" value="<?php echo isset($bulletin) ? $bulletin->issue_date : ''; ?>" required>
            </div>
        </div>
        <center><div class="form-group center">
        <button type="submit">Update Bulletin</button>
        </div></center>
    </form>
    <?php ?>