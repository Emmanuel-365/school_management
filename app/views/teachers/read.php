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


            <div class="search-container">
                <input type="text" id="search" data-translate-placeholder="search_placeholder" />
                <a href="/teachers/create" class="add-button" data-translate="add_teacher"></a>
            </div>
    <table id="studentsTable">
        <thead>
        <tr>
            <th>ID</th>
            <th data-translate="first_name"></th>
            <th data-translate="last_name"></th>
            <th>Email</th>
            <th data-translate="hire"></th>
            <th data-translate="status"></th>
            <th>Actions</th>
        </tr>
        </thead>
        <?php foreach ($teachers as $teacher): ?>
            <tr>
                <td><?php echo $teacher->id; ?></td>
                <td><?php echo $teacher->first_name; ?></td>
                <td><?php echo $teacher->last_name; ?></td>
                <td><?php echo $teacher->email; ?></td>
                <td><?php echo $teacher->hire_date; ?></td>
                <td><?php echo $teacher->status; ?></td>
                <td>
                    <a href="/teachers/update?id=<?php echo $teacher->id; ?>"  class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a> 
                    <a href="#" 
   class="action-button delete" 
   onclick="confirmDeletion(<?php echo $teacher->id; ?>)">
   <i class="fa-solid fa-trash"></i>
</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="navigation">
        <button id="prevPage" class="nav-button" data-translate="previous" disabled></button>
        <button id="nextPage" class="nav-button" data-translate="next"></button>
    </div>

   
    <script>
    const allTeachers = <?= json_encode($teachers) ?>; 
    const isAdmin = <?= json_encode($database->isAdmin()) ?>; 
    let currentPage = 1;
    const itemsPerPage = 5;

    // Fonction pour afficher les enseignants dans le tableau
    function renderTable(teachers) {
        const tbody = document.querySelector('#studentsTable tbody');
        tbody.innerHTML = ''; // Vider le tableau

        teachers.forEach((teacher) => {
            let row = `
                <tr>
                    <td>${teacher.id}</td>
                    <td>${teacher.first_name}</td>
                    <td>${teacher.last_name}</td>
                    <td>${teacher.email}</td>
                    <td>${teacher.hire_date}</td>
                    <td>${teacher.status}</td>
                    <td>`;

            if (isAdmin) {
                row += `
                    <a href="/teachers/update?id=${teacher.id}" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="#" class="action-button delete" onclick="confirmDelete(${teacher.id})">
                <i class="fa-solid fa-trash"></i>`;
            }

            row += `</td></tr>`;
            tbody.innerHTML += row;
        });
    }

    // Fonction pour gérer la pagination
    function paginateTeachers(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const teachersForPage = allTeachers.slice(start, end);

        renderTable(teachersForPage);

        // Gérer les boutons de navigation
        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = end >= allTeachers.length;
    }

    // Fonction pour rechercher des enseignants
    function filterTeachers(query) {
        const filteredTeachers = allTeachers.filter((teacher) => {
            const fullName = `${teacher.first_name} ${teacher.last_name}`.toLowerCase();
            const email = (teacher.email || '').toLowerCase();

            return (
                fullName.includes(query) ||
                email.includes(query)
            );
        });

        currentPage = 1; // Réinitialiser à la première page
        renderTable(filteredTeachers.slice(0, itemsPerPage)); // Afficher les résultats de recherche
        document.getElementById('prevPage').disabled = true;
        document.getElementById('nextPage').disabled = filteredTeachers.length <= itemsPerPage;
    }

    // Écouteurs pour les boutons de pagination
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginateTeachers(currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(allTeachers.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateTeachers(currentPage);
        }
    });

    // Écouteur pour la recherche
    document.getElementById('search').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query) {
            filterTeachers(query);
        } else {
            paginateTeachers(currentPage); 
        }
    });

    paginateTeachers(currentPage);
</script>
<script>
function confirmDelete(teacherId) {
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
            // Redirige l'utilisateur vers le lien de suppression si confirmé
            window.location.href = `/teachers/delete?id=${teacherId}`;
        }
    });
}
</script>
