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
$classController = new ClassController($db);
$subjectController = new SubjectController($db);
$gradeController = new GradeController($db);
$paymentController = new PaymentController($db);
$studentCardController = new StudentCardController($db);
$bulletinController = new BulletinController($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>keyce management</title>
    <link rel="icon" href="../images/Keyce_logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../student_style.css">

</head>
<body>
    <div class="dashboard">
        <main class="content">
                <div class="dashboard-content">
                <h1>Welcome to your Student Management Side</h1>
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-user-graduate"></i>
                        <h3>Total moyenne</h3>
                        <p>1,234</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <h3>Total des sous moyennes</h3>
                        <p>56</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-book"></i>
                        <h3>Total Courses</h3>
                        <p>78</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>pourcentage de reussite</h3>
                        <p>95%</p>
                    </div>
                </div>
                <div class="charts-container">
                    <div class="chart">
                        <h3>Student Enrollment</h3>
                        <canvas id="enrollmentChart"></canvas>
                    </div>
                    <div class="chart">
                        <h3>Performance Overview</h3>
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script.js"></script>
    <script src="../student_script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js">
    </script>
</body>
</html>