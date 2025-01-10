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

<?php  ?>
<div class="search-container">
    <input type="text" id="search" placeholder="Search for a subject..." />
    <?php if ($database->isAdmin()) : ?>
        <a href="/subjects/create" class="add-button">Add Subject</a>
    <?php endif ?>
</div>

<table border="1" id="subjectTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Teacher</th>
            <th>Niveau</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subjects as $subject): ?>
            <?php if($subject->teacher_id == $_SESSION['user_id'] || $_SESSION['user_role'] === 'admin') : ?>
            <tr>
                <td><?php echo $subject->id; ?></td>
                <td><?php echo htmlspecialchars($subject->name); ?></td>
                <td>
                    <?= $subject->teacher_id !== null 
                        ? htmlspecialchars($teacherController->readTeacherWithUsersInformations($subject->teacher_id)->first_name . ' ' . $teacherController->readTeacherWithUsersInformations($subject->teacher_id)->last_name) 
                        : 'aucun' 
                    ?>
                </td>
                <td><?= htmlspecialchars($subject->level); ?></td>
                <td>
                    <?php if($database->isAdmin()) : ?>
                        <a href="/subjects/update?id=<?php echo $subject->id; ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a> 
                        <a href="/subjects/delete?id=<?php echo $subject->id; ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                    <?php elseif($database->isTeacher()) : ?>
                        <a href="/students?subject_id=<?=$subject->id?>" class="action-button update"><i class="fa-solid fa-eye"></i></a>
                    <?php endif ?>
                </td>
            </tr>
            <?php endif ?>
        <?php endforeach; ?>
    </tbody>
</table>

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

    <?php  ?>
</body>
</html>
