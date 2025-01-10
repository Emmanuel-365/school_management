<?php

use App\Config\Database;
use App\Controllers\GradeController;
use App\Controllers\SubjectController;

$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$gradeController = new GradeController($db);
$subjectController = new SubjectController($db);

// Lire toutes les notes
$grades = [];

if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'student'){
    $grades = $gradeController->readAllGradesByStudent($_SESSION['user_id']);
} else {
    $grades = $gradeController->readAllGrades();
}

// Regrouper les notes par matière et par étudiant
$groupedGrades = [];

foreach ($grades as $grade) {
    $studentId = $grade->student_id;
    $subjectId = $grade->subject_id;
    $typeNote = $grade->type_note;

    if (!isset($groupedGrades[$studentId][$subjectId])) {
        $groupedGrades[$studentId][$subjectId] = [
            'cc' => null,
            'tp' => null,
            'rattrapage' => null,
            'exam' => null,
            'updated_at' => $grade->updated_at ?? $grade->created_at,
            'id' => $grade->id,
        ];
    }

    $groupedGrades[$studentId][$subjectId][$typeNote] = $grade->grade;
}

?>

<table border="1">
    <tr>
        <th>Subjec</th>
        <th>CC</th>
        <th>TP</th>
        <th>Rattrapage</th>
        <th>Exam</th>
        <th>Grade Date</th>
        <?php if($database->isAdmin()) : ?>
        <th>Actions</th>
        <?php endif ?>
    </tr>
    <?php foreach ($groupedGrades as $studentId => $subjects) : ?>
        <?php foreach ($subjects as $subjectId => $notes) : ?>
            <tr>
                <td><?php echo $subjectController->readSubject($subjectId)->name ; ?></td>
                <td><?php echo $notes['cc'] ?? 'N/A'; ?></td>
                <td><?php echo $notes['tp'] ?? 'N/A'; ?></td>
                <td><?php echo $notes['rattrapage'] ?? 'N/A'; ?></td>
                <td><?php echo $notes['exam'] ?? 'N/A'; ?></td>
                <td><?php echo $notes['updated_at']; ?></td>
                <?php if($database->isAdmin()) : ?>
                <td>
                    <a href="/grades/update?id=<?php echo $notes['id']; ?>" class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="/grades/delete?id=<?php echo $notes['id']; ?>" class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                </td>
                <?php endif ?>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>
