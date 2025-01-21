<?php

use App\Config\Database;
use App\Controllers\BulletinController;
use App\Controllers\ClassController;
use App\Controllers\GradeController;
use App\Controllers\StudentController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$bulletinController = new BulletinController($db);
$gradeController = new GradeController($db);
$studentController = new StudentController($db);
$classController = new ClassController($db );   

// Lire tous les bulletins
$bulletins = $bulletinController->readAllBulletins();
?>


        <?php if ($database->isAdmin()): ?>

<div class="search-container">
    <input type="text" id="search" placeholder="Search for a bulletins..." />
    <a href="/bulletins/create" class="add-button">Add Bulletin</a>
</div>
<?php endif ?>
<table>
    <tr>
        <th>ID</th>
        <th data-translate="student">Student</th>
        <th data-translate="class">Class</th>
        <th data-translate="period">Period</th>
        <th data-translate="issue">Issue Date</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($bulletins as $bulletin): ?>
        <tr>
            <td><?php echo $bulletin->id; ?></td>
            <td><?php echo $studentController->readStudentWithUsersInformations($bulletin->student_id)->first_name . ' ' . $studentController->readStudentWithUsersInformations($bulletin->student_id)->last_name ; ?></td>
            <td><?php echo $classController->readClass($bulletin->class_id)->name; ?></td>
            <td><?php echo $bulletin->period; ?></td>
            <td><?php echo $bulletin->issue_date; ?></td>
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
<div class="navigation">
    <button id="prevPage" class="nav-button" data-translate="previous" disabled></button>
    <button id="nextPage" class="nav-button" data-translate="next"></button>
</div>


<script>
    const allBulletins = <?= json_encode($bulletins) ?>; // Les bulletins passés depuis PHP
    const isAdmin = <?= json_encode($database->isAdmin()) ?>; // Vérifie si l'utilisateur est admin
    const itemsPerPage = 5; // Nombre d'éléments par page
    let currentPage = 1;

    // Fonction pour afficher les bulletins dans le tableau
    function renderTable(bulletins) {
        const tbody = document.querySelector('#bulletinsTable tbody');
        tbody.innerHTML = ''; // Réinitialiser le tableau

        bulletins.forEach((bulletin) => {
            const row = `

            <tr>
        <th>ID</th>
        <th data-translate="student">Student</th>
        <th data-translate="class">Class</th>
        <th data-translate="period">Period</th>
        <th data-translate="issue">Issue Date</th>
        <th>Actions</th>
            </tr>

                <tr>
                    <td>${bulletin.id}</td>
                    <td>${bulletin.student_id}</td>
                    <td>${bulletin.class_id}</td>
                    <td>${bulletin.period}</td>
                    <td>${bulletin.issue_date}</td>
                    <td>
                        <a href="/bulletins/bulletin?student_id=${bulletin.student_id}" class="action-button see">
                            <i class="fas fa-eye"></i>
                        </a>
                        ${isAdmin ? `
                            <a href="/bulletins/update?id=${bulletin.id}" class="action-button update">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <a href="#" class="action-button delete" onclick="confirmDelete(${bulletin.id})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        ` : ''}
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // Fonction pour gérer la pagination
    function paginateBulletins(page, bulletins = allBulletins) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const bulletinsForPage = bulletins.slice(start, end);

        renderTable(bulletinsForPage);

        // Gérer les boutons de navigation
        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = end >= bulletins.length;
    }

    // Fonction pour rechercher des bulletins
    function filterBulletins(query) {
        const filteredBulletins = allBulletins.filter((bulletin) => {
            const studentId = (bulletin.student_id || '').toString().toLowerCase();
            const classId = (bulletin.class_id || '').toString().toLowerCase();
            const period = (bulletin.period || '').toLowerCase();

            return (
                studentId.includes(query) ||
                classId.includes(query) ||
                period.includes(query)
            );
        });

        currentPage = 1; // Réinitialiser à la première page
        paginateBulletins(currentPage, filteredBulletins);
    }

    // Écouteurs pour les boutons de pagination
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginateBulletins(currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(allBulletins.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateBulletins(currentPage);
        }
    });

    // Écouteur pour la recherche
    document.getElementById('search').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query) {
            filterBulletins(query);
        } else {
            paginateBulletins(currentPage);
        }
    });

    // Fonction de confirmation de suppression
    function confirmDelete(bulletinId) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/bulletins/delete?id=${bulletinId}`;
            }
        });
    }

    // Initialisation de la pagination
    paginateBulletins(currentPage);
</script>