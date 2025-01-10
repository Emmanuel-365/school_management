<?php


use App\Config\Database;
use App\Controllers\TeacherController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$teacherController = new TeacherController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacherId = $_POST['id'];
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'specialty' => $_POST['specialty'],
        'hire_date' => $_POST['hire_date'],
        'status' => $_POST['status'],
    ];

    try {
        $teacherController->updateTeacher($teacherId, $data);
        header('Location: /teachers');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    if (isset($_GET['id'])) {
        $teacherId = $_GET['id'];
        $teacher = $teacherController->readTeacherWithUsersInformations($teacherId);
    }
}
?>

<?php  ?>
    <h3>Updating Teacher page</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($teacher) ? $teacher->id : ''; ?>">

        <div class="form-row">
            <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo isset($teacher) ? $teacher->first_name : ''; ?>" required>
            </div>
            <div class="form-group">
             <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo isset($teacher) ? $teacher->last_name : ''; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($teacher) ? $teacher->email : ''; ?>" required>
            </div>
            <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo isset($teacher) ? $teacher->phone : ''; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="specialty">Specialty:</label>
            <input type="text" id="specialty" name="specialty" value="<?php echo isset($teacher) ? $teacher->specialty : ''; ?>" required>
            </div>
            <div class="form-group">
            <label for="hire_date">Hire Date:</label>
            <input type="date" id="hire_date" name="hire_date" value="<?php echo isset($teacher) ? $teacher->hire_date : ''; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="active" <?php echo isset($teacher) && $teacher->status == 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo isset($teacher) && $teacher->status == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select>
            </div>
        </div>
        <center>
        <div class="form-group">
        <button type="submit">Update Teacher</button>
        </div>
        </center>
    </form>
    <?php  ?>
