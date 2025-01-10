<?php

namespace App\Models;

use PDO;
class BulletinModel extends Model {
    protected static $table = 'bulletins';
    protected $fillable = ['student_id', 'class_id', 'period', 'issue_date', 'comments', 'hashes'];

    public $id;
    public $student_id;
    public $class_id;
    public $period;
    public $issue_date;
    public $comments;
    public $hashes;

    public function __construct($db) {
        parent::__construct($db);
    }
}
?>
