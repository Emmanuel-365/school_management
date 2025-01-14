<?php


use App\Config\Database;
use App\Controllers\StudentController;
use App\Controllers\ClassController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$studentController = new StudentController($db);
$classController = new ClassController($db);

// Récupérer toutes les classes pour le formulaire
$classes = $classController->readAllClasses();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Définir le dossier de destination pour les photos de profil
    $uploadDir = __DIR__ . '/../../../public/images/profiles/';
    $profilePicturePath = null;

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['profile_picture']['tmp_name'];
        $fileName = basename($_FILES['profile_picture']['name']);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Générer un nom de fichier unique pour éviter les conflits
        $uniqueFileName = uniqid() . '.' . $extension;

        // Chemin complet du fichier de destination
        $destination = $uploadDir . $uniqueFileName;

        // Déplacer le fichier téléchargé dans le dossier cible
        if (move_uploaded_file($tmpName, $destination)) {
            $profilePicturePath = '/images/profiles/' . $uniqueFileName;
        } else {
            echo "Erreur lors du téléchargement de la photo de profil.";
            exit();
        }
    }

    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'date_of_birth' => $_POST['date_of_birth'],
        'address' => $_POST['address'],
        'class_id' => $_POST['class_id'],
        'parent_first_name' => $_POST['parent_first_name'],
        'parent_last_name' => $_POST['parent_last_name'],
        'parent_email' => $_POST['parent_email'],
        'parent_phone' => $_POST['parent_phone'],
        'profile_picture' => $profilePicturePath, // Enregistrer le chemin dans les données
    ];

    // Générer le matricule
    $classId = $data['class_id'];
    $className = '';
    foreach ($classes as $class) {
        if ($class->id == $classId) {
            $className = $class->name;
            break;
        }
    }
    $currentYear = date('Y');
    $studentCount = $studentController->countStudentsByClass($classId);
    $matricule = $currentYear . $className . str_pad($studentCount + 1, 3, '0', STR_PAD_LEFT);

    $data['matricule'] = $matricule;
    $data['remaining_fee'] = $classController->readClass($data['class_id'])->total_fee; 

    try {
        $studentController->createStudent($data);
        header("Location: /students");
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

?>


<h3 data-translate="adding_student"></h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
            <label for="first_name" data-translate="first_name">Noms</label>
            <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
            <label for="last_name" data-translate="last_name">Prenoms</label>
            <input type="text" id="last_name" name="last_name" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
            <label for="phone" data-translate="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <div class="error-message"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label for="date_of_birth" data-translate="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>
            <div class="error-message"></div>
            </div>
            <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            </div>  
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="class_id">Class:</label>
                <select id="class_id" name="class_id" required>
                    <option value="" disabled selected>Select a class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class->id; ?>"><?php echo $class->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
            <label for="parent_first_name">Parent First Name:</label>
            <input type="text" id="parent_first_name" name="parent_first_name" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="parent_last_name">Parent Last Name:</label>
            <input type="text" id="parent_last_name" name="parent_last_name" required>
            </div>
            <div class="form-group">
            <label for="parent_email">Parent Email:</label>
            <input type="email" id="parent_email" name="parent_email" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="parent_phone">Parent Phone:</label>
            <input type="text" id="parent_phone" name="parent_phone" required>
            <div class="error-message"></div>
            </div>
            <div class="form-group">
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture">
            </div>
        </div>
        <center><div class="form-group center">
                    <button type="submit">create student</button>
                </div></center>
    </form>

