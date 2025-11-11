<?php
require_once '../lib/Database.php';
$id = $_GET['id'];

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("DELETE FROM clientes WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: dashboard.php");
exit;
