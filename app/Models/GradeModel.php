<?php
namespace App\Models;

use PDO;
class GradeModel extends Model {
    protected static $table = 'grades';
    protected $fillable = ['student_id', 'subject_id', 'grade', 'created_at', 'updated_at', 'type_note'];

    public $id;
    public $student_id;
    public $subject_id;
    public $grade;
    public $created_at;
    public $updated_at;
    public $type_note;

    public function __construct($db) {
        parent::__construct($db);
    }

    public function readAllByLevel($level){
        $sql = "SELECT g.* FROM Subjects s
                JOIN Grades g ON s.id = g.subject_id
                WHERE s.level = :level ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':level', $level);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }
}
?>
