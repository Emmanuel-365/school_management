<?php

use App\Config\Database;
use App\Controllers\ClassController;
use App\Controllers\StudentController;

$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$classController = new ClassController($db);
$studentController = new StudentController($db);

$class = $classController->readClass($_GET['id']);

$classes = $classController->readAllClasses();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classId = $_POST['id'];
    $data = [
        'name' => $_POST['name'],
        'level' => $_POST['level'],
        'total_fee' => $_POST['total_fee'],
    ];
    $class = $classController->readClass($classId);
    $previous_total_fee = $class->total_fee;
    $studentsForClass = $studentController->readStudentsByLevel($data['level']);
    foreach ($studentsForClass as $student) {
        $new_remaining_fee = $_POST['total_fee'] + $student->remaining_fee - $class->total_fee;
        $studentController->updateStudent($student->id, ['remaining_fee' => $new_remaining_fee ] );
    }

    try {
        $classController->updateClass($classId, $data);
        foreach ($classes as $class) {
            if($class->level === $data['level']){
                $classController->updateClass($class->id, ['total_fee'=> $data['total_fee']]);
            }
        }
        header('Location: /classes');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<?php  ?>
<h3>Updating Classe page</h3>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

        <div class="form-row">
            <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="<?=$class->name?>">
            </div>
            <div class="form-group">
                    <label for="level">Level:</label>
                <select id="level" name="level" required>
                    <option value="Bachelor 1" <?= $class->level === "Bachelor 1" ? "selected" : "" ?>>Bachelor 1</option>
                    <option value="Bachelor 2" <?= $class->level === "Bachelor 2" ? "selected" : "" ?>>Bachelor 2</option>
                    <option value="Bachelor 3" <?= $class->level === "Bachelor 3" ? "selected" : "" ?>>Bachelor 3</option>
                    <option value="Master 1" <?= $class->level === "Master 1" ? "selected" : "" ?>>Master 1</option>
                    <option value="Master 2" <?= $class->level === "Master 2" ? "selected" : "" ?>>Master 2</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="total_fee">Total Fee:</label>
            <input type="number" id="total_fee" name="total_fee" required value=<?=$class->total_fee?>>
            </div>
        </div>
        <center>
        <div class="form-group center">
        <button type="submit">Update Class</button>
        </div>
        </center>
    </form>
    <?php  ?>