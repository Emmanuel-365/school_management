<?php

use App\Config\Database;
use App\Controllers\BulletinController;
use App\Controllers\GradeController;
use App\Controllers\StudentController;
use App\Controllers\ClassController;
use App\Controllers\ParentController;
use App\Controllers\SubjectController;

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$bulletinController = new BulletinController($db);
$gradeController = new GradeController($db);
$studentController = new StudentController($db);
$classController = new ClassController($db);
$subjectController = new SubjectController($db);
$parentController = new ParentController($db);

// Récupération des données de l'étudiant
$studentId = $_GET['student_id'] ?? null; // Récupérer l'ID de l'étudiant depuis l'URL ou autre source
if (!$studentId) {
    echo "Aucun étudiant sélectionné.";
    exit;
}

$bulletinId = $bulletinController->readBulletinByStudent($studentId)->id;

$student = $studentController->readStudentWithUsersInformations($studentId);
if (!$student) {
    echo "L'étudiant n'existe pas.";
    exit;
}

$parentEmail = $parentController->readParent($student->parent_id)->email;

// Récupération des notes de l'étudiant
$grades = $gradeController->readAllGradesByStudent($studentId);
if (empty($grades)) {
    echo "L'étudiant n'a pas de notes disponibles pour générer le bulletin.";
    exit;
}

$finalGrades = [];

foreach ($grades as $grade) {
    $subject_id = $grade->subject_id;
    $type_note = $grade->type_note;
    $gradeValue = $grade->grade;

    if (!isset($finalGrades[$subject_id])) {
        $finalGrades[$subject_id] = [
            'cc' => 0,
            'tp' => 0,
            'exam' => 0,
            'rattrapage' => 0,
        ];
    }

    if (isset($finalGrades[$subject_id][$type_note])) {
        $finalGrades[$subject_id][$type_note] = $gradeValue;
    }
}

// Calculer la note finale pour chaque matière
$subjectFinalGrades = [];

foreach ($finalGrades as $subject_id => $notes) {
    $cc = $notes['cc'];
    $tp = $notes['tp'];
    $exam = $notes['exam'];
    $rattrapage = $notes['rattrapage'];

    // Remplacer la note d'examen par la note de rattrapage si elle est plus élevée
    if ($rattrapage > $exam) {
        $exam = $rattrapage;
    }

    // Calculer la note finale pondérée
    $finalGrade = ($cc * 0.2) + ($tp * 0.4) + ($exam * 0.4);
    $subjectFinalGrades[$subject_id] = $finalGrade;
}

$niveau = $classController->readClass($student->class_id)->level;

// Calcul de la moyenne générale
$average = array_sum($subjectFinalGrades) / count($subjectFinalGrades);

// Détermination de la mention
function getMention($average) {
    if ($average == 0) 
        return 'Excellent';
    elseif ($average >= 16) 
        return 'Très Bien';
    elseif ($average >= 14) 
        return 'Bien';
    elseif ($average >= 12) 
        return 'Assez Bien';
    elseif ($average >= 10) 
        return 'Passable';
    else 
        return 'Insuffisant';
    
}

$mention = getMention($average);

// Génération du hash unique pour le bulletin
function generateHash($student, $grades, $average, $mention)
{
    $content = $student->first_name . $student->last_name . $student->matricule;
    foreach ($grades as $grade) {
        $content .= $grade->subject_id . $grade->grade; // Utilisation des propriétés de l'objet
    }
    $content .= $average . $mention;
    return hash('sha256', $content);
}

$bulletinHash = generateHash($student, $grades, $average, $mention);

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Créer une instance de QrCode avec le contenu
$qrCode = new QrCode($bulletinHash);

// Créer une instance du writer PNG
$writer = new PngWriter();
$qrCodeData = $writer->write($qrCode);
$qrCodeData->saveToFile('qrcodes/qrcode.png');

?>

<?php
// Charger la clé privée
$privateKey = openssl_pkey_get_private(file_get_contents('../app/config/private_key.pem'));

// Vérifier si la clé est valide
if (!$privateKey) {
    echo "La clé privée n'est pas valide.";
    exit;
}

// Signer le hash du bulletin
$signature = null;
$hash = $bulletinHash;  // Le hash que tu as généré plus tôt
$signatureValid = openssl_sign($hash, $signature, $privateKey, OPENSSL_ALGO_SHA256);

if (!$signatureValid) {
    echo "Erreur lors de la signature du bulletin.";
    exit;
}

