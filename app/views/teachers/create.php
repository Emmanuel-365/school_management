<?php

use App\Config\Database;
use App\Controllers\TeacherController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$teacherController = new TeacherController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $teacherController->createTeacher($data);
        header('Location: /teachers');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<?php  ?>
    <h3 data-translate="atp">Adding Teacher page</h3>
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
            <label for="first_name" data-translate="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
            <label for="last_name" data-translate="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone" data-translate="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
                <div class="error-message"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="specialty" data-translate="specialty">Specialty:</label>
            <input type="text" id="specialty" name="specialty" required>
            </div>
            <div class="form-group">
            <label for="hire_date" data-translate="hire">Hire Date:</label>
            <input type="date" id="hire_date" name="hire_date" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
        <label for="status" data-translate="status">Status:</label>
            <select id="status" name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
            </div>
        </div>
        <center>
            <div class="form-group center">
               <button type="submit" data-translate="add_teacher">Add Teacher</button>
            </div>
        </center>
    </form>
    <?php  ?>
