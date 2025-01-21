<?php
use App\Config\Database;
use App\Controllers\ClassController;
use App\Controllers\StudentController;
use App\Controllers\SubjectController;
use App\Controllers\TeacherController;

$database = new Database();
$db = $database->getConnection();

$students = [];

// Liste de prénoms et noms réalistes pour le Cameroun
$firstNames = ['Jean', 'Marie', 'Pierre', 'Alice', 'Paul', 'Claire', 'Jacques', 'Lucie', 'Marc', 'Sophie', 'André', 'Julie', 'Louis', 'Anne', 'David', 'Céline', 'Serge', 'Valérie', 'Emmanuel', 'Christelle', 'Claude', 'Azaël'];
$lastNames = ['Ngono', 'Tchoupo', 'Nkoulou', 'Mballa', 'Fotso', 'Kamdem', 'Ndjock', 'Tchakounté', 'Nguemo', 'Ndong', 'Mbappé', 'Eto\'o', 'Song', 'Nkoulou', 'Tchoupi', 'Nganou', 'Fokou', 'Nkafu', 'Ndi', 'Tchoupa', 'Nguetsa', 'Djepmo'];
$subjects = [
    // Bachelor 1
    ['name' => 'Introduction à la Programmation', 'level' => 'Bachelor 1', 'credit' => 4],
    ['name' => 'Mathématiques pour l\'Informatique', 'level' => 'Bachelor 1', 'credit' => 5],
    ['name' => 'Systèmes d\'Exploitation', 'level' => 'Bachelor 1', 'credit' => 3],
    ['name' => 'Architecture des Ordinateurs', 'level' => 'Bachelor 1', 'credit' => 4],
    ['name' => 'Bases de Données Relationnelles', 'level' => 'Bachelor 1', 'credit' => 4],
    ['name' => 'Algorithmique de Base', 'level' => 'Bachelor 1', 'credit' => 5],
    ['name' => 'Communication et Rédaction Technique', 'level' => 'Bachelor 1', 'credit' => 2],

    // Bachelor 2
    ['name' => 'Programmation Orientée Objet', 'level' => 'Bachelor 2', 'credit' => 5],
    ['name' => 'Structures de Données', 'level' => 'Bachelor 2', 'credit' => 4],
    ['name' => 'Réseaux Informatiques', 'level' => 'Bachelor 2', 'credit' => 4],
    ['name' => 'Développement Web Frontend', 'level' => 'Bachelor 2', 'credit' => 4],
    ['name' => 'Développement Web Backend', 'level' => 'Bachelor 2', 'credit' => 4],
    ['name' => 'Systèmes de Gestion de Bases de Données', 'level' => 'Bachelor 2', 'credit' => 5],
    ['name' => 'Introduction à la Sécurité Informatique', 'level' => 'Bachelor 2', 'credit' => 3],

    // Bachelor 3
    ['name' => 'Développement d\'Applications Mobiles', 'level' => 'Bachelor 3', 'credit' => 6],
    ['name' => 'Cloud Computing et Virtualisation', 'level' => 'Bachelor 3', 'credit' => 5],
    ['name' => 'Gestion de Projets Informatiques', 'level' => 'Bachelor 3', 'credit' => 4],
    ['name' => 'Programmation Fonctionnelle', 'level' => 'Bachelor 3', 'credit' => 4],
    ['name' => 'Big Data et Analytics', 'level' => 'Bachelor 3', 'credit' => 5],
    ['name' => 'Interface Utilisateur (UI/UX)', 'level' => 'Bachelor 3', 'credit' => 3],
    ['name' => 'Sécurité des Réseaux', 'level' => 'Bachelor 3', 'credit' => 4],

    // Master 1
    ['name' => 'Intelligence Artificielle', 'level' => 'Master 1', 'credit' => 6],
    ['name' => 'Machine Learning', 'level' => 'Master 1', 'credit' => 6],
    ['name' => 'Traitement du Langage Naturel (NLP)', 'level' => 'Master 1', 'credit' => 5],
    ['name' => 'Vision par Ordinateur', 'level' => 'Master 1', 'credit' => 5],
    ['name' => 'Blockchain et Cryptographie', 'level' => 'Master 1', 'credit' => 5],
    ['name' => 'Architecture des Systèmes Distribués', 'level' => 'Master 1', 'credit' => 6],
    ['name' => 'Gestion des Données Massives', 'level' => 'Master 1', 'credit' => 5],

    // Master 2
    ['name' => 'Deep Learning', 'level' => 'Master 2', 'credit' => 6],
    ['name' => 'Internet des Objets (IoT)', 'level' => 'Master 2', 'credit' => 5],
    ['name' => 'Systèmes Embarqués', 'level' => 'Master 2', 'credit' => 5],
    ['name' => 'Robotique et Automatisation', 'level' => 'Master 2', 'credit' => 6],
    ['name' => 'Sécurité des Applications Web', 'level' => 'Master 2', 'credit' => 4],
    ['name' => 'Gestion des Infrastructures Cloud', 'level' => 'Master 2', 'credit' => 5],
    ['name' => 'Développement de Jeux Vidéo', 'level' => 'Master 2', 'credit' => 6],
];

    
$specialites = [
    "Développement Web",
    "Développement Mobile",
    "Intelligence Artificielle",
    "Machine Learning",
    "Data Science",
    "Big Data",
    "Sécurité Informatique",
    "Réseaux et Télécommunications",
    "Administration Système",
    "Cloud Computing",
    "DevOps",
    "Ingénierie Logicielle",
    "Conception de Bases de Données",
    "Analyse de Données",
    "Blockchain",
    "Internet des Objets (IoT)",
    "Réalité Virtuelle et Augmentée",
    "Développement de Jeux Vidéo",
    "Programmation Orientée Objet",
    "Programmation Fonctionnelle",
    "Gestion de Projets Informatiques",
    "Test et Assurance Qualité Logicielle",
    "Interface Utilisateur (UI) et Expérience Utilisateur (UX)",
    "Systèmes Embarqués",
    "Robotique",
    "Traitement du Langage Naturel (NLP)",
    "Vision par Ordinateur",
    "Génie Logiciel",
    "Architecture des Systèmes d'Information",
    "Virtualisation et Conteneurisation",
    "Gestion des Données Massives",
    "Analyse de Sécurité",
    "Cryptographie",
    "Développement Full-Stack",
    "Développement Backend",
    "Développement Frontend",
    "Gestion des Réseaux Sociaux",
    "Marketing Digital",
    "Gestion des Bases de Données NoSQL",
    "Gestion des Bases de Données Relationnelles",
    "Développement d'Applications Distribuées",
    "Gestion des Serveurs",
    "Automatisation des Tests",
    "Gestion des Infrastructures Cloud",
    "Développement Agile",
    "Gestion des Données Géospatiales",
    "Analyse de Performance des Systèmes",
    "Gestion des Risques Informatiques",
    "Développement d'API",
    "Gestion des Projets Open Source",
    "Développement de Logiciels Embarqués",
    "Gestion des Données Biométriques",
    "Développement de Systèmes Temps Réel",
    "Gestion des Données de Santé",
    "Développement de Logiciels pour l'Éducation",
    "Gestion des Données Financières",
    "Développement de Logiciels pour l'Industrie",
    "Gestion des Données Environnementales",
    "Développement de Logiciels pour les Transports",
    "Gestion des Données Multimédia",
    "Développement de Logiciels pour les Télécommunications",
    "Gestion des Données de Sécurité",
    "Développement de Logiciels pour l'Énergie",
    "Gestion des Données de Recherche",
    "Développement de Logiciels pour le Commerce Électronique",
    "Gestion des Données de Logistique",
    "Développement de Logiciels pour les Ressources Humaines",
    "Gestion des Données de Production",
    "Développement de Logiciels pour le Tourisme",
    "Gestion des Données de Marketing",
    "Développement de Logiciels pour les Services Publics",
    "Gestion des Données de Santé Publique",
    "Développement de Logiciels pour les Assurances",
    "Gestion des Données de Sécurité Alimentaire",
    "Développement de Logiciels pour les Médias",
    "Gestion des Données de Transport",
    "Développement de Logiciels pour les Services Financiers",
    "Gestion des Données de l'Éducation",
    "Développement de Logiciels pour les Services de Santé",
    "Gestion des Données de l'Environnement",
    "Développement de Logiciels pour les Services de Transport",
    "Gestion des Données de l'Énergie",
    "Développement de Logiciels pour les Services de Télécommunications",
    "Gestion des Données de la Recherche Scientifique",
    "Développement de Logiciels pour les Services de Commerce Électronique",
    "Gestion des Données de la Logistique",
    "Développement de Logiciels pour les Services de Ressources Humaines",
    "Gestion des Données de la Production",
    "Développement de Logiciels pour les Services de Tourisme",
    "Gestion des Données du Marketing",
    "Développement de Logiciels pour les Services Publics",
    "Gestion des Données de la Santé Publique",
    "Développement de Logiciels pour les Services d'Assurance",
    "Gestion des Données de la Sécurité Alimentaire",
    "Développement de Logiciels pour les Services des Médias",
    "Gestion des Données du Transport",
    "Développement de Logiciels pour les Services Financiers",
    "Gestion des Données de l'Éducation",
    "Développement de Logiciels pour les Services de Santé",
    "Gestion des Données de l'Environnement",
    "Développement de Logiciels pour les Services de Transport",
    "Gestion des Données de l'Énergie",
    "Développement de Logiciels pour les Services de Télécommunications",
    "Gestion des Données de la Recherche Scientifique",
    "Développement de Logiciels pour les Services de Commerce Électronique",
    "Gestion des Données de la Logistique",
    "Développement de Logiciels pour les Services de Ressources Humaines",
    "Gestion des Données de la Production",
    "Développement de Logiciels pour les Services de Tourisme",
    "Gestion des Données du Marketing",
    "Développement de Logiciels pour les Services Publics",
    "Gestion des Données de la Santé Publique",
    "Développement de Logiciels pour les Services d'Assurance",
    "Gestion des Données de la Sécurité Alimentaire",
    "Développement de Logiciels pour les Services des Médias",
    "Gestion des Données du Transport",
    "Développement de Logiciels pour les Services Financiers",
    "Gestion des Données de l'Éducation",
    "Développement de Logiciels pour les Services de Santé",
    "Gestion des Données de l'Environnement",
    "Développement de Logiciels pour les Services de Transport",
    "Gestion des Données de l'Énergie",
    "Développement de Logiciels pour les Services de Télécommunications",
    "Gestion des Données de la Recherche Scientifique",
    "Développement de Logiciels pour les Services de Commerce Électronique",
    "Gestion des Données de la Logistique",
    "Développement de Logiciels pour les Services de Ressources Humaines",
    "Gestion des Données de la Production",
    "Développement de Logiciels pour les Services de Tourisme",
    "Gestion des Données du Marketing",
    "Développement de Logiciels pour les Services Publics",
    "Gestion des Données de la Santé Publique",
    "Développement de Logiciels pour les Services d'Assurance",
    "Gestion des Données de la Sécurité Alimentaire",
    "Développement de Logiciels pour les Services des Médias",
    "Gestion des Données du Transport",
    "Développement de Logiciels pour les Services Financiers",
    "Gestion des Données de l'Éducation",
    "Développement de Logiciels pour les Services de Santé",
    "Gestion des Données de l'Environnement",
    "Développement de Logiciels pour les Services de Transport",
    "Gestion des Données de l'Énergie",
    "Développement de Logiciels pour les Services de Télécommunications",
    "Gestion des Données de la Recherche Scientifique",
    "Développement de Logiciels pour les Services de Commerce Électronique",
    "Gestion des Données de la Logistique",
    "Développement de Logiciels pour les Services de Ressources Humaines",
    "Gestion des Données de la Production",
    "Développement de Logiciels pour les Services de Tourisme",
    "Gestion des Données du Marketing",
    "Développement de Logiciels pour les Services Publics",
    "Gestion des Données de la Santé Publique",
    "Développement de Logiciels pour les Services d'Assurance",
    "Gestion des Données de la Sécurité Alimentaire",
    "Développement de Logiciels pour les Services des Médias",
    "Gestion des Données du Transport",
    "Développement de Logiciels pour les Services Financiers",
    "Gestion des Données de l'Éducation",
    "Développement de Logiciels pour les Services de Santé",
    "Gestion des Données de l'Environnement",
    "Développement de Logiciels pour les Services de Transport",
    "Gestion des Données de l'Énergie",
    "Développement de Logiciels pour les Services de Télécommunications",
    "Gestion des Données de la Recherche Scientifique",
    "Développement de Logiciels pour les Services de Commerce Électronique",
    "Gestion des Données de la Logistique",
    "Développement de Logiciels pour les Services de Ressources Humaines",
    "Gestion des Données de la Production",
    "Développement de Logiciels pour les Services de Tourisme",
    "Gestion des Données du Marketing",
    "Développement de Logiciels pour les Services Publics",
    "Gestion des Données de la Santé Publique",
    "Développement de Logiciels pour les Services d'Assurance",
    "Gestion des Données de la Sécurité Alimentaire",
    "Développement de Logiciels pour les Services des Médias",
    "Gestion des Données du Transport",
    "Développement de Logiciels pour les Services Financiers",
    "Gestion des Données de l'Éducation",
    "Développement de Logiciels pour les Services de Santé",
    "Gestion des Données de l'Environnement",
    "Développement de Logiciels pour les Services de Transport",
    "Gestion des Données de l'Énergie",
    "Développement de Logiciels pour les Services de Télécommunications",
    "Gestion des Données de la Recherche Scientifique",
    "Développement de Logiciels pour les Services de Commerce Électronique",
    "Gestion des Données de la Logistique",
    "Développement de Logiciels pour les Services de Ressources Humaines",
    "Gestion des Données de la Production",
    "Développement de Logiciels pour les Services de Tourisme",
    "Gestion des Données du Marketing",
    "Développement de Logiciels pour les Services Publics",
    "Gestion des Données de la Santé Publique",
    "Développement de Logiciels pour les Services d'Assurance",
    "Gestion des Données de la Sécurité Alimentaire",
    "Développement de Logiciels pour les Services des Médias",
    "Gestion des Données du Transport",
    "Développement de Logiciels pour les Services Financiers",
    "Gestion des Données de l'Éducation",
    "Développement de Logiciels pour les Services de Santé",
    "Gestion des Données de l'Environnement",
    "Développement de Logiciels pour les Services de Transport",
    "Gestion des Données de l'Énergie",
];

