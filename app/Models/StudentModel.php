<?php

namespace App\Models;

use Exception;
use PDO;

class StudentModel extends UserModel {
    protected static $table = 'students';
    protected $fillable = ['id', 'matricule', 'date_of_birth', 'address', 'class_id', 'parent_id', 'remaining_fee'];

    public $id;
    public $matricule;
    public $date_of_birth;
    public $address;
    public $class_id;
    public $parent_id;
    public $remaining_fee;
    public int $class;
    public int $parent;

    public $status;

    public function __construct($db) {
        parent::__construct($db);
    }

    // Méthode pour compter les étudiants par classe
    public function countStudentsByClass($classId) {
        $sql = "SELECT COUNT(*) FROM " . static::$table . " WHERE class_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$classId]);
        return $stmt->fetchColumn();
    }

    public function countStudents() {
        $sql = "SELECT COUNT(*) FROM " . static::$table;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function readAllWithUsersInformations() {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, u.profile_picture, s.*
                FROM Students s
                INNER JOIN users u on u.id = s.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }

    public function readWithUsersInformations($id) {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, u.username, u.registration_date, s.*
                FROM Students s
                INNER JOIN users u on u.id = s.id
                WHERE s.id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetch();
    }

    public function readByLevel($level) {
        $query = "SELECT u.first_name, u.last_name, u.email, u.phone, s.*
                FROM Students s
                INNER JOIN users u on u.id = s.id
                INNER JOIN classes c on c.id = s.class_id
                WHERE c.level = :level";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":level", $level);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }

    public function isValidPassword($id){
        $student = $this->readWithUsersInformations($id);
        $password = $this->getPassword($id);
        if(password_verify($student->matricule, $password))
            return false;
        else
            return true;
    }

    function getStudentRankAndAverage($studentId, $classId) {
        try {
            // SQL pour récupérer les moyennes des étudiants et calculer le rang
            $sql = "
                SELECT
                    g.student_id,
                    s.class_id,
                    SUM(
                        (
                            CASE 
                                WHEN g.type_note = 'cc' THEN g.grade * 0.2
                                WHEN g.type_note = 'tp' THEN g.grade * 0.4
                                WHEN g.type_note = 'exam' THEN 
                                    CASE 
                                        WHEN EXISTS (
                                            SELECT 1
                                            FROM grades r
                                            WHERE r.student_id = g.student_id
                                            AND r.subject_id = g.subject_id
                                            AND r.type_note = 'rattrapage'
                                            AND r.grade > g.grade
                                        )
                                        THEN 0 -- Annule la note d'exam si une note de rattrapage existe
                                        ELSE g.grade * 0.4
                                    END
                                WHEN g.type_note = 'rattrapage' THEN g.grade * 0.4 -- Utilise la note de rattrapage
                                ELSE 0
                            END
                        ) * sub.credit
                    ) / total_class_credits.total_credits AS weighted_average,
                    total_class_credits.total_credits, -- Somme des crédits de la classe
                    RANK() OVER (
                        PARTITION BY s.class_id 
                        ORDER BY SUM(
                            (
                                CASE 
                                    WHEN g.type_note = 'cc' THEN g.grade * 0.2
                                    WHEN g.type_note = 'tp' THEN g.grade * 0.4
                                    WHEN g.type_note = 'exam' THEN 
                                        CASE 
                                            WHEN EXISTS (
                                                SELECT 1
                                                FROM grades r
                                                WHERE r.student_id = g.student_id
                                                AND r.subject_id = g.subject_id
                                                AND r.type_note = 'rattrapage'
                                                AND r.grade > g.grade
                                            )
                                            THEN 0
                                            ELSE g.grade * 0.4
                                        END
                                    WHEN g.type_note = 'rattrapage' THEN g.grade * 0.4
                                    ELSE 0
                                END
                            ) * sub.credit
                        ) / total_class_credits.total_credits DESC
                    ) AS rank_in_class
                FROM grades g
                JOIN students s ON g.student_id = s.id
                JOIN subjects sub ON g.subject_id = sub.id
                JOIN classes c ON s.class_id = c.id
                JOIN (
                    -- Sous-requête pour calculer la somme des crédits de la classe
                    SELECT c.id AS class_id, SUM(sub.credit) AS total_credits
                    FROM classes c
                    JOIN subjects sub ON c.level = sub.level
                    WHERE c.id = :class_id
                    GROUP BY c.id
                ) total_class_credits ON c.id = total_class_credits.class_id
                WHERE s.class_id = :class_id 
                GROUP BY g.student_id, s.class_id, total_class_credits.total_credits;

            ";
    
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':class_id', $classId, PDO::PARAM_INT);
            $stmt->execute();
    
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Trouver les informations pour l'étudiant spécifié
            foreach ($results as $row) {
                if ($row['student_id'] == $studentId) {
                    return [
                        'rank' => $row['rank_in_class'],
                        'average' => $row['weighted_average']
                    ];
                }
            }
    
            // Si l'étudiant n'est pas trouvé
            return null;
        } catch (Exception $e) {
            // Gestion des erreurs
            return ['error' => $e->getMessage()];
        }
    }


    
    
    
    
    
}



