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
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/student_styles.css">
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
                    <!-- <div class="search-bar">
                        <input type="text" placeholder="Search...">
                        <button><i class="fas fa-search"></i></button>
                    </div> -->
                    <div class="user-info">
                        <img 
                            class="profile-picture" 
                            src="<?= htmlspecialchars($user->profile_picture ?? '/images/profiles/default_profile.jpg'); ?>" 
                            alt="Photo de profil">                        
                        <span><?=$user->username?></span>
                    </div>
                </header>