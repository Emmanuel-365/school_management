<?php
// Supposons que la session ait été démarrée ailleurs dans le projet

use App\Config\Database;
use App\Controllers\ClassController;
use App\Controllers\ParentController;
use App\Controllers\StudentController;

$database = new Database() ;
$db = $database->getConnection() ;
// Récupérer l'ID utilisateur depuis la session
$user_id = $_SESSION['user_id'] ?? null;

// Vérifier si l'utilisateur est connecté et récupérer les données de l'étudiant
$student = null;
if ($user_id) {
    $studentController = new StudentController($db);
    $student = $studentController->readStudentWithUsersInformations($user_id);
    $classController = new ClassController( $db );
    $parentController = new ParentController( $db );
    $class = $classController->readClass($student->class_id)->name;
    $parent = $parentController->readParent($student->parent_id)->first_name . ' ' . $parentController->readParent($student->parent_id)->last_name;
}

if (!$student) {
    echo "<p>Erreur : Étudiant introuvable ou non connecté.</p>";
    exit;
}
?>

<div class="dashboard">
    <div class="content">
        <div class="dashboard-content">
            <h3>Profil Étudiant</h3>
            <div class="profile-card">
            <img 
                    class="profile-picture" 
                    src="<?= htmlspecialchars($student->profile_picture ?? '/images/profiles/default_profile.jpg'); ?>" 
                    alt="Photo de profil">
                <h2><?= htmlspecialchars($student->first_name . ' ' . $student->last_name); ?></h2>
                <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($student->username); ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($student->email); ?></p>
                <p><strong>Téléphone :</strong> <?= htmlspecialchars($student->phone); ?></p>
                <p><strong>Classe :</strong> <?= htmlspecialchars($class); ?></p>
                <p><strong>Matricule :</strong> <?= htmlspecialchars($student->matricule); ?></p>
                <p><strong>Date de naissance :</strong> <?= htmlspecialchars($student->date_of_birth); ?></p>
                <p><strong>Adresse :</strong> <?= htmlspecialchars($student->address); ?></p>
                <p><strong>Parent :</strong> <?= htmlspecialchars($parent); ?></p>
                <p><strong>Frais restants :</strong> $<?= htmlspecialchars($student->remaining_fee); ?></p>
                <p><strong>Date d'inscription :</strong> <?= htmlspecialchars($student->registration_date); ?></p>
            </div>
        </div>
    </div>
</div>
<div id="chatbot-container" class="chatbot-closed">
        <div id="chatbot-header">
            <h3><i class="fas fa-robot"></i> Assistant Étudiant</h3>
            <button id="close-chatbot"><i class="fas fa-times"></i></button>
        </div>
        <div id="chat-messages"></div>
        <form id="chat-form">
            <input type="text" id="user-input" placeholder="Posez votre question ici...">
            <button type="submit"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
    <button id="open-chatbot" class="chatbot-toggle">
        <i class="fas fa-comments"></i> Besoin d'aide ?
    </button>
