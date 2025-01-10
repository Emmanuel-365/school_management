<?php
// Paramètres de connexion à la base de données
require 'app/autoload.php';

require 'app/config/database.php';

$database = new Database();

$pdo = $database->getConnection();


// Fonction pour générer des utilisateurs
function generateUsers($pdo, $numUsers) {
    $roles = ['student', 'teacher', 'parent'];
    $roleIndex = 0;

    for ($i = 1; $i <= $numUsers; $i++) {
        $role = $roles[$roleIndex];
        $roleIndex = ($roleIndex + 1) % count($roles);

        $firstName = "User$i";
        $lastName = "LastName$i";
        $email = "user$i@example.com";
        $phone = "123456789$i";
        $username = "user$i";
        $password = password_hash("password$i", PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (first_name, last_name, email, phone, role, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $phone, $role, $username, $password]);
    }
}

// Fonction pour générer des étudiants
function generateStudents($pdo, $numStudents) {
    for ($i = 1; $i <= 3*$numStudents; $i+= 3) {
        $studentId = $i;
        $matricule = "MAT$i";
        $dateOfBirth = date('Y-m-d', strtotime("-18 years"));
        $address = "Address$i";
        //$classId = 1;
        $parentId = $i + 2; // Associer chaque étudiant à un parent
        $remainingFee = 0.00;
        $status = 'en_cours';

        $sql = "INSERT INTO students (id, matricule, date_of_birth, address, parent_id, remaining_fee, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$studentId, $matricule, $dateOfBirth, $address, $parentId, $remainingFee, $status]);
    }
}

// Fonction pour générer des enseignants
function generateTeachers($pdo, $numTeachers) {
    for ($i = 2; $i <= 3*$numTeachers; $i+=3) {
        $teacherId = $i; // Assumer que les IDs des enseignants commencent après les étudiants et les parents
        $specialty = "Specialty$i";
        $hireDate = date('Y-m-d', strtotime("-5 years"));
        $status = 'active';

        $sql = "INSERT INTO teachers (id, specialty, hire_date, status) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teacherId, $specialty, $hireDate, $status]);
    }
}

// Générer les utilisateurs, étudiants et enseignants
//generateUsers($pdo, 300); // 100 de chaque rôle
// generateStudents($pdo, 100);
// generateTeachers($pdo, 100);

function createClasses($pdo) {
    // Définition des niveaux académiques
    $levels = ['Bachelor 1', 'Bachelor 2', 'Bachelor 3', 'Master 1', 'Master 2'];

    // Création des classes (2 classes pour chaque niveau)
    foreach ($levels as $level) {
        for ($i = 1; $i <= 2; $i++) {
            $name = "$level - Class $i";
            $totalFee = rand(1000, 5000); // Générer un montant aléatoire pour les frais
            $sql = "INSERT INTO classes (name, level, total_fee) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $level, $totalFee]);
        }
    }
    echo "Classes created successfully.\n";
}

function assignStudentsToClasses($pdo) {
    // Mettre à jour les étudiants (id de 1 à 100) pour leur attribuer une classe
    for ($studentId = 1; $studentId <= 300; $studentId+=3) {
        $classId = rand(1, 10); // Générer un ID de classe aléatoire (de 1 à 10, car 5 niveaux x 2 classes = 10 classes)
        $sql = "UPDATE students SET class_id = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$classId, $studentId]);
    }
    echo "Students assigned to classes successfully.\n";
}

// Fonction pour générer des matières
function generateSubjects($pdo, $numSubjects) {
    $levels = ['Bachelor 1', 'Bachelor 2', 'Bachelor 3', 'Master 1', 'Master 2'];

    for ($i = 1, $e = 2; $i <= $numSubjects; $i++, $e +=3) {

        $name = "Subject$i";
        $teacherId = $e % 300; // Associer chaque matière à un enseignant
        $level = $levels[rand(0, 4)];

        $sql = "INSERT INTO subjects (name, teacher_id, level) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $teacherId, $level]);
    }
}

// createClasses($pdo);
// assignStudentsToClasses(pdo: $pdo);

generateSubjects($pdo, 300);


echo "Enregistrements générés avec succès.";
?>
