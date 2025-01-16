<?php

use App\Config\Database;
use App\Controllers\ClassController;

$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$classController = new ClassController($db);

// Lire toutes les classes avec leurs niveaux
$classes = $classController->readAllClasses();
?>


<div class="search-container">
    <input type="text" id="search" data-translate-placeholder="search_placeholder" />
    <a href="/classes/create" class="add-button" data-translate="add_class">Add Class</a>
</div>

<table id="classTable">
    <thead>
        <tr>
            <th>ID</th>
            <th data-translate="name">Name</th>
            <th data-translate="level">Level</th>
            <th data-translate="t_fee">Total Fee</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($classes as $class): ?>
            <tr>
                <td><?php echo htmlspecialchars($class->id); ?></td>
                <td><?php echo htmlspecialchars($class->name); ?></td>
                <td><?php echo htmlspecialchars($class->level); ?></td>
                <td><?php echo htmlspecialchars($class->total_fee); ?></td>
                <td>
                    <a href="/classes/update?id=<?php echo $class->id; ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a> 
                    <a href="/classes/delete?id=<?php echo $class->id; ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="navigation">
        <button id="prevPage" class="nav-button" data-translate="previous" disabled></button>
        <button id="nextPage" class="nav-button" data-translate="next"></button>
    </div>

    <script>
    const allClasses = <?= json_encode($classes) ?>; // Les données des classes
    const isAdmin = <?= json_encode($database->isAdmin()) ?>; // Vérifie si l'utilisateur est admin
    const itemsPerPage = 5;
    let currentPage = 1;

    // Fonction pour afficher les classes dans le tableau
    function renderTable(classes) {
        const tbody = document.querySelector('#classTable tbody');
        tbody.innerHTML = ''; // Réinitialiser le tableau

        classes.forEach((classe) => {
            const row = `
                <tr>
                    <td>${classe.id || ''}</td>
                    <td>${classe.name || ''}</td>
                    <td>${classe.level || ''}</td>
                    <td>${classe.total_fee || ''}</td>
                    <td>
                        ${isAdmin ? `
                            <a href="/classes/update?id=${classe.id}" class="action-button update">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="action-button delete" onclick="confirmDelete(${classe.id})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        ` : ''}
                    </td>
                </tr>`;
            tbody.innerHTML += row;
        });
    }

    // Fonction pour gérer la pagination
    function paginateClasses(page, classes = allClasses) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const classesForPage = classes.slice(start, end);

        renderTable(classesForPage);

        // Gérer les boutons de navigation
        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = end >= classes.length;
    }

    // Fonction pour rechercher des classes
    function filterClasses(query) {
        const filteredClasses = allClasses.filter((classe) => {
            const name = (classe.name || '').toLowerCase();
            const level = (classe.level || '').toLowerCase();
            return name.includes(query) || level.includes(query);
        });

        currentPage = 1; // Réinitialiser à la première page
        paginateClasses(currentPage, filteredClasses);
    }

    // Écouteurs pour les boutons de pagination
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginateClasses(currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(allClasses.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateClasses(currentPage);
        }
    });

    // Écouteur pour la recherche
    document.getElementById('search').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query) {
            filterClasses(query);
        } else {
            paginateClasses(currentPage); // Revenir à la pagination normale
        }
    });

    // Fonction de confirmation de suppression
    function confirmDelete(classId) {
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
                window.location.href = `/classes/delete?id=${classId}`;
            }
        });
    }

    // Initialisation de la pagination
    paginateClasses(currentPage);
</script>
