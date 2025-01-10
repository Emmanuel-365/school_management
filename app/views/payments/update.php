<?php




$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$paymentController = new PaymentController($db);
$studentController = new StudentController($db);

// Récupérer tous les étudiants pour le formulaire
$students = $studentController->readAllStudents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentId = $_POST['id'];
    $data = [
        'student_id' => $_POST['student_id'],
        'amount' => $_POST['amount'],
    ];

    try {
        $paymentController->updatePayment($paymentId, $data);
        echo 'Payment updated successfully.';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    if (isset($_GET['id'])) {
        $paymentId = $_GET['id'];
        $payment = $paymentController->readPayment($paymentId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Payment</title>
</head>
<body>
    <h1>Update Payment</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($payment) ? $payment->id : ''; ?>">

        <label for="student_id">Student:</label>
        <select id="student_id" name="student_id" required>
            <?php foreach ($students as $student): ?>
                <option value="<?php echo $student->id; ?>" <?php echo isset($payment) && $payment->student_id == $student->id ? 'selected' : ''; ?>><?php echo $student->first_name . ' ' . $student->last_name; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" value="<?php echo isset($payment) ? $payment->amount : ''; ?>" required><br>

        <button type="submit">Update Payment</button>
    </form>
</body>
</html>
