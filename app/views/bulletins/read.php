<?php

use App\Config\Database;
use App\Controllers\BulletinController;
use App\Controllers\GradeController;
use App\Controllers\StudentController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$bulletinController = new BulletinController($db);
$gradeController = new GradeController($db);
$studentController = new StudentController($db);

// Lire tous les bulletins
$bulletins = $bulletinController->readAllBulletins();
?>

<?php ?>
<div class="search-container">
                <input type="text" id="search" placeholder="Search for a bulletins..." />
                <a href="/bulletins/create" class="add-button">Add Bulletin</a>
            </div>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Class</th>
            <th>Period</th>
            <th>Issue Date</th>
            <th>Comments</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($bulletins as $bulletin): ?>
            <tr>
                <td><?php echo $bulletin->id; ?></td>
                <td><?php echo $bulletin->student_id; ?></td>
                <td><?php echo $bulletin->class_id; ?></td>
                <td><?php echo $bulletin->period; ?></td>
                <td><?php echo $bulletin->issue_date; ?></td>
                <td><?php echo $bulletin->comments; ?></td>
                <td>
                <a href="/bulletins/bulletin?student_id=<?php echo $bulletin->student_id; ?>" class="action-button see">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="/bulletins/update?id=<?php echo $bulletin->id; ?>" class="action-button update">
                    <i class="fa-solid fa-edit"></i>
                </a>
                <a href="/bulletins/delete?id=<?php echo $bulletin->id; ?>" class="action-button delete">
                    <i class="fa-solid fa-trash"></i>
                </a>

                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php ?>
