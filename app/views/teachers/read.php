<?php

use App\Config\Database;
use App\Controllers\TeacherController;


$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$teacherController = new TeacherController($db);

// Lire tous les enseignants
$teachers = $teacherController->readAllTeachersWithUsersInformations();
?>

<?php  ?>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search for a student..." />
                <a href="/teachers/create" class="add-button">Add Teacher</a>
            </div>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Specialty</th>
            <th>Hire Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($teachers as $teacher): ?>
            <tr>
                <td><?php echo $teacher->id; ?></td>
                <td><?php echo $teacher->first_name; ?></td>
                <td><?php echo $teacher->last_name; ?></td>
                <td><?php echo $teacher->email; ?></td>
                <td><?php echo $teacher->specialty; ?></td>
                <td><?php echo $teacher->hire_date; ?></td>
                <td><?php echo $teacher->status; ?></td>
                <td>
                    <a href="/teachers/update?id=<?php echo $teacher->id; ?>"  class="action-button update"><i class="fa-solid fa-pen-to-square"></i></a> 
                    <a href="/teachers/delete?id=<?php echo $teacher->id; ?>"  class="action-button delete"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php  ?>
