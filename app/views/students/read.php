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
// Assuming $students is your array of all students
$itemsPerPage = 5;
$totalPages = ceil(count($students) / $itemsPerPage);
$currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
$currentPageStudents = array_slice($students, $offset, $itemsPerPage);
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
                    <?php foreach ($currentPageStudents as $student): 
                        $totalFee = $student->class_id != null ? $classController->readClass($student->class_id)->total_fee : 0;
                        $remainingFee = $student->remaining_fee;
                        $status = $totalFee == 0 ? 'No Fee Data' : ($remainingFee == 0 ? 'Paid' : ($remainingFee < $totalFee ? 'Partial' : 'Unpaid'));
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
                        <td><?php echo $status; ?></td>
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
            <?php if (count($students) > 5): ?>
    <div class="navigation">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>" id="prevPage" class="nav-button prev-button" data-translate="previous">
                <i class="fas fa-chevron-left"></i>
            </a>
        <?php endif; ?>
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>" id="nextPage" class="nav-button next-button" data-translate="next">
                 <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
