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

// Récupérer toutes les classes
$classes = $classController->readAllClasses();

// Récupérer les rangs et moyennes pour chaque classe
$classRanks = [];
foreach ($classes as $class) {
    $classRanks[$class->id] = $classController->getClassRanksAndAverages($class->id);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement des étudiants par classe</title>
    <style>
        /* Style de base pour les tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #1e40af;
        }

        /* Style pour les listes déroulantes */
        .accordion {
            background-color: #f8f9fa;
            color: #333;
            cursor: pointer;
            padding: 15px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            border-radius: 10px;
        }

        .accordion:hover {
            background-color: #1e40af;
        }

        .accordion.active {
            background-color: #1e40af;
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
    </style>
</head>
<body>
    <h1>Classement des étudiants par classe</h1>

    <?php foreach ($classes as $class): ?>
        <button class="accordion">Classe : <?= htmlspecialchars($class->name) ?></button>
        <div class="panel">
            <table>
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Moyenne</th>
                        <th>Rang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($classRanks[$class->id])): ?>
                        <?php foreach ($classRanks[$class->id] as $rank): ?>
                            <?php
                            $student = $studentController->readStudentWithUsersInformations($rank['student_id']);
                            $studentName = $student ? $student->first_name . ' ' . $student->last_name : 'Inconnu';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($studentName) ?></td>
                                <td><?= number_format($rank['weighted_average'], 2) ?></td>
                                <td><?= $rank['rank_in_class'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Aucun étudiant trouvé pour cette classe.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

    <script>
        // Script pour gérer les listes déroulantes
        const accordions = document.querySelectorAll('.accordion');

        accordions.forEach(accordion => {
            accordion.addEventListener('click', function() {
                // Fermer tous les autres panneaux
                accordions.forEach(otherAccordion => {
                    if (otherAccordion !== this) {
                        otherAccordion.classList.remove('active');
                        otherAccordion.nextElementSibling.style.maxHeight = null;
                    }
                });

                // Ouvrir ou fermer le panneau actuel
                this.classList.toggle('active');
                const panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                }
            });
        });
    </script>
</body>
</html>