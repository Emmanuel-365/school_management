<?php

use App\Config\Database;
use App\Controllers\PaymentController;
use App\Controllers\StudentController;

$database = new Database();

$db = $database->getConnection();


// Initialisation des contrôleurs
$paymentController = new PaymentController($db);
$studentController = new StudentController($db);

if($database->isStudent()){
    $payments = $paymentController->readPaymentsByStudent($_SESSION['user_id']);
}else
    $payments = $paymentController->readAllPayments();
?>


            <div class="search-container">
                <input type="text" id="search" data-translate-placeholder="search_placeholder" />
            </div>
    <table >
        <tr>
            <th>ID</th>
            <th data-translate="student">Student</th>
            <th data-translate="amount">Amount</th>
            <th data-translate="date_payment">Payment Date</th>
            <!-- <th>Actions</th> -->
        </tr>
        <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?php echo $payment->id; ?></td>
                <td><?php echo  $studentController->readStudentWithUsersInformations($payment->student_id)->first_name . ' ' . $studentController->readStudentWithUsersInformations($payment->student_id)->last_name ; ?></td>
                <td><?php echo $payment->amount; ?></td>
                <td><?php echo $payment->created_at; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="navigation">
    <button id="prevPage" class="nav-button" data-translate="previous" disabled></button>
    <button id="nextPage" class="nav-button" data-translate="next"></button>
</div>

<script>
    const allPayments = <?= json_encode($payments) ?>; // Les paiements récupérés depuis PHP
    const itemsPerPage = 5; // Nombre d'éléments par page
    let currentPage = 1;

    // Fonction pour afficher les paiements dans le tableau
    function renderTable(payments) {
        const tbody = document.querySelector('#paymentsTable tbody');
        tbody.innerHTML = ''; // Réinitialiser le tableau

        payments.forEach((payment) => {
            const row = `
                <tr>
                    <td>${payment.id}</td>
                    <td>${payment.student_id}</td>
                    <td>${payment.amount}</td>
                    <td>${payment.created_at}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // Fonction pour gérer la pagination
    function paginatePayments(page, payments = allPayments) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paymentsForPage = payments.slice(start, end);

        renderTable(paymentsForPage);

        // Gérer les boutons de navigation
        document.getElementById('prevPage').disabled = page === 1;
        document.getElementById('nextPage').disabled = end >= payments.length;
    }

    // Fonction pour rechercher des paiements
    function filterPayments(query) {
        const filteredPayments = allPayments.filter((payment) => {
            const studentId = (payment.student_id || '').toString().toLowerCase();
            const amount = (payment.amount || '').toString().toLowerCase();
            const paymentDate = (payment.created_at || '').toLowerCase();

            return (
                studentId.includes(query) ||
                amount.includes(query) ||
                paymentDate.includes(query)
            );
        });

        currentPage = 1; // Réinitialiser à la première page
        paginatePayments(currentPage, filteredPayments);
    }

    // Écouteurs pour les boutons de pagination
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginatePayments(currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const totalPages = Math.ceil(allPayments.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginatePayments(currentPage);
        }
    });

    // Écouteur pour la recherche
    document.getElementById('search').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query) {
            filterPayments(query);
        } else {
            paginatePayments(currentPage);
        }
    });

    // Initialisation de la pagination
    paginatePayments(currentPage);
</script>
