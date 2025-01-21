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
                <td><?php echo htmlspecialchars($subject->name); ?></td>
                <td>
                    <?= $subject->teacher_id !== null 
                        ? htmlspecialchars($teacherController->readTeacherWithUsersInformations($subject->teacher_id)->first_name . ' ' . $teacherController->readTeacherWithUsersInformations($subject->teacher_id)->last_name) 
                        : 'aucun' 
                    ?>
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
