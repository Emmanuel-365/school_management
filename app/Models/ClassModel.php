<?php


namespace App\Models;

use Exception;
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

    function getClassRanksAndAverages($classId) {
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
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Gestion des erreurs
            return ['error' => $e->getMessage()];
        }
    }
}
?>
