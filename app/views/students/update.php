<?php


use App\Config\Database;
use App\Controllers\StudentController;
use App\Controllers\ClassController;
use App\Controllers\UserController;

$database = new Database();

$db = $database->getConnection();

// Initialisation des contrôleurs
$studentController = new StudentController($db);
$classController = new ClassController($db);
$userController = new UserController($db);

// Récupérer toutes les classes pour le formulaire
$classes = $classController->readAllClasses();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['id'];
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'date_of_birth' => $_POST['date_of_birth'],
        'address' => $_POST['address'],
        'class_id' => $_POST['class_id'],
        'parent_id' => $_POST['parent_id'],
        // 'remaining_fee' => $_POST['remaining_fee'],
    ];

    try {
        $studentController->updateStudent($studentId, $data);

        header("Location: /students");
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    if (isset($_GET['id'])) {
        $studentId = $_GET['id'];
        $student = $studentController->readStudentWithUsersInformations($studentId);
    }
}
?>

<?php  ?>
    <h3>Update Student page</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($student) ? $student->id : ''; ?>">
        <div class="form-row">
            <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo isset($student) ? $student->first_name : ''; ?>" required>
            </div>
            <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo isset($student) ? $student->last_name : ''; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($student) ? $student->email : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo isset($student) ? $student->phone : ''; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo isset($student) ? $student->date_of_birth : ''; ?>" required>
            </div>
            <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo isset($student) ? $student->address : ''; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="class_id">Class:</label>
        <select id="class_id" name="class_id" required>
            <?php foreach ($classes as $class): ?>
                <option value="<?php echo $class->id; ?>" <?php echo isset($student) && $student->class_id == $class->id ? 'selected' : ''; ?>><?php echo $class->name; ?></option>
            <?php endforeach; ?>
        </select>
            </div>
            <div class="form-group">
            <label for="parent_id">Parent ID:</label>
            <input type="number" id="parent_id" name="parent_id" value="<?php echo isset($student) ? $student->parent_id : ''; ?>" required>
            </div>
        </div>
        <!-- <div class="from-row">
            <div class="form-group">
                <label for="remaining_fee">Remaining Fee:</label>
                <input type="number" id="remaining_fee" name="remaining_fee" value="<?php echo isset($student) ? $student->remaining_fee : ''; ?>" required>
            </div>
        </div> -->
        <center><div class="form-group center">
                    <button type="submit">Update student</button>
                </div></center>
    </form>
    <?php  ?>
