<?php

use App\Config\Database;
use App\Controllers\ClassController;

$database = new Database();
$db = $database->getConnection();

// Initialisation des contrôleurs
$classController = new ClassController($db);

$classes = $classController->readAllClasses();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'level' => $_POST['level'],
        'total_fee' => $_POST['total_fee'],
    ];

    try {
        $classController->createClass($data);
        header('Location: /classes');
        exit();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
<?php  ?>
    <h3>Adding Class page</h3>
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Ex: Classe 3" required>
            </div>
            <div class="form-group ">
            <label for="level">Level:</label>
        <select id="level"  name="level" required data-classes='<?= json_encode($classes) ?>'>
            <option value="Bachelor 1">Bachelor 1</option>
            <option value="Bachelor 2">Bachelor 2</option>
            <option value="Bachelor 3">Bachelor 3</option>
            <option value="Master 1">Master 1</option>
            <option value="Master 2">Master 2</option>
        </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
            <label for="total_fee">Total Fee:</label>
            <input type="number" id="total_fee" name="total_fee" required>
            </div>
        </div>
        <center>
        <div class="form-group center">
        <button type="submit">Create Class</button>
        </div>
        </center>
    </form>
    <script>
        const updateTotalFees = () => {
            let found = false;

            classes.forEach(classe => {
                if (classe["level"] === level.value) {
                    if (classe["total_fee"] !== undefined && classe["total_fee"] !== null) {
                        totalFee.value = classe["total_fee"];
                    } else {
                        totalFee.value = 0; // Valeur par défaut si "total_fee" est manquant
                    }
                    totalFee.readOnly = true;
                    found = true;
                }
            });

            if (!found) {
                totalFee.value = 0; // Valeur par défaut si aucun niveau correspondant n'est trouvé
                totalFee.readOnly = false;
            }
        };

        const level = document.querySelector('#level');
        const totalFee = document.querySelector('#total_fee')
        const classes = JSON.parse(level.dataset.classes)
        updateTotalFees()
        level.addEventListener('change', updateTotalFees)
    </script>
<?php  ?>