<?php
header('Content-Type: application/json');
use App\Controllers\BulletinController;
use App\COnfig\Database;

$database = new Database();
$db = $database->getConnection();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification de la méthode de requête
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
    exit;
}

// Vérifiez si le fichier PDF est bien reçu
if (!isset($_FILES['pdf']) || !isset($_POST['bulletinId'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Aucun fichier PDF ou aucun id de bulletin reçu.']);
    exit;
}

$bulletinId = $_POST['bulletinId'];

// Traiter le fichier PDF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    // Charger le fichier PDF
    $uploadedFile = $_FILES['pdf']['tmp_name'];
    $outputPath = __DIR__ . '/../../../public/uploads/bulletin_signed.pdf';

    // Lire le contenu du fichier PDF
    $pdfContent = file_get_contents($uploadedFile);
    if (!$pdfContent) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Impossible de lire le contenu du fichier PDF.']);
        exit;
    }

    // Enregistrer le fichier sur le serveur
    file_put_contents($outputPath, $pdfContent);

    // Générer un hash (SHA-256 recommandé)
    $hash = hash('sha256', $pdfContent);

    // Appeler la méthode du BulletinController pour sauvegarder le hash dans la base de données
    $controller = new BulletinController($db);

    if ($controller->updateBulletin($bulletinId, ['hashes' => $hash])) {
        // Réponse JSON avec le lien de téléchargement
        $fileUrl = '/uploads/bulletin_signed.pdf';
        echo json_encode(['success' => true, 'file_url' => $fileUrl]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la sauvegarde du hash.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}
