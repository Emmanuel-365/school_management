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
    <title data-translate="page_title">keyce management</title>
    <link rel="icon" href="../images/Keyce_logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../student_style.css">
</head>

<body>
    <div class="dashboard">
        <main class="content">
            <div class="dashboard-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-user-graduate"></i>
                        <h3 data-translate="total_average">Total moyenne</h3>
                        <p>4</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <h3 data-translate="total_sub_averages">Total des sous moyennes</h3>
                        <p>5</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-book"></i>
                        <h3 data-translate="total_courses">Total Courses</h3>
                        <p>7</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h3 data-translate="success_rate">Pourcentage de réussite</h3>
                        <p>95%</p>
                    </div>
                </div>
                <div class="charts-container">
                    <div class="chart">
                        <h3 data-translate="student_enrollment">Inscription des étudiants</h3>
                        <canvas id="enrollmentChart"></canvas>
                    </div>
                    <div class="chart">
                        <h3 data-translate="performance_overview">Aperçu des performances</h3>
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
        <div id="chatbot-container" class="chatbot-closed">
            <div id="chatbot-header">
                <h3 data-translate="student_assistant"><i class="fas fa-robot"></i> Assistant Étudiant</h3>
                <button id="close-chatbot"><i class="fas fa-times"></i></button>
            </div>
            <div id="chat-messages"></div>
            <form id="chat-form">
                <input type="text" id="user-input" placeholder="Posez votre question ici..." autocomplete="off" data-translate="ask_question">
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
        <button id="open-chatbot" class="chatbot-toggle" data-translate="need_help">
            <i class="fas fa-comments"></i> Besoin d'aide ?
        </button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script.js"></script>
    <script src="../student_script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</body>

</html>