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

<?php
// Assuming $bulletins is your array of all bulletins
$itemsPerPage = 5;
$totalPages = ceil(count($bulletins) / $itemsPerPage);
$currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
$currentPageBulletins = array_slice($bulletins, $offset, $itemsPerPage);
?>
<div class="search-container">
    <input type="text" id="search" placeholder="Search for a bulletins..." />
    <a href="/bulletins/create" class="add-button">Add Bulletin</a>
</div>
<table>
    <tr>
        <th>ID</th>
        <th>Student</th>
        <th>Class</th>
        <th>Period</th>
        <th>Issue Date</th>
        <th>Comments</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($currentPageBulletins as $bulletin): ?>
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
        <?php if ($database->isAdmin()): ?>
                <a href="/bulletins/update?id=<?php echo $bulletin->id; ?>" class="action-button update">
                    <i class="fa-solid fa-edit"></i>
                </a>
                <a href="/bulletins/delete?id=<?php echo $bulletin->id; ?>" class="action-button delete">
                    <i class="fa-solid fa-trash"></i>
                </a>
        <?php endif ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php if (count($bulletins) > 5): ?>
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