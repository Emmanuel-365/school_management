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


$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$paymentController = new PaymentController($db);
$studentController = new StudentController($db);
$parentController = new ParentController($db);
$classController = new ClassController($db);

if(isset($_GET['student_id'])){
    $student = $studentController->readStudent($_GET['student_id']);
    $remaining_fee = $student->remaining_fee;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'student_id' => $_POST['student_id'],
            'amount' => $_POST['amount'],
            'payment_date' => $_POST['payment_date'],
            'remaining_fee' => $_POST['remaining_fee'],
        ];

        try {
            $payment = $paymentController->createPayment($data);
            $remaining_fee_previous = $studentController->readStudent($_POST['student_id'])->remaining_fee;
            $remaining_fee_next = $remaining_fee_previous - $_POST['amount'];
            $studentController->updateStudent($_POST['student_id'], ["remaining_fee" => $remaining_fee_next]);

            // Générer le reçu et envoyer par e-mail
            sendPaymentReceipt($payment, $student);

            header("Location: /students");
            exit;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
} else {
    echo "error";
}

function sendPaymentReceipt($payment, $student) {
    global $parentController, $classController;
    
    $parent = $parentController->readParent($student->parent_id);
    $class = $classController->readClass($student->class_id);
    
    // Générer le QR code
    $qrCode = new QrCode('Signature numérique pour le paiement #' . $payment->id);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    $qrCodeImage = $result->getDataUri();

    // Préparer les données pour le template
    $data = [
        'schoolLogo' => 'chemin/vers/logo.png', // Remplacer par le chemin réel du logo
        'schoolName' => 'Nom de l\'École', // Remplacer par le nom réel de l'école
        'receiptNumber' => $payment->id,
        'studentName' => $student->first_name . ' ' . $student->last_name,
        'studentId' => $student->id,
        'studentClass' => $class ? $class->name : 'Non spécifiée',
        'paymentDate' => $payment->payment_date,
        'amountPaid' => $payment->amount,
        'remainingBalance' => $student->remaining_fee,
        'qrCodeImage' => $qrCodeImage
    ];

    // Générer le contenu HTML du reçu
    ob_start();
    extract($data);
    include 'payment_receipt_template.php';
    $htmlContent = ob_get_clean();

    // Configurer PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Remplacer par votre serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'nguetsajunior@gmail.com'; // Remplacer par votre email
        $mail->Password = 'hcaenfisaltkngcf'; // Remplacer par votre mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('nguetsajunior@gmail.com', 'Keyce Institute');
        $mail->addAddress($student->email, $student->first_name . ' ' . $student->last_name);
        $mail->addCC($parent->email, $parent->first_name . ' ' . $parent->last_name);

        $mail->isHTML(true);
        $mail->Subject = 'Reçu de Paiement - ' . $payment->payment_date;
        $mail->Body = $htmlContent;

        $mail->send();
        echo 'Le reçu a été envoyé par e-mail avec succès.';
    } catch (Exception $e) {
        echo "L'envoi du reçu par e-mail a échoué. Erreur: {$mail->ErrorInfo}";
    }
}
?>

<h3>Adding Payment page</h3>
<form method="POST" action="">
    <input type="text" id="student_id" name="student_id" value="<?=$_GET['student_id'] ?>" hidden>

    <div class="form-row">
        <div class="form-group">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="1" required max="<?=$remaining_fee?>">
        <div class="error-message"></div>
        </div>
        <div class="form-group">
        <label for="payment_date">Payment Date:</label>
        <input type="date" id="payment_date" name="payment_date" required>
        </div>
    </div>
    <div class="from-row">
        <div class="form-group">
            <label for="remaining_fee">Remaining Fee:</label>
            <input type="number" id="remaining_fee" name="remaining_fee" value="<?php echo isset($student) ? $student->remaining_fee : ''; ?>" required>
        </div>
    </div>
    <center>
        <div class="form-group center">
           <button type="submit">Add Payment</button>
        </div>
    </center>
</form>