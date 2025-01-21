<?php
use App\Config\Database;
use App\Controllers\PaymentController;
use App\Controllers\StudentController;
use App\Controllers\ParentController;
use App\Controllers\ClassController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Spipu\Html2Pdf\Html2Pdf;

// Initialisation de la base de données et des contrôleurs
$database = new Database();
$db = $database->getConnection();

$paymentController = new PaymentController($db);
$studentController = new StudentController($db);
$parentController = new ParentController($db);
$classController = new ClassController($db);

// Vérification de l'ID de l'étudiant
if (isset($_GET['student_id'])) {
    $student = $studentController->readStudentWithUsersInformations($_GET['student_id']);
    $remaining_fee = $student->remaining_fee;

    // Traitement du formulaire de paiement
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'student_id' => $_POST['student_id'],
            'amount' => $_POST['amount'],
            'remaining_fee' => $_POST['remaining_fee'],
        ];

        try {
            // Création du paiement et mise à jour du solde de l'étudiant
            $payment_id = $paymentController->createPayment($data);
            $payment = $paymentController->readPayment($payment_id);

            // Génération du reçu et envoi par e-mail
            sendPaymentReceipt($payment, $student);

            // Redirection après l'enregistrement du paiement
            header("Location: /students");
            exit;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }
} else {
    echo "Erreur: Identifiant étudiant manquant.";
}

/**
 * Fonction pour envoyer le reçu de paiement par e-mail
 */
function sendPaymentReceipt($payment, $student) {
    global $parentController, $classController;

    $parent = $parentController->readParent($student->parent_id);
    $class = $classController->readClass($student->class_id);

    // Créer une nouvelle instance de TCPDF
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Définir les métadonnées du document
    $pdf->SetCreator('Keyce Institute');
    $pdf->SetAuthor('Keyce Institute');
    $pdf->SetTitle('Reçu de Paiement');
    $pdf->SetSubject('Reçu de Paiement');
    $pdf->SetKeywords('Reçu, Paiement, Keyce');

    // Ajouter une page
    $pdf->AddPage();

    // Définir les marges
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);

    // Couleurs personnalisées
    $primaryColor = array(0, 102, 204); // Bleu
    $secondaryColor = array(255, 102, 0); // Orange
    $backgroundColor = array(245, 245, 245); // Gris clair

    // Ajouter un logo
    $logoPath = __DIR__ . '/uploads/keyce_logo.png'; // Chemin du logo
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 15, 10, 30, 0, 'PNG');
    }

    // Titre du document
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
    $pdf->Cell(0, 10, 'Reçu de Paiement', 0, 1, 'C');
    $pdf->Ln(10);

    // Informations de l'étudiant
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->SetTextColor(0, 0, 0); // Noir
    $pdf->Cell(0, 10, 'Informations de l\'Étudiant', 0, 1);
    $pdf->SetFont('helvetica', '', 12);

    // Tableau pour les informations de l'étudiant
    $pdf->SetFillColor($backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);
    $pdf->SetDrawColor(200, 200, 200); // Gris clair pour les bordures
    $pdf->Cell(40, 10, 'Nom', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $student->first_name . ' ' . $student->last_name, 1, 1, 'L', 1);
    $pdf->Cell(40, 10, 'Classe', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, ($class ? $class->name : 'Non spécifiée'), 1, 1, 'L', 1);
    $pdf->Cell(40, 10, 'ID Étudiant', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $student->id, 1, 1, 'L', 1);
    $pdf->Ln(10);

    // Informations du paiement
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Détails du Paiement', 0, 1);
    $pdf->SetFont('helvetica', '', 12);

    // Tableau pour les détails du paiement
    $pdf->SetFillColor($backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);
    $pdf->Cell(60, 10, 'Numéro de Reçu', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $payment->id, 1, 1, 'L', 1);
    $pdf->Cell(60, 10, 'Date de Paiement', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $payment->created_at, 1, 1, 'L', 1);
    $pdf->Cell(60, 10, 'Montant Payé', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $payment->amount . ' FCFA', 1, 1, 'L', 1);
    $pdf->Cell(60, 10, 'Solde Restant', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, ($student->remaining_fee - $payment->amount) . ' FCFA', 1, 1, 'L', 1);
    $pdf->Ln(20);

    // Message de remerciement
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->SetTextColor($secondaryColor[0], $secondaryColor[1], $secondaryColor[2]);
    $pdf->Cell(0, 10, 'Merci pour votre confiance !', 0, 1, 'C');

    // Sauvegarder le PDF
    $pdfFilePath = __DIR__ . '/receipts/payment_receipt_' . $payment->id . '.pdf';
    $pdf->Output($pdfFilePath, 'F');

    // Envoyer le PDF par e-mail avec PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nguetsajunior@gmail.com';
        $mail->Password = 'hcaenfisaltkngcf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('nguetsajunior@gmail.com', 'Keyce Institute');
        $mail->addAddress('emmanuelscre1@gmail.com', $parent->first_name . ' ' . $parent->last_name);
        $mail->addCC($student->email, $student->first_name . ' ' . $student->last_name);

        // Ajouter le PDF en pièce jointe
        $mail->addAttachment($pdfFilePath, 'Reçu_Paiement_' . $payment->id . '.pdf');

        $mail->isHTML(true);
        $mail->Subject = 'Reçu de Paiement - ' . $payment->created_at;
        $mail->Body = 'Veuillez trouver en pièce jointe le reçu de votre paiement.';

        $mail->send();
        echo 'Le reçu a été envoyé par e-mail avec succès.';
    } catch (Exception $e) {
        echo "L'envoi du reçu par e-mail a échoué. Erreur: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un paiement</title>
    <style>
        /* Styles pour le spinner */
        .spinner {
            display: none; /* Masqué par défaut */
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #1e40af; /* Couleur primaire */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-message {
            display: none; /* Masqué par défaut */
            text-align: center;
            font-size: 16px;
            color: #1e40af; /* Couleur primaire */
            margin-top: 10px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h3>Ajouter un paiement</h3>
    <form method="POST" action="" onsubmit="showLoading()">
        <input type="hidden" id="student_id" name="student_id" value="<?= $_GET['student_id'] ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="amount">Montant:</label>
                <input type="number" id="amount" name="amount" step="1" required max="<?= $remaining_fee ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="remaining_fee">Frais Restants:</label>
                <input type="number" id="remaining_fee" name="remaining_fee" value="<?= $student->remaining_fee ?>" required>
            </div>
        </div>

        <div class="form-group text-center">
            <button type="submit">Ajouter un paiement</button>
        </div>

        <!-- Spinner et message de chargement -->
        <div class="spinner" id="spinner"></div>
        <div class="loading-message" id="loadingMessage">Génération du reçu en cours...</div>
        <div class="error-message" id="errorMessage"></div>
    </form>

    <script>
        function showLoading() {
            // Afficher le spinner et le message de chargement
            document.getElementById('spinner').style.display = 'block';
            document.getElementById('loadingMessage').style.display = 'block';
            document.getElementById('errorMessage').textContent = ''; // Réinitialiser le message d'erreur
        }
    </script>
</body>
</html>