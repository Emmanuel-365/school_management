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
    $subjectId = $_POST['id'];
    $data = [
        'name' => $_POST['name'],
        'level' => $_POST['level'],
        'teacher_id' => null,
        'credit' => $_POST['credit'],
    ];
    
    // Ajouter `teacher_id` uniquement si ce n'est pas "aucun"
    if ($_POST['teacher_id'] !== "aucun") {
        $data['teacher_id'] = $_POST['teacher_id'];
    }
    

    try {
        $subjectController->updateSubject($subjectId, $data);
        header('Location: /subjects');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    if (isset($_GET['id'])) {
        $subjectId = $_GET['id'];
        $subject = $subjectController->readSubject($subjectId);
    }
}

?>
<?php  ?>
    <h3>Update Subject</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($subject) ? $subject->id : ''; ?>">
        <div class="form-row">
            <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($subject) ? $subject->name : ''; ?>" required>
            </div>
            <div class="form-group">
            <label for="teacher_id">Teacher:</label>
        <select id="teacher_id" name="teacher_id">
            <option value="aucun">Aucun</option>
            <?php foreach ($teachers as $teacher): ?>
                <option value="<?php echo $teacher->id; ?>" <?php echo isset($subject) && $subject->teacher_id == $teacher->id ? 'selected' : ''; ?>><?php echo $teacher->first_name . ' ' . $teacher->last_name; ?></option>
            <?php endforeach; ?>
        </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="level">Level:</label>
        <select id="level" name="level" required>
            <option value="Bachelor 1" <?php echo isset($subject) && $subject->level == 'Bachelor 1' ? 'selected' : ''; ?>>Bachelor 1</option>
            <option value="Bachelor 2" <?php echo isset($subject) && $subject->level == 'Bachelor 2' ? 'selected' : ''; ?>>Bachelor 2</option>
            <option value="Bachelor 3" <?php echo isset($subject) && $subject->level == 'Bachelor 3' ? 'selected' : ''; ?>>Bachelor 3</option>
            <option value="Master 1" <?php echo isset($subject) && $subject->level == 'Master 1' ? 'selected' : ''; ?>>Master 1</option>
            <option value="Master 2" <?php echo isset($subject) && $subject->level == 'Master 2' ? 'selected' : ''; ?>>Master 2</option>
        </select>
            </div>
            <div class="form-group">
                <label for="credit">Credit</label>
                <input type="number" name="credit" id="credit" value="<?php echo isset($subject) ? $subject->credit : ''; ?>" required>
            </div>
        </div>
        <center>
        <div class="form-group center">
        <button type="submit" >Update Subject</button>
        </div>
        </center>
    </form>
    <?php  ?>