for ($i = 1; $i <= 50; $i++) {
    $firstName = $firstNames[array_rand($firstNames)];
    $lastName = $lastNames[array_rand($lastNames)];
    $parentFirstName = $firstNames[array_rand($firstNames)];
    $parentLastName = $lastNames[array_rand($lastNames)];

    $students[] = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => strtolower($firstName . '.' . $lastName . $i . '@gmail.com'),
        'phone' => '2376' . rand(10000000, 99999999),
        'date_of_birth' => date('Y-m-d', strtotime('-' . rand(18, 25) . ' years')),
        'address' => 'Rue ' . rand(1, 100) . ', Quartier ' . ['Mendong', 'Odza', 'Efoulan', 'Bastos', 'Mvan'][rand(0, 4)] . ', Yaoundé, Cameroun',
        'class_id' => rand(1, 10),
        'parent_first_name' => $parentFirstName,
        'parent_last_name' => $parentLastName,
        'parent_email' => strtolower($parentFirstName . '.' . $parentLastName . $i . '@gmail.com'),
        'parent_phone' => '2376' . rand(10000000, 99999999),
    ];

    
}

$studentController = new StudentController($db);
$classController = new ClassController($db);

// Récupérer toutes les classes pour le formulaire
$classes = $classController->readAllClasses();

