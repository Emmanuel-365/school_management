<?php

namespace App\Controllers;

use App\Models\StudentModel;
use Exception;

class StudentController {
    protected $studentModel;
    protected $userController;
    protected $parentController;
    protected $studentCardController;
    protected $classController;
    protected $bulletinController;
    protected $subjectController;
    protected $gradeController;

    public function __construct($db) {
        $this->studentModel = new StudentModel($db);
        $this->userController = new UserController($db);
        $this->parentController = new ParentController($db);
        $this->studentCardController = new StudentCardController($db);
        $this->classController = new ClassController($db);
        $this->bulletinController = new BulletinController($db);
        $this->subjectController = new SubjectController($db);
        $this->gradeController = new GradeController($db);
    }

    // Méthode pour créer un étudiant
    public function createStudent($data) {
        if($data['parent_email'] === $data['email']){
            throw new \Exception('Le mail du parent et de l\'etudiant doivent etre differents');
        }
        // Créer d'abord le parent
        $parentData = [
            'first_name' => $data['parent_first_name'],
            'last_name' => $data['parent_last_name'],
            'email' => $data['parent_email'],
            'phone' => $data['parent_phone'],
            'role' => 'parent',
            'username' => $data['parent_email'],
            'password' => password_hash($data['parent_email'], PASSWORD_BCRYPT),
        ];
        $parentId = $this->parentController->createParent($parentData);

        // Créer l'utilisateur étudiant
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'student',
            'username' => $data['matricule'],
            'password' => password_hash($data['matricule'], PASSWORD_BCRYPT),
            'profile_picture' => $data['profile_picture'],
        ];
        $userId = $this->userController->createUser($userData);

        // Créer l'étudiant
        $studentData = [
            'id' => $userId,
            'matricule' => $data['matricule'],
            'date_of_birth' => $data['date_of_birth'],
            'address' => $data['address'],
            'class_id' => $data['class_id'],
            'parent_id' => $parentId,
            'remaining_fee' => $data['remaining_fee'],
        ];
        $this->studentModel->create($studentData);

        $card_data = [
            'student_id' => $userId,
            'card_number' => $data['matricule'],
            'issue_date' => date('Y-m-d'),
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
        ];
        $this->studentCardController->createStudentCard($card_data);

