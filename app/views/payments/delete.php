<?php




$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$paymentController = new PaymentController($db);
$studentController = new StudentController($db);

if (isset($_GET['id'])) {
    $student_id = $paymentController->readPayment($_GET['id'])->student_id;
    $student_remaining_payment_previous = $studentController->readStudent($student_id)->remaining_fee;
    $amount = $paymentController->readPayment($_GET['id'])->amount;
    $remaining_payment_new = $student_remaining_payment_previous + $amount;
    $paymentId = $_GET['id'];
    try {
        $paymentController->deletePayment($paymentId);
        $studentController->updateStudent($student_id, ["remaining_fee" => $remaining_fee_new²]);
        header("Location: /payments");
        exit;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Payment ID not provided.';
}
?>
