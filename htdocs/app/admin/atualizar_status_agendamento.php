<?php
require_once '../lib/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agendamentoId = $_POST['agendamento_id'];
    $novoStatus = $_POST['novo_status'];

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("UPDATE agendamentos SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $novoStatus);
    $stmt->bindParam(':id', $agendamentoId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: dashboard.php'); // altere para o nome correto da página do admin
    } else {
        echo "Erro ao atualizar o status.";
    }
}
