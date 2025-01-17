<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement - École Keyce</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #f97316;
            --text-color: #333;
            --background-color: #f0f4f8;
            --card-background: #ffffff;
        }
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px; 
            margin: 0 auto;
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        } 
        .header {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
        .receipt-title {
            font-size: 28px;
            margin: 0;
        }
        .receipt-body {
            padding: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 20px;
            color: var(--primary-color);
            margin-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .info-item {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 15px;
        }
        .info-label {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
        }
        .qr-code {
            text-align: center;
            margin-top: 30px;
        }
        .qr-code img {
            max-width: 150px;
            height: auto;
        }
        .footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            border-radius: 0 0 8px 8px;
        }
        .icon {
            margin-right: 10px;
            color: var(--accent-color);
        }
        .school-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .school-details {
            text-align: right;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(30, 64, 175, 0.1);
            pointer-events: none;
            z-index: 1;
        }

        @media print {
            body {
                width: 21cm;
                height: 29.7cm;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 18cm;
                height: auto;
                box-shadow: none;
                margin: 0 auto;
                padding: 1.5cm;
            }
            .watermark {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="images\Keyce_logo.png" alt="Logo de l'école Keyce" class="logo">
            <h1 class="receipt-title">Reçu de Paiement</h1>
        </div>
        <div class="receipt-body">
            <div class="school-info">
                <div>
                    <h2>École Keyce</h2>
                    <p>Campus l'atelier, <br>Yaoundé, Titi Garage</p>
                </div>
                <div class="school-details">
                    <p>Tél: (+237) 659 42 33 35<br>Email: africa@keyce-informatique.fr</p>
                </div>
            </div>
            <div class="section">
                <h2 class="section-title"><i class="fas fa-user icon"></i>Informations de l'Étudiant</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nom de l'Étudiant</div>
                        <div class="info-value"><?php echo $studentName; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Numéro d'Étudiant</div>
                        <div class="info-value"><?php echo $studentId; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Classe</div>
                        <div class="info-value"><?php echo $studentClass; ?></div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title"><i class="fas fa-money-bill-wave icon"></i>Détails du Paiement</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Numéro de Reçu</div>
                        <div class="info-value"><?php echo $receiptNumber; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date de Paiement</div>
                        <div class="info-value"><?php echo $paymentDate; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Montant Payé</div>
                        <div class="info-value"><?php echo $amountPaid; ?> FCFA</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Solde Restant</div>
                        <div class="info-value"><?php echo $remainingBalance; ?> FCFA</div>
                    </div>
                </div>
            </div>
            
            <!-- <div class="qr-code">
                <img src="<?php echo $qrCodeImage; ?>" alt="QR Code de la signature numérique">
                <p>Signature Numérique</p>
            </div> -->
        </div>
        <div class="footer">
            <!-- Ce reçu est généré électroniquement et ne nécessite pas de signature physique. -->
            <br>
            École Keyce - <?php echo date('Y'); ?>
        </div>
    </div>
    <div class="watermark">PAYÉ</div>
</body>
</html>