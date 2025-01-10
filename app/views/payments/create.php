<?php

use App\Config\Database;
use App\Controllers\PaymentController;
use App\Controllers\StudentController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$paymentController = new PaymentController($db);
$studentController = new StudentController($db);

if(isset($_GET['student_id'])){
    $student = $studentController->readStudent($_GET['student_id']);
    $remaining_fee = $student->remaining_fee;

    echo $remaining_fee;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'student_id' => $_POST['student_id'],
        'amount' => $_POST['amount'],
        'remaining_fee' => $_POST['remaining_fee'],
    ];

    try {
        $paymentController->createPayment($data);
        $remaining_fee_previous = $studentController->readStudent($_POST['student_id'])->remaining_fee;
        $remaining_fee_next = $remaining_fee_previous - $_POST['amount'];
        $studentController->updateStudent($_POST['student_id'], ["remaining_fee" => $remaining_fee_next]);
        header("Location: /students");
        exit;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
}else 
    echo "error";
?>

<?php  ?>
    <h3>Adding Payment page</h3>
    <form method="POST" action="">
        <input type="text" id="student_id" name="student_id" value="<?=$_GET['student_id'] ?>" hidden>

        <div class="form-row">
            <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" step="1" required max="<?=$remaining_fee?>">
            <div class="error-message"></div>
            </div>
        </div>
        <div class="from-row">
            <div class="form-group">
                <label for="remaining_fee">Remaining Fee:</label>
                <input type="number" id="remaining_fee" name="remaining_fee" value="<?php echo isset($student) ? $student->remaining_fee : ''; ?>" required>
            </div>
        </div>
        <center>
            <div class="form-group center">
               <button type="submit">Add Payment</button>
            </div>
        </center>
    </form>
    <?php  ?>