// Convertir la signature en base64 pour l'intégrer facilement dans le bulletin
$signatureBase64 = base64_encode($signature);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #1e40af;
            --secondary-color: #f97316;
            --background-color: #f3f4f6;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 90rem;
            margin: 40px auto;
            padding: 20px;
        }

        .bulletin {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), #1e40af);
            color: white;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
        }

        .student-info {
            padding: 30px;
            background-color: #f9fafb;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .student-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 30px;
            border: 4px solid white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .student-details {
            flex-grow: 1;
            text-align: start;
        }

        .student-details p {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .grades {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            background-color: #f9fafb;
            transition: all 0.3s ease;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        tr:hover td {
            background-color: #e5e7eb;
            transform: scale(1.02);
        }

        td:first-child, th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        td:last-child, th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .summary {
            background-color: #f9fafb;
            padding: 30px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary p {
            font-size: 18px;
            font-weight: 600;
        }

        .mention {
            font-weight: 700;
            color: var(--secondary-color);
            font-size: 24px;
        }

        .signature {
            padding: 20px;
            text-align: right;
            font-style: italic;
            color: #6b7280;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .logo {
                margin-bottom: 20px;
            }

            .student-info {
                flex-direction: column;
                text-align: center;
            }

            .student-photo {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .summary {
                flex-direction: column;
            }

            .summary p {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bulletin">
            <header class="header">
                <img src="../images/keyce_logo.png" alt="Logo de l'école" class="logo">
                <h1 class="title">Bulletin de Notes</h1>
            </header>
            <div class="student-info">
                <div class="student-details">
                    <p><strong>Nom:</strong> <?= $student->first_name . ' ' . $student->last_name ?></p>
                    <p><strong>Classe:</strong> <?= $niveau ?></p>
                    <p><strong>Matricule:</strong> <?= $student->matricule ?></p>
                </div>
                <img src="<?= htmlspecialchars($user->profile_picture ?? '/images/profiles/default_profile.jpg'); ?>" alt="Photo de l'étudiant" class="student-photo">
            </div>
            <div class="grades">
                <table>
                    <thead>
                        <tr>
                            <th>Matière</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjectFinalGrades as $subject_id => $finalGrade): ?>
                        <tr>
                            <td><?= $subjectController->readSubject($subject_id)->name ?></td>
                            <td><?= number_format($finalGrade, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="summary">
                <p><strong>Moyenne Générale:</strong> <?= number_format($average, 2) ?></p>
                <p><strong>Mention:</strong> <span class="mention"><?= htmlspecialchars($mention) ?></span></p>
            </div>
            <div class="signature">
                <p>Signature numérique: </p>
                <img width="100" height="100" src="/qrcodes/qrcode.png" alt="code qr">
            </div>
            <center>
                <button id="downloadPdf">Télécharger le Bulletin</button>
                <button id="sendEmailButton">Envoyer par e-mail</button>
            </center>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsPDF/2.5.1/jspdf.umd.min.js"></script>

<script>
    const student = <?= json_encode($student, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const grades = <?= json_encode($grades) ?>;
    const average = <?= json_encode($average) ?>;
    const mention = <?= json_encode($mention) ?>;
    const niveau = <?= json_encode($niveau, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const bulletinId = <?= json_encode($bulletinId) ?>;
    const parentEmail = <?= json_encode($parentEmail) ?>;

    document.getElementById('downloadPdf').addEventListener('click', async () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const element = document.querySelector('.container');

        html2canvas(element, {
            useCORS: true,
            logging: true,
            allowTaint: true,
        }).then(async function (canvas) {
            const imgData = canvas.toDataURL('image/jpeg', 1.0);
            doc.addImage(imgData, 'JPEG', 10, 10, 180, 0);

            // Convertir le PDF en blob
            const pdfBlob = doc.output('blob');

            // Créer une requête pour envoyer le PDF au serveur
            const formData = new FormData();
            formData.append('pdf', pdfBlob);
            formData.append('bulletinId', bulletinId);

            try {
                const response = await fetch('/savepdf', {
                    method: 'POST',
                    body: formData,
                });

                const responseText = await response.text();
                console.log('Réponse brute du serveur :', responseText);

                const result = JSON.parse(responseText);

                if (response.ok && result.success) {
                    const downloadLink = document.createElement('a');
                    downloadLink.href = result.file_url;
                    downloadLink.download = 'bulletin_signed.pdf';
                    downloadLink.click();
                } else {
                    alert('Erreur lors du traitement du PDF : ' + result.message);
                }
            } catch (error) {
                console.error('Erreur lors de l\'envoi du PDF au serveur :', error);
                alert('Une erreur est survenue.');
            }
        });
    });

    // Fonction pour envoyer le bulletin par e-mail
    async function sendEmail() {
        const pdfUrl = '/uploads/bulletin_signed.pdf';

        const formData = new FormData();
        formData.append('student_email', student.email);
        formData.append('parent_email', 'emmanuelscre1@gmail.com');

        const response = await fetch(pdfUrl);
        if (!response.ok) {
            alert('Le fichier PDF n\'a pas pu être récupéré.');
            return;
        }

        const pdfBlob = await response.blob();
        formData.append('pdf', pdfBlob, 'bulletin_signed.pdf');

        try {
            const sendResponse = await fetch('/send_mail', {
                method: 'POST',
                body: formData
            });

            const responseText = await sendResponse.text();
            console.log('Réponse brute du serveur :', responseText);

            const result = JSON.parse(responseText); // Parser la réponse JSON

            if (sendResponse.ok && result.success) {
                alert('Le bulletin a été envoyé avec succès');
            } else {
                alert('Erreur lors de l\'envoi du bulletin : ' + result.message);
            }
        } catch (error) {
            console.error('Erreur lors de l\'envoi du bulletin :', error);
            alert('Une erreur est survenue lors de l\'envoi.');
        }
    }

    // Attacher l'événement au bouton
    document.getElementById('sendEmailButton').addEventListener('click', sendEmail);
</script>

</html>
