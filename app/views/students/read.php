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

if(isset($_GET['subject_id'])) {
    $subjectLevel = $subjectController->readField('level', $_GET['subject_id']);
    $students = $studentController->readStudentsByLevel($subjectLevel);
    $grades = $gradeController->readAllGradesBySubject(($_GET['subject_id']));
}else
    $students = $studentController->readAllStudentsWithUsersInformations();
?>

<?php
$parents = [];
foreach($students as $student){
    $parents[] = $parentController->readParent($student->parent_id);
}
$classes = [];
foreach($students as $student){
    $classes[] = $classController->readclass($student->class_id);
}
?>


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
                        <?php if($database->isAdmin()) : ?>
                            <th data-translate="parent"></th>
                            <th data-translate="remaining_fee"></th>
                            <th data-translate="status"></th>
                        <th>Actions</th>
                        <?php endif ?>
                        <?php if($database->isTeacher()) : ?>
                            <th>CC</th>
                            <th>TP</th>
                            <th data-translate="rattrapage"></th>
                            <th data-translate="exam"></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): 
                        $totalFee = $student->class_id != null ? $classController->readClass($student->class_id)->total_fee : 0;
                        $remainingFee = $student->remaining_fee;
                        $profilePicture = !empty($student->profile_picture) ? $student->profile_picture : '/images/profiles/default_profile.jpg';

                        if($database->isTeacher()):
                            // Initialisation des variables de notes
                            $cc = $tp = $rattrapage = $exam = 'N/A';
                            $ccId = $tpId = $rattrapageId = $examId = null;

                            foreach ($grades as $grade): 
                                if ($grade->student_id === $student->id): 
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
                    <tr>
                        <td><img src="<?php echo $profilePicture; ?>" alt="Profile" class="profile-picture"></td>
                        <td><?php echo $student->first_name . ' ' . $student->last_name; ?></td>
                        <td><?php echo $student->class_id != null ? $classController->readClass($student->class_id)->name : 'N/A'; ?></td>
                        <?php if($database->isAdmin()) : ?>
                        <td><?php echo $parentController->readParent($student->parent_id)->first_name; ?></td>
                        <td><?php echo $student->remaining_fee; ?></td>
                        <td><?php echo $student->status; ?></td>
                        <?php endif ?>
                        
                        <?php if ($database->isTeacher()): ?>
                            <td>
                                <?php if ($cc == 'N/A'): ?>
                                    <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=cc" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                                <?php else: ?>
                                    <?=$cc?>
                                    <a href="/grades/update?id=<?= $ccId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <!-- <a href="/grades/delete?id=<?= $ccId ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a> -->
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($tp == 'N/A'): ?>
                                    <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=tp" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                                <?php else: ?>
                                    <?=$tp?>
                                    <a href="/grades/update?id=<?= $tpId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <!-- <a href="/grades/delete?id=<?= $tpId ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a> -->
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($rattrapage == 'N/A'): ?>
                                    <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=rattrapage" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                                <?php else: ?>
                                    <?=$rattrapage?>
                                    <a href="/grades/update?id=<?= $rattrapageId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <!-- <a href="/grades/delete?id=<?= $rattrapageId ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a> -->
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($exam == 'N/A'): ?>
                                    <a href="/grades/create?subject_id=<?= $_GET['subject_id'] ?>&student_id=<?= $student->id ?>&type_note=exam" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>
                                <?php else: ?>
                                    <?=$exam?>
                                    <a href="/grades/update?id=<?= $examId ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <!-- <a href="/grades/delete?id=<?= $examId ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a> -->
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>

                        <td>
                            <?php if ($database->isAdmin()): ?>
                                <a href="/payments/create?student_id=<?=$student->id?>" class="action-button add-payment"><i class="fa-solid fa-credit-card"></i></a>
                                <a href="/students/update?id=<?php echo $student->id; ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="/students/delete?id=<?php echo $student->id; ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>
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
    const allStudents = <?= json_encode($students) ?>;
    const allParents = <?=json_encode($parents); ?>;
    const allClasses = <?=json_encode($classes) ?>;
    const isAdmin = <?= json_encode($database->isAdmin()) ?>;
    const isTeacher = <?= json_encode($database->isTeacher()) ?>;
    let currentPage = 1;
    const itemsPerPage = 5;


    // Fonction pour afficher les étudiants dans le tableau
    function renderTable(students) {
        const tbody = document.querySelector('#studentsTable tbody');
        tbody.innerHTML = ''; // Vider le tableau

        students.forEach((student) => {
            const parent = allParents.find(parent => parent.id === student.parent_id);
            const classe = allClasses.find(classe => classe.id === student.class_id )

            const totalFee = student.total_fee || 0;
            const remainingFee = student.remaining_fee || 0;
            const profilePicture = student.profile_picture || '/images/profiles/default_profile.jpg';

            let row = `
                <tr>
                    <td><img src="${profilePicture}" alt="Photo" style="width: 50px; height: 50px; border-radius: 50%;"></td>
                    <td>${student.first_name} ${student.last_name}</td>
                    <td>${classe.name ?? 'N/A'}</td>
            `;

            if (isAdmin) {
                row += `
                    <td>${parent.first_name + ' ' + parent.last_name || 'N/A'}</td>
                    <td>${remainingFee}</td>
                    <td>${student.status}</td>
                    <td>
                        <a href="/payments/create?student_id=${student.id}" class="action-button add-payment"><i class="fa-solid fa-credit-card"></i></a>
                        <a href="/students/update?id=${student.id}" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" class="action-button delete" onclick="confirmDelete(${student.id})">
                        <i class="fa-solid fa-trash"></i>
                    </td>
                `;
            }

            if (isTeacher) {
                row += `
                    <td>${student.cc === 'N/A' ? `<a href="/grades/create?subject_id=${student.subject_id}&student_id=${student.id}&type_note=cc" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>` : `${student.cc} <a href="/grades/update?id=${student.ccId}" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>`}</td>
                    <td>${student.tp === 'N/A' ? `<a href="/grades/create?subject_id=${student.subject_id}&student_id=${student.id}&type_note=tp" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>` : `${student.tp} <a href="/grades/update?id=${student.tpId}" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>`}</td>
                    <td>${student.rattrapage === 'N/A' ? `<a href="/grades/create?subject_id=${student.subject_id}&student_id=${student.id}&type_note=rattrapage" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>` : `${student.rattrapage} <a href="/grades/update?id=${student.rattrapageId}" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>`}</td>
                    <td>${student.exam === 'N/A' ? `<a href="/grades/create?subject_id=${student.subject_id}&student_id=${student.id}&type_note=exam" class="action-button add-payment"><i class="fa-solid fa-plus"></i></a>` : `${student.exam} <a href="/grades/update?id=${student.examId}" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>`}</td>
                `;
            }

            row += `</tr>`;
            tbody.innerHTML += row;
        });
    }

    // Fonction pour gérer la pagination
    function paginateStudents(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const studentsForPage = allStudents.slice(start, end);

        renderTable(studentsForPage);

        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = end >= allStudents.length;
    }

    // Fonction pour rechercher des étudiants
    function filterStudents(query) {
        const filteredStudents = allStudents.filter((student) => {
            const parent = allParents.find(parent => parent.id === student.parent_id);
            const classe = allClasses.find(classe => classe.id === student.class_id );

            const fullName = `${student.first_name} ${student.last_name}`.toLowerCase();
            const className = (student.class_name || '').toLowerCase();
            const parentName = (parent.first_name + ' ' + parent.last_name || '').toLowerCase();
            const classeName = (classe.name || '').toLowerCase();

            return (
                fullName.includes(query) ||
                className.includes(query) ||
                parentName.includes(query) ||
                classeName.includes(query)
            );
        });

        currentPage = 1;
        renderTable(filteredStudents.slice(0, itemsPerPage)); // Afficher les résultats de recherche
        document.getElementById('prevPage').disabled = true;
        document.getElementById('nextPage').disabled = filteredStudents.length <= itemsPerPage;
    }

    // Écouteurs pour les boutons de pagination
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginateStudents(currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(allStudents.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateStudents(currentPage);
        }
    });

    // Écouteur pour la recherche
    document.getElementById('search').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query) {
            filterStudents(query);
        } else {
            paginateStudents(currentPage); // Réafficher la pagination si la recherche est vide
        }
    });

    paginateStudents(currentPage);
</script>
<script>
function confirmDelete(studentId) {
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
            window.location.href = `/students/delete?id=${studentId}`;
        }
    });
}
</script>


