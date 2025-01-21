<?php
namespace App\Controllers;
use App\Models\GradeModel;
class GradeController {
    protected $gradeModel;

    public function __construct($db) {
        $this->gradeModel = new GradeModel($db);
    }

    // Méthode pour créer une note
    public function createGrade($data) {
        return $this->gradeModel->create($data);
    }

    // Méthode pour lire une note par ID
    public function readGrade($id) {
        return $this->gradeModel->read($id);
    }

    // Méthode pour lire toutes les notes
    public function readAllGrades() {
        return $this->gradeModel->readAll();
    }


    public function readAllGradesByLevel($level) {
        return $this->gradeModel->readAllByLevel($level);
    }

    public function readAllGradesBySubject($subject_id) {
        return $this->gradeModel->findManyBy("subject_id", $subject_id);
    }

    public function readAllGradesByStudent($student_id) {
        return $this->gradeModel->findManyBy("student_id", $student_id);
    }

    // Méthode pour mettre à jour une note
    public function updateGrade($id, $data) {
        return $this->gradeModel->update($id, $data);
    }

    // Méthode pour supprimer une note
    public function deleteGrade($id) {
        return $this->gradeModel->delete($id);
    }
}
?>
