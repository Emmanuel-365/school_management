<?php
use App\Config\Database;
use App\Controllers\UserController;

$database = new Database();
$db = $database->getConnection();

$userController = new UserController($db);
// Initialiser les variables
$errorMessage = '';
$successMessage = '';

// Traitement du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Vérifier si les deux mots de passe correspondent
    if (trim($newPassword) === trim($confirmPassword) && !empty($newPassword)) {
        $userController->updateUser($_SESSION['user_id'], ['password' => password_hash($newPassword, PASSWORD_BCRYPT)]);
        $successMessage = 'Votre mot de passe a été mis à jour avec succès !';
        header('Location: /login');
        exit();
    } else {
        $errorMessage = 'Les mots de passe ne correspondent pas ou sont vides. Veuillez réessayer.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal {
            background-color: #fff;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .modal-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-body input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .modal-footer {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .modal-footer button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            background-color: #28a745;
            color: #fff;
        }

        .modal-footer button:hover {
            background-color: #218838;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .success-message {
            color: green;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Modal -->
    <div class="modal-overlay">
        <div class="modal">
            <div class="modal-header">Définir un nouveau mot de passe</div>
            <form method="POST" action="">
                <div class="modal-body">
                    <p>Vous utilisez un mot de passe par défaut. Veuillez le modifier pour continuer.</p>

                    <!-- Messages d'erreur ou de succès -->
                    <?php if ($errorMessage): ?>
                        <div class="error-message"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    <?php if ($successMessage): ?>
                        <div class="success-message"><?php echo $successMessage; ?></div>
                    <?php endif; ?>

                    <input type="password" id="newPassword" name="newPassword" placeholder="Nouveau mot de passe" required>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmer le mot de passe" required>
                </div>
                <div class="modal-footer">
                    <button type="submit">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
