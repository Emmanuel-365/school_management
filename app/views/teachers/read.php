<?php

use App\Config\Database;
use App\Controllers\TeacherController;


$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$teacherController = new TeacherController($db);

// Lire tous les enseignants
$teachers = $teacherController->readAllTeachersWithUsersInformations();
?>

<?php
// Assuming $teachers is your array of all teachers
$itemsPerPage = 5;
$totalPages = ceil(count($teachers) / $itemsPerPage);
$currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
$currentPageTeachers = array_slice($teachers, $offset, $itemsPerPage);
?>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search for a teacher..." />
                <a href="/teachers/create" class="add-button">Add Teacher</a>
            </div>
    <table id="studentsTable">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Hire Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($currentPageTeachers as $teacher): ?>
            <tr>
                <td><?php echo $teacher->id; ?></td>
                <td><?php echo $teacher->first_name; ?></td>
                <td><?php echo $teacher->last_name; ?></td>
                <td><?php echo $teacher->email; ?></td>
                <td><?php echo $teacher->hire_date; ?></td>
                <td><?php echo $teacher->status; ?></td>
                <td>
                    <a href="/teachers/update?id=<?php echo $teacher->id; ?>"  class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a> 
                    <a href="/teachers/delete?id=<?php echo $teacher->id; ?>"  class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if (count($teachers) > 5): ?>
    <div class="navigation">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>" id="prevPage" class="nav-button prev-button">
                <i class="fas fa-chevron-left"></i> Précédent
            </a>
        <?php endif; ?>
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>" id="nextPage" class="nav-button next-button">
                Suivant <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
