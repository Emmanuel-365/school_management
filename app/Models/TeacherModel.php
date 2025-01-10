<?php


namespace App\Models;

use PDO;

class TeacherModel extends UserModel {
    protected static $table = 'teachers';
    protected $fillable = ['id', 'specialty', 'hire_date', 'status'];

    public $id;
    public $specialty;
    public $hire_date;
    public $status;

    public function __construct($db) {
        parent::__construct($db);
    }

    public function readAllWithUsersInformations() {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, t.*
                FROM Teachers t
                INNER JOIN users u on u.id = t.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }

    public function readWithUsersInformations($id) {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, t.*
                FROM Teachers t
                INNER JOIN users u on u.id = t.id
                WHERE t.id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetch();
    }
}
?>
