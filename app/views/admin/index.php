<?php

use App\Config\Database;
use App\Controllers\BulletinController;
use App\Controllers\ClassController;
use App\Controllers\GradeController;
use App\Controllers\PaymentController;
use App\Controllers\StudentCardController;
use App\Controllers\StudentController;
use App\Controllers\SubjectController;
use App\Controllers\TeacherController;





$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$studentController = new StudentController($db);
$teacherController = new TeacherController($db);
$gradeController = new GradeController($db);
$paymentController = new PaymentController($db);
$studentCardController = new StudentCardController($db);
$bulletinController = new BulletinController($db);
$classController = new ClassController($db);
$subjectController = new SubjectController($db);



// Récupérer les statistiques
$totalStudents = count($studentController->readAllStudents());
$totalTeachers = count($teacherController->readAllTeachers());
$totalClasses = count($classController->readAllClasses());
$totalSubjects = count($subjectController->readAllSubjects());
$totalGrades = count($gradeController->readAllGrades());
$totalPayments = count($paymentController->readAllPayments());
$totalStudentCards = count($studentCardController->readAllStudentCards());
$totalBulletins = count($bulletinController->readAllBulletins());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>keyce Management</title>
    <link rel="icon" href="../images/Keyce_logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class="dashboard">
    <main class="content">
        <div class="dashboard-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-user-graduate"></i>
                    <h2 data-translate="total_students">Total Students</h2>
                    <p><?php echo $totalStudents; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h2 data-translate="total_teachers">Total Teachers</h2>
                    <p><?php echo $totalTeachers; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-book"></i>
                    <h2 data-translate="total_subjects">Total Subjects</h2>
                    <p><?php echo $totalSubjects; ?></p>
                </div>
                <div class="stat-card">
                <i class="fas fa-calendar-alt"></i>
                    <h2 data-translate="total_classes">Total Classes</h2>
                    <p><?php echo $totalClasses; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h2 data-translate="total_bull">Total Bulletins</h2>
                    <p><?php echo $totalBulletins; ?></p>
                </div>
                <div class="stat-card">
                <i class="fa-solid fa-credit-card"></i>
                    <h2 data-translate="total_payments">Total Payments</h2>
                    <p><?php echo $totalPayments; ?></p>
                </div>
            </div>
            <!-- <div class="charts-container">
                <div class="chart">
                    <h3 data-translate="student_enrollment">Student Enrollment</h3>
                    <canvas id="enrollmentChart"></canvas>
                </div> -->
                <!-- <div class="chart">
                    <h3 data-translate="performance_overview">Performance Overview</h3>
                    <canvas id="performanceChart"></canvas>
                </div> -->
            </div>
        </div>
    </main>
</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script.js"></script>
</body>
</html>
