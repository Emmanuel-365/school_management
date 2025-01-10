<?php

use App\Config\Database;
use App\Controllers\ClassController;
use App\Controllers\SubjectController;
use App\Controllers\TeacherController;


$database = new Database();

$db = $database->getConnection();

// Initialisation des contrôleurs
$subjectController = new SubjectController($db);
$teacherController = new TeacherController($db);
$classController = new ClassController($db);

// Lire toutes les matières
$subjects = $subjectController->readAllSubjects();
?>

<?php
// Assuming $subjects is your array of all subjects
$itemsPerPage = 5;
$totalPages = ceil(count($subjects) / $itemsPerPage);
$currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
$currentPageSubjects = array_slice($subjects, $offset, $itemsPerPage);
?>
<div class="search-container">
    <input type="text" id="search" placeholder="Search for a subject..." />
    <?php if ($database->isAdmin()) : ?>
        <a href="/subjects/create" class="add-button">Add Subject</a>
    <?php endif ?>
</div>

<table id="subjectTable">
    <thead>
        <tr>
            <th><center>ID</center></th>
            <th><center>Name</center></th>
            <th><center>Teacher</center></th>
            <th><center>Niveau</center></th>
            <th><center>Actions</center></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($currentPageSubjects as $subject): ?>
            <?php if($subject->teacher_id == $_SESSION['user_id'] || $_SESSION['user_role'] === 'admin') : ?>
            <tr>
                <td><center><?php echo $subject->id; ?></center></td>
                <td><center><?php echo htmlspecialchars($subject->name); ?></center></td>
                <td>
                    <center><?= $subject->teacher_id !== null 
                        ? htmlspecialchars($teacherController->readTeacherWithUsersInformations($subject->teacher_id)->first_name . ' ' . $teacherController->readTeacherWithUsersInformations($subject->teacher_id)->last_name) 
                        : 'aucun' 
                    ?></center>
                </td>
                <td><center><?= htmlspecialchars($subject->level); ?></center></td>
                <td>
                    <center><?php if($database->isAdmin()) : ?>
                        <a href="/subjects/update?id=<?php echo $subject->id; ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a> 
                        <a href="/subjects/delete?id=<?php echo $subject->id; ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                    <?php elseif($database->isTeacher()) : ?>
                        <a href="/students?subject_id=<?=$subject->id?>" class="action-button update"><i class="fa-solid fa-eye"></i></a>
                    <?php endif ?></center>
                </td>
            </tr>
            <?php endif ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (count($subjects) > 5): ?>
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

<script>
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('#subjectTable tbody tr');

    let searchTimeout;

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(() => {
            const searchTerm = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                if (rowText.includes(searchTerm)) {
                    row.style.display = ''; // Affiche la ligne
                } else {
                    row.style.display = 'none'; // Cache la ligne
                }
            });
        }, 300); // Intervalle de 300 ms
    });
</script>

