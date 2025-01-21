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

if($database->isTeacher())
    $subjects = $subjectController->readSubjectsByTeacher($_SESSION['user_id']);
else
    $subjects = $subjectController->readAllSubjects();

// Lire toutes les matières
?>

<?php 
$teachers = [];
foreach($subjects as $subject){
    $teachers[] = $teacherController->readTeacherWithUsersInformations($subject->teacher_id);
}
?>


<div class="search-container">
    <input type="text" id="search" data-translate-placeholder="search_placeholder"  />
    <?php if ($database->isAdmin()) : ?>
        <a href="/subjects/create" class="add-button" data-translate="add_subject">Add Subject</a>
    <?php endif ?>
</div>

<table id="subjectTable">
    <thead>
        <tr>
            <th><center>ID</center></th>
            <th data-translate="name"><center>Name</center></th>
            <th data-translate="teacher"><center>Teacher</center></th>
            <th><center data-translate="level">Niveau</center></th>
            <th><center>credit</center></th>
            <th><center>Actions</center></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subjects as $subject): ?>
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
                <td><center><?=$subject->credit ?? 3 ?></center></td>
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
<div class="navigation">
        <button id="prevPage" class="nav-button" data-translate="previous" disabled></button>
        <button id="nextPage" class="nav-button" data-translate="next"></button>
    </div>

    <script>
    const allSubjects = <?= json_encode($subjects) ?>; 
    const allTeachers = <?= json_encode($teachers) ?>;
    const isAdmin = <?= json_encode($database->isAdmin()) ?>; 
    const isTeacher = <?= json_encode($database->isTeacher()) ?>;
    let currentPage = 1;
    const itemsPerPage = 5;

    // Fonction pour afficher les sujets dans le tableau
    function renderSubjects(subjects) {
        const tbody = document.querySelector('#subjectTable tbody');
        tbody.innerHTML = ''; // Vider le tableau existant

        subjects.forEach(subject => {
            const teacher = allTeachers.find(teacher => teacher.id === subject.teacher_id);
            console.log(teacher);
            let row = `
                <tr>
                    <td><center>${subject.id}</center></td>
                    <td><center>${subject.name}</center></td>
                    <td><center>${teacher.first_name + ' ' + teacher.last_name || 'Aucun enseignant'}</center></td>
                    <td><center>${subject.level}</center></td>
                    <td><center>${subject.credit}</center></td>
                    <td><center>`;
            if (isAdmin) {
                row += `
                    <a href="/subjects/update?id=${subject.id}" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="#" class="action-button delete" onclick="confirmDelete(${subject.id})"><i class="fa-solid fa-trash"></i></a>`;
            } else if (isTeacher) {
                row += `
                    <a href="/students?subject_id=${subject.id}" class="action-button update"><i class="fa-solid fa-eye"></i></a>`;
            }
            row += `</center></td></tr>`;
            tbody.innerHTML += row;
        });
    }

    // Fonction pour gérer la pagination
    function paginateSubjects(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const subjectsForPage = allSubjects.slice(start, end);

        renderSubjects(subjectsForPage);

        // Gérer les boutons de navigation
        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = end >= allSubjects.length;
    }

    // Fonction pour rechercher des sujets
    function filterSubjects(query) {
        const filteredSubjects = allSubjects.filter((subject) => {
            const teacher = allteachers.find(teacher => teacher.id === student.teacher_id);

            const name = `${subject.name}`.toLowerCase();
            const level = (subject.level || '').toLowerCase();

            return (
                name.includes(query) ||
                level.includes(query) ||
                teacherName.includes(query) 
            );
        });

        currentPage = 1; // Réinitialiser à la première page
        renderSubjects(filteredSubjects.slice(0, itemsPerPage)); // Afficher les résultats de recherche
        document.getElementById('prevPage').disabled = true;
        document.getElementById('nextPage').disabled = filteredSubjects.length <= itemsPerPage;
    }

    // Fonction pour confirmer la suppression
    function confirmDelete(subjectId) {
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
                // Rediriger vers l'URL de suppression
                window.location.href = `/subjects/delete?id=${subjectId}`;
            }
        });
    }

    // Écouteurs pour la pagination
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginateSubjects(currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(allSubjects.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateSubjects(currentPage);
        }
    });

    // Écouteur pour la recherche
    document.getElementById('search').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query) {
            filterSubjects(query);
        } else {
            paginateSubjects(currentPage); 
        }
    });

    // Initialiser avec la première page
    paginateSubjects(currentPage);
</script>