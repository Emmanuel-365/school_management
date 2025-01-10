<?php
namespace App\Controllers;
use App\Models\UserModel;
class ParentController {
    protected $userController;

    public function __construct($db) {
        $this->userController = new UserController($db);
    }

    // Méthode pour créer un parent
    public function createParent($data) {
        
        // Créer d'abord l'utilisateur
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'parent',
            'username' => $data['username'],
            'password' => $data['password'],
        ];
        return $this->userController->createUser($userData);
    }

    // Méthode pour lire un parent par ID
    public function readParent($id) {
        return $this->userController->readUser($id);
    }

    // Méthode pour lire tous les parents
    public function readAllParents() {
        return $this->userController->readAllUsers();
    }

    // Méthode pour mettre à jour un parent
    public function updateParent($id, $data) {
        return $this->userController->updateUser($id, $data);
    }

    // Méthode pour supprimer un parent
    public function deleteParent($id) {
        return $this->userController->deleteUser($id);
    }
}
?>
