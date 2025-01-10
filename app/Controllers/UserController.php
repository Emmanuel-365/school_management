<?php
namespace App\Controllers;
use App\Models\UserModel;
use Exception;
class UserController {
    protected $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // Méthode pour créer un utilisateur
    public function createUser($data) {
        // Vérifier si l'email existe déjà
        $existingUser = $this->userModel->findBy('email', $data['email']);
        if ($existingUser) {
            if($existingUser->role == 'parent'){
                return $existingUser->id;
            }else
                throw new Exception("Email already exists.");
        }

        return $this->userModel->create($data);
    }

    // Méthode pour lire un utilisateur par ID
    public function readUser($id) {
        return $this->userModel->read($id);
    }

    // Méthode pour lire tous les utilisateurs
    public function readAllUsers() {
        return $this->userModel->readAll();
    }

    // Méthode pour mettre à jour un utilisateur
    public function updateUser($id, $data) {
        // Vérifier si l'email existe déjà
        $existingUser = $this->userModel->findBy('email', $data['email']);
        if ($existingUser && $existingUser->id != $id) {
            throw new Exception("Email already exists.");
        }
        return $this->userModel->update($id, $data);
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($id) {
        return $this->userModel->delete($id);
    }

    // Méthode pour lire un utilisateur par n'importe quel champ
    public function findUserBy($field, $value) {
        return $this->userModel->findBy($field, $value);
    }

    // Méthode pour vérifier les informations de connexion
    public function login($username, $password) {
        $user = $this->userModel->findBy("username", $username);
        if ($user && password_verify($password, $user->password)) {
            // Mettre à jour la dernière date de connexion
            $this->userModel->update($user->id, ['last_login' => $user->last_login]);
            // Stocker l'ID de l'utilisateur et son rôle dans la session
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_role'] = $user->role;
            return true;
        }
        return false;
    }

    // Méthode pour déconnecter l'utilisateur
    public function logout() {
        session_unset();
        session_destroy();
    }
}
?>
