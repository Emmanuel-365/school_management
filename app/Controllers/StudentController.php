<?php

namespace App\Controllers;

use App\Models\StudentModel;

class StudentController {
    protected $studentModel;
    protected $userController;
    protected $parentController;
    protected $studentCardController;

    public function __construct($db) {
        $this->studentModel = new StudentModel($db);
        $this->userController = new UserController($db);
        $this->parentController = new ParentController($db);
        $this->studentCardController = new StudentCardController($db);
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
    }

    // Méthode pour lire un étudiant par ID
    public function readStudent($id): StudentModel {
        return $this->studentModel->read($id);
    }

    public function readStudentWithUsersInformations($id):StudentModel {
        return $this->studentModel->readWithUsersInformations($id);
    }

    // Nouvelle méthode : Récupérer un étudiant par son ID
    public function getStudentById($id) {
        // Vérifie si l'ID est valide
        if (!$id) {
            throw new \InvalidArgumentException("L'ID de l'étudiant est requis.");
        }

        // Récupère l'étudiant via le modèle
        $student = $this->studentModel->read($id);

        // Vérifie si un étudiant est trouvé
        if (!$student) {
            throw new \RuntimeException("Aucun étudiant trouvé avec l'ID $id.");
        }

        return $student;
    }

    // Méthode pour lire tous les étudiants
    public function readAllStudents() {
        return $this->studentModel->readAll();
    }

    public function readAllStudentsWithUsersInformations() {
        return $this->studentModel->readAllWithUsersInformations();
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
}
?>
