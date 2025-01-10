<?php

namespace App\Models;

use PDO;

class UserModel extends Model {
    protected static $table = 'users';
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'role', 'profile_picture', 'registration_date', 'last_login', 'username', 'password'];

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $role;
    public $profile_picture;
    public $registration_date;
    public $last_login;
    public $username;
    public $password;

    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function verifyCredentials($username, $password) {
        $sql = "SELECT * FROM " . static::$table . " WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        $user = $stmt->fetch();
        return $user && password_verify($password, $user->password) ? $user : null;
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetch();
    }
}
