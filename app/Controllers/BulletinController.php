<?php
namespace App\Controllers;
use App\Models\BulletinModel;
class BulletinController {
    protected $bulletinModel;

    public function __construct($db) {
        $this->bulletinModel = new BulletinModel($db);
    }

    // Méthode pour créer un bulletin
    public function createBulletin($data) {
        return $this->bulletinModel->create($data);
    }

    // Méthode pour lire un bulletin par ID
    public function readBulletin($id) {
        return $this->bulletinModel->read($id);
    }

    public function readBulletinByStudent($studentId){
        return $this->bulletinModel->findBy("student_id", $studentId);
    }

    // Méthode pour lire tous les bulletins
    public function readAllBulletins() {
        return $this->bulletinModel->readAll();
    }

    // Méthode pour mettre à jour un bulletin
    public function updateBulletin($id, $data) {
        return $this->bulletinModel->update($id, $data);
    }

    // Méthode pour supprimer un bulletin
    public function deleteBulletin($id) {
        return $this->bulletinModel->delete($id);
    }

}
?>
