<?php

use App\Config\Database;
// Supposons que vous avez déjà des instances de vos modèles et contrôleurs
use App\Controllers\ClassController;
use App\Controllers\StudentController;
use App\Controllers\SubjectController;
use App\Controllers\GradeController;

$database = new Database();
$db = $database->getConnection();

$studentController = new StudentController($db);
$subjectController = new SubjectController($db);
$gradeController = new GradeController($db);
$classController = new ClassController($db);

// Récupérer tous les étudiants avec leurs classes
$students = $studentController->readAllStudents();


// Pour chaque étudiant
foreach ($students as $student) {
    // Récupérer le niveau de la classe de l'étudiant
    $classLevel = $classController->readClass($student->class_id)->level;

    // Récupérer les matières correspondant au niveau de la classe
    $subjects = $subjectController->readSubjectByLevel($classLevel);

    // Pour chaque matière correspondante
    foreach ($subjects as $subject) {
        // Générer les notes pour cc, tp et exam
        $cc = rand(0, 20); // Note de contrôle continu
        $tp = rand(0, 20); // Note de travaux pratiques
        $exam = rand(0, 20); // Note d'examen

        // Insérer les notes cc, tp et exam
        $gradeController->createGrade([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => $cc,
            'type_note' => 'cc',
        ]);

        $gradeController->createGrade([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => $tp,
            'type_note' => 'tp',
        ]);

        $gradeController->createGrade([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => $exam,
            'type_note' => 'exam',
        ]);

        // Vérifier si l'étudiant a une note d'exam inférieure à 12
        if ($exam < 12) {
            // Générer une note de rattrapage (optionnelle)
            $rattrapage = rand(1, 20); // Note de rattrapage

            // Insérer la note de rattrapage
            $gradeController->createGrade([
                'student_id' => $student->id,
                'subject_id' => $subject->id,
                'grade' => $rattrapage,
                'type_note' => 'rattrapage',
            ]);
        }
    }
}

echo "Remplissage des notes terminé avec succès !";