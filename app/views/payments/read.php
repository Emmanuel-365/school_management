<?php

use App\Config\Database;
use App\Controllers\PaymentController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$paymentController = new PaymentController($db);

if($database->isStudent()){
    $payments = $paymentController->readPaymentsByStudent($_SESSION['user_id']);
}else
    $payments = $paymentController->readAllPayments();
?>

<?php  ?>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search for a payment..." />
            </div>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Amount</th>
            <th>Payment Date</th>
            <!-- <th>Actions</th> -->
        </tr>
        <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?php echo $payment->id; ?></td>
                <td><?php echo $payment->student_id; ?></td>
                <td><?php echo $payment->amount; ?></td>
                <td><?php echo $payment->created_at; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php  ?>
