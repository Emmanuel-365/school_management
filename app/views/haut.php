<?php

use App\Config\Database;
use App\Controllers\UserController;

$database = new Database();
$db = $database->getConnection();

$userController = new UserController($db);
$user = $userController->readUser($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Keyce Management</title>
    <link rel="icon" href="../images/Keyce_logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/student_styles.css">
    <link rel="stylesheet" href="/css/chatbot.css">
    <!-- pour le PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</head>

<body>

    <div class="dashboard">
        <?php if ($database->isAdmin()): ?>
            <?php include_once '../app/views/layouts/sidebar_admin.php' ?>
        <?php elseif ($database->isStudent()): ?>
            <?php include_once '../app/views/layouts/sidebar_student.php' ?>
        <?php elseif ($database->isTeacher()): ?>
            <?php include_once '../app/views/layouts/sidebar_teacher.php' ?>
        <?php endif; ?>

        <div class="content">
            <header>
                <button id="sidebarToggle"><i class="fas fa-bars"></i></button>
                <div class="language-selector">
                    <!-- Conteneur du drapeau sélectionné -->
                    <div class="flag-container">
                        <!-- <img id="selected-flag" src="/images/flags/en.png" alt="English"> -->
                    </div>

                    <!-- Sélecteur de langue -->
                    <select id="language-select">
                        <option value="en" data-flag="/images/flags/en.png">English</option>
                        <option value="fr" data-flag="/images/flags/fr.png">Français</option>
                    </select>
                </div>
                <div class="user-info">
                    <img class="profile-picture"
                        src="<?= htmlspecialchars($user->profile_picture ?? '/images/profiles/default_profile.jpg'); ?>"
                        alt="Photo de profil">
                    <span><?= $user->first_name . ' ' . $user->last_name ?></span>
                    <div class="user-dropdown">
                        <a href="/change-password">Change profile information</a>
                    </div>
                </div>
            </header>
