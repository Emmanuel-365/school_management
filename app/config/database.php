<?php
namespace App\Config;   
use PDO;
use PDOException;
// config/Database.php
date_default_timezone_set('Europe/Paris');

if(session_status() == PHP_SESSION_NONE) session_start();

class Database {
    private $dbHost = 'localhost';
    private $dbName = 'school_management';
    private $dbUser = 'Emmanuel';
    private $dbPass = '';
    private $pdo;

    public function __construct() {
        $this->connect();
    }

    private function connect(): void {
        try {
            $this->pdo = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database $this->dbName :" . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    function isAdmin(): bool {
        if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin')
            return true;
        else
            return false;
    }
    
    function isTeacher(): bool {
        if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'teacher')
            return true;
        else
            return false;
    }
    
    function isStudent(): bool {
        if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'student')
            return true;
        else
            return false;
    }
}
?>

<?php 

function isAdmin(): bool {
    if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin')
        return true;
    else
        return false;
}

function isTeacher(): bool {
    if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'teacher')
        return true;
    else
        return false;
}

function isStudent(): bool {
    if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'student')
        return true;
    else
        return false;
}

?>
