<?php
namespace App\Controllers;
use App\Models\SubjectModel;
class SubjectController {
    protected $subjectModel;

    public function __construct($db) {
        $this->subjectModel = new SubjectModel($db);
    }

    // Méthode pour créer une matière
    public function createSubject($data) {
        return $this->subjectModel->create($data);
    }

    // Méthode pour lire une matière par ID
    public function readSubject($id) {
        return $this->subjectModel->read($id);
    }

    public function readSubjectByLevel($level) {
        return $this->subjectModel->findManyBy('level', $level);
    }

    // Méthode pour lire toutes les matières
    public function readAllSubjects() {
        return $this->subjectModel->readAll();
    }

    // Méthode pour mettre à jour une matière
    public function updateSubject($id, $data) {
        return $this->subjectModel->update($id, $data);
    }

    // Méthode pour supprimer une matière
    public function deleteSubject($id) {
        return $this->subjectModel->delete($id);
    }

    public function readField($field, $id){
        return $this->subjectModel->getField($field, $id);
    }
}
?>
