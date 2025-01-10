<?php
namespace App\Controllers;
use App\Models\StudentCardModel;
class StudentCardController {
    protected $studentCardModel;

    public function __construct($db) {
        $this->studentCardModel = new StudentCardModel($db);
    }

    // Méthode pour créer une carte d'étudiant
    public function createStudentCard($data) {
        return $this->studentCardModel->create($data);
    }

    // Méthode pour lire une carte d'étudiant par ID
    public function readStudentCard($id) {
        return $this->studentCardModel->read($id);
    }

    public function readStudentCardByStudent($studentId){
        return $this->studentCardModel->findby('student_id', $studentId);
    }

    // Méthode pour lire toutes les cartes d'étudiants
    public function readAllStudentCards() {
        return $this->studentCardModel->readAll();
    }

    // Méthode pour mettre à jour une carte d'étudiant
    public function updateStudentCard($id, $data) {
        return $this->studentCardModel->update($id, $data);
    }

    // Méthode pour supprimer une carte d'étudiant
    public function deleteStudentCard($id) {
        return $this->studentCardModel->delete($id);
    }
}
?>
