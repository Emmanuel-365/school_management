<?php
namespace App\Controllers;
use App\Models\PaymentModel;
class PaymentController {
    protected $paymentModel;

    public function __construct($db) {
        $this->paymentModel = new PaymentModel($db);
    }

    // Méthode pour créer un paiement
    public function createPayment($data) {
        return $this->paymentModel->create($data);
    }

    // Méthode pour lire un paiement par ID
    public function readPayment($id) {
        return $this->paymentModel->read($id);
    }

    public function readPaymentsByStudent($id) {
        return $this->paymentModel->findManyBy('student_id', $id);
    }

    // Méthode pour lire tous les paiements
    public function readAllPayments() {
        return $this->paymentModel->readAll();
    }

    // Méthode pour mettre à jour un paiement
    public function updatePayment($id, $data) {
        return $this->paymentModel->update($id, $data);
    }

    // Méthode pour supprimer un paiement
    public function deletePayment($id) {
        return $this->paymentModel->delete($id);
    }
}
?>
