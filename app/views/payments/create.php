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
            $remaining_fee_previous = $studentController->readStudent($_POST['student_id'])->remaining_fee;
            $remaining_fee_next = $remaining_fee_previous - $_POST['amount'];
            $studentController->updateStudent($_POST['student_id'], ["remaining_fee" => $remaining_fee_next]);

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

    // Génération du QR Code
    $qrCode = new QrCode('Signature numérique pour le paiement #' . $payment->id);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    $qrCodeImage = $result->getDataUri();

    // Données pour le template HTML
    $data = [
        'schoolLogo' => '/uploads/keyce_logo.png', // Chemin du logo
        'schoolName' => 'Nom de l\'École', // Nom de l'école
        'receiptNumber' => $payment->id,
        'studentName' => $student->first_name . ' ' . $student->last_name,
        'studentId' => $student->id,
        'studentClass' => $class ? $class->name : 'Non spécifiée',
        'paymentDate' => $payment->created_at,
        'amountPaid' => $payment->amount,
        'remainingBalance' => $student->remaining_fee,
        'qrCodeImage' => $qrCodeImage
    ];

    // Générer le contenu HTML du reçu
    ob_start();
    extract($data);
    include 'payment_receipt_template.php';
    $htmlContent = ob_get_clean();

    // Générer le PDF avec html2pdf
    $pdfFilePath = __DIR__ . '/receipts/payment_receipt_' . $payment->id . '.pdf';
    try {
        $html2pdf = new Html2Pdf('P', 'A4', 'fr');
        $html2pdf->writeHTML($htmlContent);
        file_put_contents('debug_output.html', $htmlContent); // Debugging (optionnel)
        $html2pdf->output($pdfFilePath, 'F'); // Sauvegarde le PDF
    } catch (Exception $e) {
        echo 'Erreur lors de la génération du PDF : ' . $e->getMessage();
        return;
    }

    // Configuration de l'envoi par e-mail avec PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'nguetsajunior@gmail.com'; // Email de l'expéditeur
        $mail->Password = 'hcaenfisaltkngcf'; // Mot de passe de l'expéditeur
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

<h3>Ajouter un paiement</h3>
<form method="POST" action="">
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
</form>
