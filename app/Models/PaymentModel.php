<?php

namespace App\Models;

class PaymentModel extends Model {
    protected static $table = 'payments';
    protected $fillable = ['student_id', 'amount'];

    public $id;
    public $student_id;
    public $amount;

    public function __construct($db) {
        parent::__construct($db);
    }
}
