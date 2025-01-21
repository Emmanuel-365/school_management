<?php

use App\Config\Database;
use App\Controllers\StudentController;
use App\Controllers\ClassController;
use App\Controllers\ParentController;
use App\Controllers\SubjectController;
use App\Controllers\GradeController;

$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$studentController = new StudentController($db);
$classController = new ClassController($db);
$parentController = new ParentController($db);
$subjectController = new SubjectController($db);
$gradeController = new GradeController($db);

// Récupérer les étudiants
if (isset($_GET['subject_id'])) {
    $subjectLevel = $subjectController->readField('level', $_GET['subject_id']);
    $students = $studentController->readStudentsByLevel($subjectLevel);
    $grades = $gradeController->readAllGradesBySubject($_GET['subject_id']);
} else {
    $students = $studentController->readAllStudentsWithUsersInformations();
}

// Récupérer les parents et les classes pour les étudiants
$parents = [];
$classes = [];
foreach ($students as $student) {
    $parents[] = $parentController->readParent($student->parent_id);
    $classes[] = $classController->readClass($student->class_id);
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <style>
        .search-container {
            margin-bottom: 20px;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
        }
        .pagination a.active {
            font-weight: bold;
            color: #000;
        }
        .student-row {
            display: none; /* Cacher toutes les lignes par défaut */
        }
    </style>
</head>
<body>
    <div class="search-container">
        <input type="text" id="search" data-translate-placeholder="search_placeholder" />
        <?php if ($database->isAdmin()) : ?>
            <a href="/students/create" class="add-button" data-translate="add_student"></a>
        <?php endif ?>
    </div>

    <table id="studentsTable">
        <thead>
            <tr>
                <th>Profile</th>
                <th data-translate="student_name"></th>
                <th data-translate="class"></th>
                <?php if ($database->isAdmin()) : ?>
                    <th>Matricule</th>
                    <th data-translate="parent"></th>
                    <th data-translate="remaining_fee"></th>
                    <th data-translate="status"></th>
                    <th>Actions</th>
                <?php endif ?>
                <?php if ($database->isTeacher()) : ?>
                    <th>CC</th>
                    <th>TP</th>
                    <th data-translate="rattrapage"></th>
                    <th data-translate="exam"></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $index => $student) : 
                $totalFee = $student->class_id != null ? $classController->readClass($student->class_id)->total_fee : 0;
                $remainingFee = $student->remaining_fee;
                $profilePicture = !empty($student->profile_picture) ? $student->profile_picture : '/images/profiles/default_profile.jpg';

                if ($database->isTeacher()) :
                    // Initialisation des variables de notes
                    $cc = $tp = $rattrapage = $exam = 'N/A';
                    $ccId = $tpId = $rattrapageId = $examId = null;

                    foreach ($grades as $grade) : 
                        if ($grade->student_id === $student->id) : 
                            switch ($grade->type_note) {
                                case 'cc':
                                    $cc = $grade->grade;
                                    $ccId = $grade->id;
                                    break;
                                case 'tp':
                                    $tp = $grade->grade;
                                    $tpId = $grade->id;
                                    break;
                                case 'rattrapage':
                                    $rattrapage = $grade->grade;
                                    $rattrapageId = $grade->id;
                                    break;
                                case 'exam':
                                    $exam = $grade->grade;
                                    $examId = $grade->id;
                                    break;
                            }
                        endif;
                    endforeach;
                endif;
            ?>
                <tr class="student-row" data-index="<?= $index ?>">
                    <td><img src="<?php echo $profilePicture; ?>" alt="Profile" class="profile-picture"></td>
                    <td><?php echo $student->first_name . ' ' . $student->last_name; ?></td>
                    <td><?php echo $student->class_id != null ? $classController->readClass($student->class_id)->name : 'N/A'; ?></td>
                    <?php if ($database->isAdmin()) : ?>
                        <td><?php echo $student->matricule ?></td>
                        <td><?php echo $parentController->readParent($student->parent_id)->first_name; ?></td>
                        <td><?php echo $student->remaining_fee; ?></td>
                        <td><?php echo $student->status; ?></td>
                    <?php endif ?>
                    
                    <?php if ($database->isTeacher()) : ?>
                        <td>
                            <?php if ($cc == 'N/A') : ?>
                                <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=cc" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                            <?php else : ?>
                                <?= $cc ?>
                                <a href="/grades/update?id=<?= $ccId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($tp == 'N/A') : ?>
                                <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=tp" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                            <?php else : ?>
                                <?= $tp ?>
                                <a href="/grades/update?id=<?= $tpId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($rattrapage == 'N/A' && (int) $exam <= 12) : ?>
                                <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=rattrapage" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                            <?php elseif ((int) $exam <= 12) : ?>
                                <?= $rattrapage ?>
                                <a href="/grades/update?id=<?= $rattrapageId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($exam == 'N/A') : ?>
                                <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=exam" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                            <?php else : ?>
                                <?= $exam ?>
                                <a href="/grades/update?id=<?= $examId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>

                    <td>
                        <?php if ($database->isAdmin()) : ?>
                            <a href="/payments/create?student_id=<?= $student->id ?>" class="action-button add-payment"><i class="fa-solid fa-credit-card"></i></a>
                            <a href="/students/update?id=<?php echo $student->id; ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="/students/delete?id=<?php echo $student->id; ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <button id="prevPage" class="nav-button" data-translate="previous"></button>
        <span id="pageInfo"></span>
        <button id="nextPage" class="nav-button" data-translate="next"></button>    
    </div>

    <script>
    // Configuration de la pagination
    const itemsPerPage = 5; // Nombre d'étudiants par page
    let studentRows = Array.from(document.querySelectorAll('.student-row')); // Convertir NodeList en tableau
    let totalStudents = studentRows.length; // Nombre total d'étudiants
    let totalPages = Math.ceil(totalStudents / itemsPerPage); // Nombre total de pages
    let currentPage = 1;

    // Variable pour stocker les lignes visibles après la recherche
    let visibleRows = studentRows;

    // Fonction pour afficher les étudiants de la page actuelle
    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Cacher toutes les lignes d'abord
        studentRows.forEach(row => row.style.display = 'none');

        // Afficher uniquement les lignes visibles de la page actuelle
        visibleRows.slice(start, end).forEach(row => row.style.display = 'table-row');

        // Mettre à jour les informations de la page
        document.getElementById('pageInfo').textContent = `Page ${page} sur ${totalPages}`;

        // Activer/désactiver les boutons de pagination
        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = page === totalPages || visibleRows.length <= itemsPerPage;
    }

    // Fonction pour filtrer les étudiants en fonction de la recherche
    function filterStudents(query) {
        query = query.toLowerCase(); // Convertir la recherche en minuscules

        // Filtrer les lignes visibles en fonction de la recherche
        visibleRows = studentRows.filter(row => {
            const cells = row.querySelectorAll('td'); // Tous les champs de la ligne
            return Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
        });

        // Mettre à jour la pagination après la recherche
        updatePagination();
    }

    // Fonction pour mettre à jour la pagination après la recherche
    function updatePagination() {
        totalStudents = visibleRows.length;
        totalPages = Math.ceil(totalStudents / itemsPerPage);
        currentPage = 1; // Revenir à la première page après la recherche
        showPage(currentPage);
    }

    // Délai de 300 ms pour la recherche
    let searchTimeout;
    document.getElementById('search').addEventListener('input', (e) => {
        clearTimeout(searchTimeout); // Annuler le délai précédent
        searchTimeout = setTimeout(() => {
            filterStudents(e.target.value); // Exécuter la recherche après 300 ms
        }, 300);
    });

    // Bouton "Précédent"
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    // Bouton "Suivant"
    document.getElementById('nextPage').addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    // Afficher la première page au chargement
    showPage(currentPage);
</script>
</body>
</html>