<?php

use setasign\Fpdi\TcpdfFpdi;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 300); // Set to 300 seconds (5 minutes)

// Fonction pour signer le PDF
function signerPDF($inputPdf, $outputPdf)
{
    $certificate = file_get_contents('../app/config/Keyce_certificate.crt');
    $privateKey = file_get_contents('../app/config/private.pem');
    $password = ''; // Si la clé privée a un mot de passe, l'indiquer ici

    if (!$certificate || !$privateKey) {
        throw new Exception("Certificat ou clé privée introuvable.");
    }

    $pdf = new TcpdfFpdi();

    // Charger le PDF existant
    $pageCount = $pdf->setSourceFile($inputPdf);
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $pdf->AddPage();
        $pdf->useTemplate($templateId);
    }

    // Configurer la signature numérique
    $pdf->setSignature(
        $certificate,
        $privateKey,
        $password,
        '',
        2,
        [
            'Name' => 'Keyce Informatique & IA',
            'Location' => 'Campus l\'atelier, Yaoundé, Titi Garage',
            'Reason' => 'Document de verification d\'authenticité',
            'ContactInfo' => 'nguetsajunior@gmail.com'
        ]
    );

    // Ajouter une image de signature visible
    $pdf->Image('/images/signature.png', 140, 230, 55, 44, 'PNG');
    $pdf->setSignatureAppearance(140, 230, 55, 44);

    // Sauvegarder le PDF signé
    $pdf->Output($outputPdf, 'F');
}

// Fonction pour envoyer le bulletin signé par e-mail
function sendEmail($studentEmail, $parentEmail, $pdfData) {
    // Vérifier si toutes les données nécessaires sont présentes
    if (!$studentEmail || !$parentEmail || !$pdfData) {
        return ['success' => false, 'message' => 'Données manquantes.'];
    }

    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->SMTPDebug = 2; // Affiche les détails de la connexion
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nguetsajunior@gmail.com';  // À remplacer par un email valide
        $mail->Password = 'hcaenfisaltkngcf';     // À remplacer par un mot de passe valide
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom('nguetsajunior@gmail.com', 'Keyce Institute');
        $mail->addAddress($studentEmail); // Email de l'étudiant
        $mail->addCC($parentEmail);       // Email du parent

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Votre Bulletin de Notes';
        $mail->Body = '<p>Bonjour cher étudiant,<br>Veuillez trouver en pièce jointe votre bulletin de notes.<br><br>Keyce Institute vous remercie pour votre confiance.</p>';
        $mail->AltBody = 'Bonjour cher parent,\nVeuillez trouver en pièce jointe le bulletin de notes de votre enfant.\nKeyce Institute vous remercie pour votre confiance.';

        // Ajout du PDF en pièce jointe
        $mail->addAttachment($pdfData, 'bulletin.pdf');

        // Envoi
        $mail->send();

        return ['success' => true, 'message' => 'Bulletin envoyé avec succès !'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => "Erreur : {$mail->ErrorInfo}"];
    }
}

// Traitement de la requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputPdf = $_FILES['pdf']['tmp_name'] ?? null;
    $studentEmail = $_POST['student_email'] ?? null;
    $parentEmail = $_POST['parent_email'] ?? null;
    if (!$inputPdf || !$studentEmail || !$parentEmail) {
        echo json_encode(['success' => false, 'message' => 'Données manquantes pour la signature et l\'envoi.']);
        exit;
    }


    $signedPdfPath = __DIR__ . '/../../../public/uploads/bulletin_signed.pdf';

    try {
        // Signer le PDF
        signerPDF($inputPdf, $signedPdfPath);

        // Envoyer le PDF signé par e-mail
        $emailResponse = sendEmail($studentEmail, $parentEmail, $signedPdfPath);

        if (!isset($emailResponse['success']) || !$emailResponse['success']) {
            throw new Exception($emailResponse['message'] ?? 'Erreur inconnue lors de l\'envoi de l\'e-mail.');
        }

        echo json_encode([
            'success' => true,
            'message' => 'Bulletin signé et envoyé avec succès.',
            'file_url' => $signedPdfPath
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
