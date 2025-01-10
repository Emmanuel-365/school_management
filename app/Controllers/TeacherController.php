<?php
namespace App\Controllers;
use App\Models\TeacherModel;
class TeacherController {
    protected $teacherModel;
    protected $userController;

    public function __construct($db) {
        $this->teacherModel = new TeacherModel($db);
        $this->userController = new UserController($db);
    }

    // Méthode pour créer un enseignant
    public function createTeacher($data) {
        // Créer d'abord l'utilisateur
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'teacher',
            'username' => $data['email'],
            'password' => password_hash($data['email'], PASSWORD_BCRYPT),
        ];
        $userId = $this->userController->createUser($userData);

        // Créer l'enseignant
        $teacherData = [
            'id' => $userId,
            'specialty' => $data['specialty'],
            'hire_date' => $data['hire_date'],
            'status' => $data['status'],
        ];
        return $this->teacherModel->create($teacherData);
    }

    // Méthode pour lire un enseignant par ID
    public function readTeacher($id) {
        return $this->teacherModel->read($id);
    }

    public function readTeacherWithUsersInformations($id) {
        return $this->teacherModel->readWithUsersInformations($id);
    }

    // Méthode pour lire tous les enseignants
    public function readAllTeachers() {
        return $this->teacherModel->readAll();
    }

    public function readAllTeachersWithUsersInformations() {
        return $this->teacherModel->readAllWithUsersInformations();
    }

    // Méthode pour mettre à jour un enseignant
    public function updateTeacher($id, $data) {
        $this->userController->updateUser($id, $data);
        return $this->teacherModel->update($id, $data);
    }

    // Méthode pour supprimer un enseignant
    public function deleteTeacher($id) {
        $this->teacherModel->delete($id);
        $this->userController->deleteUser($id);
    }
}
?>
