<?php

namespace App\Models;

use PDO;
class StudentCardModel extends Model {
    protected static $table = 'student_cards';
    protected $fillable = ['student_id', 'card_number', 'issue_date', 'expiry_date'];

    public $id;
    public $student_id;
    public $card_number;
    public $issue_date;
    public $expiry_date;

    public function __construct($db) {
        parent::__construct($db);
    }
}
?>
