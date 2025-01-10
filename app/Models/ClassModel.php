<?php


namespace App\Models;

use PDO;

class ClassModel extends Model {
    protected static $table = 'classes';
    protected $fillable = ['name', 'level', 'total_fee'];

    public $id;
    public $name;
    public String $level;
    public $total_fee;

    public function __construct($db) {
        parent::__construct($db);
    }
}
?>
