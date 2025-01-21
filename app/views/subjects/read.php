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

if ($database->isTeacher())
    $subjects = $subjectController->readSubjectsByTeacher($_SESSION['user_id']);
else
    $subjects = $subjectController->readAllSubjects();

// Lire toutes les matières
?>

<?php
$teachers = [];
foreach ($subjects as $subject) {
    $teachers[] = $teacherController->readTeacherWithUsersInformations($subject->teacher_id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des matières</title>
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
        .subject-row {
            display: none; /* Cacher toutes les lignes par défaut */
        }
    </style>
</head>
<body>
    <div class="search-container">
        <input type="text" id="search" data-translate-placeholder="search_placeholder" />
        <?php if ($database->isAdmin()) : ?>
            <a href="/subjects/create" class="add-button" data-translate="add_subject">Add Subject</a>
        <?php endif ?>
    </div>

    <table id="subjectTable">
        <thead>
            <tr>
                <th><center>ID</center></th>
                <th data-translate="name"><center>Name</center></th>
                <?php if($database->isAdmin()) : ?>
                <th data-translate="teacher"><center>Teacher</center></th>
                <?php endif ?>
                <th><center data-translate="level">Niveau</center></th>
                <th><center>credit</center></th>
                <th><center>Actions</center></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subjects as $subject) : ?>
                <?php if ($subject->teacher_id == $_SESSION['user_id'] || $_SESSION['user_role'] === 'admin') : ?>
                    <tr class="subject-row">
                        <td><center><?php echo $subject->id; ?></center></td>
                        <td><?php echo htmlspecialchars($subject->name); ?></td>
                        <?php if($database->isAdmin()) : ?>
                        <td>
                            <?= $subject->teacher_id !== null
                                ? htmlspecialchars($teacherController->readTeacherWithUsersInformations($subject->teacher_id)->first_name . ' ' . $teacherController->readTeacherWithUsersInformations($subject->teacher_id)->last_name)
                                : 'aucun'
                            ?>
                        </td>
                        <?php endif ?>
                        <td><center><?= htmlspecialchars($subject->level); ?></center></td>
                        <td><center><?= $subject->credit ?? 3 ?></center></td>
                        <td>
                            <center><?php if ($database->isAdmin()) : ?>
                                <a href="/subjects/update?id=<?php echo $subject->id; ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="/subjects/delete?id=<?php echo $subject->id; ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                            <?php elseif ($database->isTeacher()) : ?>
                                <a href="/students?subject_id=<?= $subject->id ?>" class="action-button update"><i class="fa-solid fa-eye"></i></a>
                            <?php endif ?></center>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <button id="prevPage" class="nav-button" data-translate="previous">Précédent</button>
        <span id="pageInfo"></span>
        <button id="nextPage" class="nav-button" data-translate="next">Suivant</button>
    </div>

    <script>
        // Configuration de la pagination
        const itemsPerPage = 5; // Nombre de matières par page
        let subjectRows = Array.from(document.querySelectorAll('.subject-row')); // Convertir NodeList en tableau
        let totalSubjects = subjectRows.length; // Nombre total de matières
        let totalPages = Math.ceil(totalSubjects / itemsPerPage); // Nombre total de pages
        let currentPage = 1;

        // Variable pour stocker les lignes visibles après la recherche
        let visibleRows = subjectRows;

        // Fonction pour afficher les matières de la page actuelle
        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            // Cacher toutes les lignes d'abord
            subjectRows.forEach(row => row.style.display = 'none');

            // Afficher uniquement les lignes visibles de la page actuelle
            visibleRows.slice(start, end).forEach(row => row.style.display = 'table-row');

            // Mettre à jour les informations de la page
            document.getElementById('pageInfo').textContent = `Page ${page} sur ${totalPages}`;

            // Activer/désactiver les boutons de pagination
            document.getElementById('prevPage').disabled = page === 1;
            document.getElementById('nextPage').disabled = page === totalPages || visibleRows.length <= itemsPerPage;
        }

        // Fonction pour filtrer les matières en fonction de la recherche
        function filterSubjects(query) {
            query = query.toLowerCase(); // Convertir la recherche en minuscules

            // Filtrer les lignes visibles en fonction de la recherche
            visibleRows = subjectRows.filter(row => {
                const cells = row.querySelectorAll('td'); // Tous les champs de la ligne
                return Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
            });

            // Mettre à jour la pagination après la recherche
            updatePagination();
        }

        // Fonction pour mettre à jour la pagination après la recherche
        function updatePagination() {
            totalSubjects = visibleRows.length;
            totalPages = Math.ceil(totalSubjects / itemsPerPage);
            currentPage = 1; // Revenir à la première page après la recherche
            showPage(currentPage);
        }

        // Délai de 300 ms pour la recherche
        let searchTimeout;
        document.getElementById('search').addEventListener('input', (e) => {
            clearTimeout(searchTimeout); // Annuler le délai précédent
            searchTimeout = setTimeout(() => {
                filterSubjects(e.target.value); // Exécuter la recherche après 300 ms
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