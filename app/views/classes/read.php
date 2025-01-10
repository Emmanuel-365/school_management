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

<?php  ?>
<div class="search-container">
    <input type="text" id="search" placeholder="Search for a class..." />
    <a href="/classes/create" class="add-button">Add Class</a>
</div>

<table border="1" id="classTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Level</th>
            <th>Total Fee</th>
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

<script>
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('#classTable tbody tr');

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

