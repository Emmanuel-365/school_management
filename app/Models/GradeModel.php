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
}
?>
