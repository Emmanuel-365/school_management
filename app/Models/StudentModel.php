<?php

namespace App\Models;

use PDO;

class StudentModel extends UserModel {
    protected static $table = 'students';
    protected $fillable = ['id', 'matricule', 'date_of_birth', 'address', 'class_id', 'parent_id', 'remaining_fee'];

    public $id;
    public $matricule;
    public $date_of_birth;
    public $address;
    public $class_id;
    public $parent_id;
    public $remaining_fee;
    public int $class;
    public int $parent;

    public $status;

    public function __construct($db) {
        parent::__construct($db);
    }

    // Méthode pour compter les étudiants par classe
    public function countStudentsByClass($classId) {
        $sql = "SELECT COUNT(*) FROM " . static::$table . " WHERE class_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$classId]);
        return $stmt->fetchColumn();
    }

    public function countStudents() {
        $sql = "SELECT COUNT(*) FROM " . static::$table;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function readAllWithUsersInformations() {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, u.profile_picture, s.*
                FROM Students s
                INNER JOIN users u on u.id = s.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }

    public function readWithUsersInformations($id) {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, u.username, u.registration_date, s.*
                FROM Students s
                INNER JOIN users u on u.id = s.id
                WHERE s.id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetch();
    }

    public function readByLevel($level) {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, s.*
                FROM Students s
                INNER JOIN users u on u.id = s.id
                INNER JOIN classes c on c.id = s.class_id
                WHERE c.level = :level";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":level", $level);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }

    public function isValidPassword($id){
        $student = $this->readWithUsersInformations($id);
        $password = $this->getPassword($id);
        if(password_verify($student->matricule, $password))
            return false;
        else
            return true;
    }
}
?>

<?php 

