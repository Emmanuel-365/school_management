<?php

namespace App\Models;

use PDO;
class SubjectModel extends Model {
    protected static $table = 'subjects';
    protected $fillable = ['name', 'teacher_id', 'level', 'credit'];

    public $id;
    public $name;
    public $teacher_id;
    public $credit;
    public $level;

    public function __construct($db) {
        parent::__construct($db);
    }

}
?>
