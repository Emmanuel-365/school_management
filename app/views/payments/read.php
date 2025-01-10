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

<?php
// Assuming $payments is your array of all payments
$itemsPerPage = 5;
$totalPages = ceil(count($payments) / $itemsPerPage);
$currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
$currentPagePayments = array_slice($payments, $offset, $itemsPerPage);
?>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search for a payment..." />
            </div>
    <table >
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Amount</th>
            <th>Payment Date</th>
            <!-- <th>Actions</th> -->
        </tr>
        <?php foreach ($currentPagePayments as $payment): ?>
            <tr>
                <td><?php echo $payment->id; ?></td>
                <td><?php echo $payment->student_id; ?></td>
                <td><?php echo $payment->amount; ?></td>
                <td><?php echo $payment->created_at; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if (count($payments) > 5): ?>
    <div class="navigation">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>" id="prevPage" class="nav-button prev-button">
                <i class="fas fa-chevron-left"></i> Précédent
            </a>
        <?php endif; ?>
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>" id="nextPage" class="nav-button next-button">
                Suivant <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
