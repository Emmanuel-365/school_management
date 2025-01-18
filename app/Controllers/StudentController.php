<?php

namespace App\Controllers;

use App\Models\StudentModel;
use Exception;

class StudentController {
    protected $studentModel;
    protected $userController;
    protected $parentController;
    protected $studentCardController;
    protected $classController;
    protected $bulletinController;

    public function __construct($db) {
        $this->studentModel = new StudentModel($db);
        $this->userController = new UserController($db);
        $this->parentController = new ParentController($db);
        $this->studentCardController = new StudentCardController($db);
        $this->classController = new ClassController($db);
        $this->bulletinController = new BulletinController($db);
    }

    // Méthode pour créer un étudiant
    public function createStudent($data) {
        if($data['parent_email'] === $data['email']){
            throw new \Exception('Le mail du parent et de l\'etudiant doivent etre differents');
        }
        // Créer d'abord le parent
        $parentData = [
            'first_name' => $data['parent_first_name'],
            'last_name' => $data['parent_last_name'],
            'email' => $data['parent_email'],
            'phone' => $data['parent_phone'],
            'role' => 'parent',
            'username' => $data['parent_email'],
            'password' => password_hash($data['parent_email'], PASSWORD_BCRYPT),
        ];
        $parentId = $this->parentController->createParent($parentData);

        // Créer l'utilisateur étudiant
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'student',
            'username' => $data['matricule'],
            'password' => password_hash($data['matricule'], PASSWORD_BCRYPT),
            'profile_picture' => $data['profile_picture'],
        ];
        $userId = $this->userController->createUser($userData);

        // Créer l'étudiant
        $studentData = [
            'id' => $userId,
            'matricule' => $data['matricule'],
            'date_of_birth' => $data['date_of_birth'],
            'address' => $data['address'],
            'class_id' => $data['class_id'],
            'parent_id' => $parentId,
            'remaining_fee' => $data['remaining_fee'],
        ];
        $this->studentModel->create($studentData);

        $card_data = [
            'student_id' => $userId,
            'card_number' => $data['matricule'],
            'issue_date' => date('Y-m-d'),
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
        ];
        $this->studentCardController->createStudentCard($card_data);

        $bulletin_data = [
            'student_id' => $userId,
            'class_id' => $data['class_id'],
            'period' => date('Y'),
            'issue_date' => date('Y-m-d'),
        ];
        $this->bulletinController->createBulletin($bulletin_data);
    }

    // Méthode pour lire un étudiant par ID
    public function readStudent($id): StudentModel {
        $student = $this->studentModel->read($id);
        return $student;
    }

    public function readStudentWithUsersInformations($id):StudentModel {
        $student =  $this->studentModel->readWithUsersInformations($id);
        $this->getStatus($student);
        return $student;
    }

    // Méthode pour lire tous les étudiants
    /**
     * @return StudentModel[]
     */
    public function readAllStudents() {
        $students = $this->studentModel->readAll();
        foreach ($students as $student) {
            $this->getStatus($student);
        }
        return $students;
    }

    public function readAllStudentsWithUsersInformations() {
        $students = $this->studentModel->readAllWithUsersInformations();
        foreach ($students as $student) {
            $this->getStatus($student);
        }
        return $students;
    }

    public function readStudentsByLevel($level) {
        return $this->studentModel->readByLevel($level);
    }

    // Méthode pour mettre à jour un étudiant
    public function updateStudent($id, $data) {
        // Vérifier si l'email est présent dans $data
        if (array_key_exists('email', $data)) {
            // Mettre à jour l'utilisateur via userController si un email est fourni
            $this->userController->updateuser($id, $data);
        }
        
        // Toujours mettre à jour les informations de l'étudiant
        return $this->studentModel->update($id, $data);
    }
    
    // Méthode pour supprimer un étudiant
    public function deleteStudent($id) {
        $student = $this->readStudent($id);
        $parent_Id = $student->parent_id;
        $this->studentModel->delete($id);
        $this->userController->deleteUser($id);
        $this->userController->deleteUser($parent_Id);
    }

    // Méthode pour compter les étudiants par classe
    public function countStudentsByClass($classId) {
        return $this->studentModel->countStudentsByClass($classId);
    }

    public function checkIsValidPassword($id){
        return $this->studentModel->isValidPassword($id);
    }

    public function countStudents(){
        return $this->studentModel->countStudents();
    }

    public function getStatus(&$student)
{
    // Vérification de `remaining_fee` et debug initial
    if (!isset($student->remaining_fee) || !is_numeric($student->remaining_fee)) {
            throw new Exception("Le champ `remaining_fee` est invalide ou non défini.");
        }

        // Récupérer les frais totaux pour la classe
        $class = $this->classController->readClass($student->class_id);
        if (!$class || !isset($class->total_fee)) {
            throw new Exception("Impossible de récupérer `total_fee` pour la classe avec ID: " . $student->class_id);
        }

        $totalFee = (float)$class->total_fee; // Convertir en float pour éviter les problèmes de type
        $remainingFee = (float)$student->remaining_fee; // Convertir en float pour éviter les problèmes de type

        // Calculer le statut
        if ($remainingFee == 0) {
            $student->status = "payée";
        } elseif ($remainingFee <= $totalFee / 2) {
            $student->status = "solvable";
        } else {
            $student->status = "non solvable";
        }

        // Debugging pour valider les données
        // var_dump([
        //     'remaining_fee' => $remainingFee,
        //     'total_fee' => $totalFee,
        //     'status' => $student->status,
        // ]);
    }

}
?>
