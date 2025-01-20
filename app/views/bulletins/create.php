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
$students = $studentController->readAllStudentsWithUsersInformations();
$classes = $classController->readAllClasses();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'student_id' => $_POST['student_id'],
        'class_id' => $_POST['class_id'],
        'period' => $_POST['period'],
        'issue_date' => $_POST['issue_date'],
    ];

    try {
        $bulletinController->createBulletin($data);
        echo 'Bulletin created successfully.';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<?php ?>
    <h3>Create Bulletin</h3>
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group dynamic-dropdown">
                <label for="student_id">Student:</label>
                <input type="text" id="student_id" name="student_id" placeholder="Ex: Matias">
                <ul class="options">
                <?php foreach ($students as $student): ?>
                    <li value="<?php echo $student->id; ?>"><?php echo $student->first_name . ' ' . $student->last_name; ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="form-group dynamic-dropdown">
            <label for="class_id">Class:</label>
             <input type="text" id="class_id" name="class_id"  placeholder="Ex: Bachelor 1">
                <ul class="options">
                <?php foreach ($classes as $class): ?>
                    <li value="<?php echo $class->id; ?>" data-class="<?php echo $student->class_name; ?>"><?php echo $class->name; ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="period">Period:</label>
            <input type="text" id="period" name="period" required>
            </div>
            <div class="form-group">
            <label for="issue_date">Issue Date:</label>
            <input type="date" id="issue_date" name="issue_date" required>
            </div>
        </div>
        <center><div class="form-group center">
        <button type="submit">Create Bulletin</button>

        </div></center>
    </form>
