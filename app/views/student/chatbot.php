<?php

use App\Config\Database;
use App\Controllers\ClassController;
use App\Controllers\StudentController;
use App\Controllers\GradeController;
use App\Controllers\SubjectController;
use App\Controllers\ChatbotGemini;

header('Content-Type: application/json');

// Activer la journalisation des erreurs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Vérifier la méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

// Récupérer et vérifier les données
try {
    $rawData = file_get_contents('php://input');
    error_log("Données reçues: " . $rawData); // Log des données reçues

    $data = json_decode($rawData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Données JSON invalides: ' . json_last_error_msg());
    }

    if (!isset($data['message'])) {
        throw new Exception('Message manquant dans la requête');
    }

    $database = new Database();
    $db = $database->getConnection();

    // Vérifier l'authentification
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Utilisateur non authentifié');
    }

    $studentController = new StudentController($db);
    $classController = new ClassController($db);
    $gradeController = new GradeController($db);
    $subjectController = new SubjectController($db);

    // Récupérer l'ID de l'étudiant
    $student_id = $database->isStudent() ? $_SESSION['user_id'] : ($_GET['student_id'] ?? null);
    if (!$student_id) {
        throw new Exception('ID étudiant non disponible');
    }

    // Initialiser le chatbot avec la clé API
    $GeminiApiKey = 'AIzaSyB-y75gkmiaLjnmN0xSDypMWuCzlTEQsT4'; // Votre Clé API Gemini

    if (empty($GeminiApiKey)) {
        throw new Exception('Clé API Gemini non configurée');
    }

    $chatbot = new ChatbotGemini($GeminiApiKey);

    // Récupérer les informations de l'étudiant
    $student = $studentController->readStudentWithUsersInformations($student_id);
    if (!$student) {
        throw new Exception('Étudiant non trouvé');
    }

    $niveau = $classController->readClass($student->class_id)->level;

    // Récupérer et calculer les notes
    $grades = $gradeController->readAllGradesByStudent($student_id);
    if (empty($grades)) {
        throw new Exception('Aucune note disponible');
    }

    // Préparer les données pour le chatbot
    $studentData = [
        'name' => $student->first_name . ' ' . $student->last_name,
        'level' => $niveau,
        'grades' => []
    ];

    foreach ($grades as $grade) {
        $subject_id = $grade->subject_id;
        $subject = $subjectController->readSubject($subject_id);
        if (!$subject) {
            error_log("Matière non trouvée pour l'ID: " . $subject_id);
            continue;
        }

        $gradeValue = floatval($grade->grade);
        if (!isset($studentData['grades'][$subject_id])) {
            $studentData['grades'][$subject_id] = [
                'subject' => $subject->name,
                'total' => 0,
                'count' => 0
            ];
        }
        $studentData['grades'][$subject_id]['total'] += $gradeValue;
        $studentData['grades'][$subject_id]['count']++;
    }

    // Calculer les moyennes
    $finalGrades = [];
    foreach ($studentData['grades'] as $subjectId => $gradeData) {
        $average = $gradeData['total'] / $gradeData['count'];
        $finalGrades[] = [
            'subject' => $gradeData['subject'],
            'grade' => number_format($average, 2)
        ];
    }
    $studentData['grades'] = $finalGrades;

    // Obtenir la réponse du chatbot
    try {
        $response = $chatbot->getResponse($data['message'], $studentData, true); // Ajout d'un paramètre pour désactiver SSL
        echo json_encode(['response' => $response]);
    } catch (Exception $e) {
        error_log("Erreur Chatbot: " . $e->getMessage());
        echo json_encode([
            'error' => 'Erreur lors de la génération de la réponse',
            'details' => $e->getMessage()
        ]);
    }

} catch (Exception $e) {
    error_log("Erreur API Chatbot: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Une erreur est survenue',
        'message' => $e->getMessage()
    ]);
}
