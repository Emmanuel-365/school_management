<?php
set_time_limit(60); // 60 secondes

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// Exemple d'utilisation :
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentEmail = $_POST['student_email'] ?? null;
    $parentEmail = $_POST['parent_email'] ?? null;
    $pdfData = $_FILES['pdf']['tmp_name'] ?? null; // Le fichier PDF temporaire

    // Appeler la fonction pour envoyer l'email
    $result = sendEmail($studentEmail, $parentEmail, $pdfData);

    // Afficher le résultat
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