        $bulletin_data = [
            'student_id' => $userId,
            'class_id' => $data['class_id'],
            'period' => date('Y'),
            'issue_date' => date('Y-m-d'),
        ];
        $this->bulletinController->createBulletin($bulletin_data);
    }

    // Méthode pour lire un étudiant par ID
    public function readStudent($id): StudentModel {
        $student = $this->studentModel->read($id);
        return $student;
    }

    public function readStudentWithUsersInformations($id):StudentModel {
        $student =  $this->studentModel->readWithUsersInformations($id);
        $this->getStatus($student);
        return $student;
    }

    // Méthode pour lire tous les étudiants
    /**
     * @return StudentModel[]
     */
    public function readAllStudents() {
        $students = $this->studentModel->readAll();
        foreach ($students as $student) {
            $this->getStatus($student);
        }
        return $students;
    }

    public function readAllStudentsWithUsersInformations() {
        $students = $this->studentModel->readAllWithUsersInformations();
        foreach ($students as $student) {
            $this->getStatus($student);
        }
        return $students;
    }

    public function readStudentsByLevel($level) {
        return $this->studentModel->readByLevel($level);
    }

    // Méthode pour mettre à jour un étudiant
    public function updateStudent($id, $data) {
        // Vérifier si l'email est présent dans $data
        if (array_key_exists('email', $data)) {
            // Mettre à jour l'utilisateur via userController si un email est fourni
            $this->userController->updateuser($id, $data);
        }
        
        // Toujours mettre à jour les informations de l'étudiant
        return $this->studentModel->update($id, $data);
    }
    
    // Méthode pour supprimer un étudiant
    public function deleteStudent($id) {
        $student = $this->readStudent($id);
        $parent_Id = $student->parent_id;
        $this->studentModel->delete($id);
        $this->userController->deleteUser($id);
        $this->userController->deleteUser($parent_Id);
    }

    // Méthode pour compter les étudiants par classe
    public function countStudentsByClass($classId) {
        return $this->studentModel->countStudentsByClass($classId);
    }

    public function checkIsValidPassword($id){
        return $this->studentModel->isValidPassword($id);
    }

    public function countStudents(){
        return $this->studentModel->countStudents();
    }

    public function getStatus(&$student)
{
    // Vérification de `remaining_fee` et debug initial
    if (!isset($student->remaining_fee) || !is_numeric($student->remaining_fee)) {
            throw new Exception("Le champ `remaining_fee` est invalide ou non défini.");
        }

        // Récupérer les frais totaux pour la classe
        $class = $this->classController->readClass($student->class_id);
        if (!$class || !isset($class->total_fee)) {
            throw new Exception("Impossible de récupérer `total_fee` pour la classe avec ID: " . $student->class_id);
        }

        $totalFee = (float)$class->total_fee; // Convertir en float pour éviter les problèmes de type
        $remainingFee = (float)$student->remaining_fee; // Convertir en float pour éviter les problèmes de type

        // Calculer le statut
        if ($remainingFee == 0) {
            $student->status = "payée";
        } elseif ($remainingFee <= $totalFee / 2) {
            $student->status = "solvable";
        } else {
            $student->status = "non solvable";
        }

        // Debugging pour valider les données
        // var_dump([
        //     'remaining_fee' => $remainingFee,
        //     'total_fee' => $totalFee,
        //     'status' => $student->status,
        // ]);
    }

    public function getRankBySubject($studentId){
        $classId = $this->studentModel->read($studentId)->class_id;
        $level = $this->classController->readClass($classId)->level;
        $allgrades = $this->gradeController->readAllGradesByLevel($level);
        $finalGrades = [];
    
        foreach ($allgrades as $grade) {
            $student_id = $grade->student_id;
            $subject_id = $grade->subject_id;
            $type_note = $grade->type_note;
            $gradeValue = $grade->grade;
    
            if (!isset($finalGrades[$student_id][$subject_id])) {
                $finalGrades[$student_id][$subject_id] = [
                    'cc' => 0,
                    'tp' => 0,
                    'exam' => 0,
                    'rattrapage' => 0,
                ];
            }
    
            if (isset($finalGrades[$student_id][$subject_id][$type_note])) {
                $finalGrades[$student_id][$subject_id][$type_note] = $gradeValue;
            }
        }
    
        $subjectFinalGrades = [];
    
        foreach($finalGrades as $student_id => $student_grades){
            foreach ($student_grades as $subject_id => $notes) {
                $cc = $notes['cc'];
                $tp = $notes['tp'];
                $exam = $notes['exam'];
                $rattrapage = $notes['rattrapage'];
    
                if ($rattrapage > $exam) {
                    $exam = $rattrapage;
                }
    
                $finalGrade = ($cc * 0.2) + ($tp * 0.4) + ($exam * 0.4);
                $subjectFinalGrades[$student_id][$subject_id] = $finalGrade;
            }
        }
    
        $rangs = [];
    
        foreach ($subjectFinalGrades as $etudiant => $matieres) {
            foreach ($matieres as $matiere => $note) {
                $rangs[$matiere][$etudiant] = $note;
            }
        }
    
        foreach ($rangs as $matiere => &$etudiants) {
            arsort($etudiants);
            
            $rank = 1;
            $prevNote = null;
            $sameRankCount = 0;
            
            foreach ($etudiants as $etudiant => $note) {
                if ($note === $prevNote) {
                    $sameRankCount++;
                } else {
                    $rank += $sameRankCount;
                    $sameRankCount = 1;
                }
                $prevNote = $note;
                $etudiants[$etudiant] = $rank;
            }
            unset($etudiants);
        }
    
        // Préparer le résultat final pour l'étudiant spécifié
        $result = [];
        foreach ($rangs as $matiere => $classement) {
            if (isset($classement[$studentId])) {
                $result[$matiere] = [
                    'rank' => $classement[$studentId],
                    'grade' => $subjectFinalGrades[$studentId][$matiere],
                ];
            }
        }
    
        return $result; // Retourne les notes et rangs de l'étudiant spécifié
    }
    

    public function getStudentTotalAverageAndRank($studentId, $classId){
        return $this->studentModel->getStudentRankAndAverage($studentId, $classId);
    }


}
?>
