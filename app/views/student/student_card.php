<?php 

use App\Config\Database;
use App\Controllers\ClassController;
use App\Controllers\StudentCardController;
use App\Controllers\StudentController;

$database = new Database();
$db = $database->getConnection();
$studentController = new StudentController($db);
$classController = new ClassController($db);
$studentCardController = new StudentCardController($db);

if($database->isStudent()){
    $student_id = $_SESSION['user_id'];
}elseif($database->isAdmin()){
    $student_id = $_GET['student_id'];
}
$student = $studentController->readStudentWithUsersInformations($student_id);
$niveau = $classController->readClass($student->class_id)->level;
$studentCard = $studentCardController->readStudentCardByStudent($student_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>keyce management</title>
    <link rel="icon" href="../images/Keyce_logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/student_style.css">

</head>
<body>
    <div class="dashboard">
        <main class="content">
<div class="containerParent">
    <div class="carde-container">
        <div class="carde">
            <div class="carde-front">
                <div class="school-name">Keyce Informatique & IA</div>
                <div class="student-info">
                    <img src="<?= htmlspecialchars($user->profile_picture ?? '/images/profiles/default_profile.jpg'); ?>" alt="Student Photo" class="student-photo">
                    <div class="info">
                        <p><strong>Name:</strong> <?=$student->first_name . ' ' . $student->last_name ?></p>
                        <p><strong>Date of Birth:</strong> <?=$student->date_of_birth ?></p>
                        <p><strong>Niveau:</strong> <?=$niveau?></p>
                        <p><strong>Email:</strong> <?=$student->email?></p>
                        <p><strong>Valid Until:</strong> <?=$studentCard->expiry_date??'29/12/2025' ?></p>
                    </div>
                </div>
                <div class="carde-number">Matricule: <?=$student->matricule?></div>
            </div>
            <div class="carde-back">
                <div class="school-logo">
                    <center><img src="../images/Keyce_logo.png" alt=""></center>
                </div>
                <div class="sim-card">
                    <img src="../images/sim_card.png" alt="">
                </div>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> Campus l'atelier, Yaoundé, Titi Garage</p>
                    <p><i class="fas fa-envelope"></i> africa@keyce-informatique.fr</p>
                    <p><i class="fas fa-phone"></i> (+237) 659 42 33 35</p>
                </div>
            </div>
        </div>
    </div>

    <div class="download-button">
       
            <button id="download-pdf">
                <i class="fas fa-download"></i> Télécharger la carte d'étudiant
            </button>
        
    </div>
</div>
<?php  ?>