// foreach ($students as $student) {
//     // Générer le matricule
//     $classId = $student['class_id'];
//     $className = '';
//     foreach ($classes as $class) {
//         if ($class->id == $classId) {
//             $className = $class->name;
//             break;
//         }
//     }
//     $currentYear = date('Y');
//     $studentCount = $studentController->countStudentsByClass($classId);
//     $matricule = $currentYear . $className . str_pad($studentCount + 2, 3, '0', STR_PAD_LEFT);

//     $student['matricule'] = $matricule;
//     $student['remaining_fee'] = $classController->readClass($classId)->total_fee; 
//     $studentController->createStudent($student);
// }



for ($i=0; $i <10 ; $i++) { 
    $firstName = $firstNames[array_rand($firstNames)];
    $lastName = $lastNames[array_rand($lastNames)];
    $speciality = $specialites[array_rand($specialites)];


    $teachers[] = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => strtolower($firstName . '.' . $lastName . $i . '@gmail.com'),
        'phone' => '2376' . rand(10000000, 99999999),
        'specialty' => $speciality,
        'hire_date' => Date('Y-m-d'),
        'status' => 'active',
    ];
}

// $teacherController = new TeacherController($db);
// foreach ($teachers as $teacher) {
//     $teacherController->createTeacher($teacher);
// }


$subjectController = new SubjectController($db);
foreach ($subjects as $subject) {
    // Ajout d'un teacher_id aléatoire entre 137 et 146
    $subject['teacher_id'] = rand(137, 146);

    $subjectController->createSubject($subject);
}
?>