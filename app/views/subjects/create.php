<?php

use App\Config\Database;
use App\Controllers\SubjectController;
use App\Controllers\TeacherController;

$database = new Database();

$db = $database->getConnection();

// Initialisation des contrôleurs
$subjectController = new SubjectController($db);
$teacherController = new TeacherController($db);

// Récupérer toutes les classes et enseignants pour le formulaire
$teachers = $teacherController->readAllTeachersWithUsersInformations();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'level' => $_POST['level'],
    ];
    
    // Ajouter `teacher_id` uniquement si ce n'est pas "aucun"
    if ($_POST['teacher_id'] !== "aucun") {
        $data['teacher_id'] = $_POST['teacher_id'];
    }
    

    try {
        $subjectController->createSubject($data);
        header('Location: /subjects');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

?>

<?php ?>
    <h3>Adding Subject page</h3>
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group dynamic-dropdown">
            <label for="teacher_id">Teacher:</label>
            <input type="text" id="teacher_id" name="teacher_id" placeholder="Ex: Batchato">
            <ul class="options">
            <?php foreach ($teachers as $teacher): ?>
                        <li value="<?php echo $teacher->id; ?>"><?php echo $teacher->first_name . ' ' . $teacher->last_name; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="level">Level:</label>
        <select id="level" name="level" required>
            <option value="Bachelor 1">Bachelor 1</option>
            <option value="Bachelor 2">Bachelor 2</option>
            <option value="Bachelor 3">Bachelor 3</option>
            <option value="Master 1">Master 1</option>
            <option value="Master 2">Master 2</option>
        </select>
            </div>
        </div>
        <center>
        <div class="form-group center">
            <button type="submit">Create Subject</button>
        </div>
        </center>
    </form>
    <?php ?>
