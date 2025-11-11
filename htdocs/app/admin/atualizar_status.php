<?php
require_once '../lib/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cotacao_id = $_POST['cotacao_id'];
    $novo_status = $_POST['novo_status'];

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("UPDATE cotacoes SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $novo_status, ':id' => $cotacao_id]);
}

header("Location: dashboard.php");
exit;
