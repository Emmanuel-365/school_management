<?php
namespace App\Controllers;
use App\Models\ClassModel;
class ClassController {
    protected $classModel;

    public function __construct($db) {
        $this->classModel = new ClassModel($db);
    }

    // Méthode pour créer une classe
    public function createClass($data) {
        return $this->classModel->create($data);
    }

    // Méthode pour lire une classe par ID
    public function readClass($id): ClassModel {
        return $this->classModel->read($id);
    }

    /**
     * Recupere la liste des toutes les classes
     * @return ClassModel[]
     */
    public function readAllClasses(): array {
        return $this->classModel->readAll();
    }

    // Méthode pour mettre à jour une classe
    public function updateClass($id, $data) {
        return $this->classModel->update($id, $data);
    }

    // Méthode pour supprimer une classe
    public function deleteClass($id) {
        return $this->classModel->delete($id);
    }
}
?>
