<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexao.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["id"])) {
    echo json_encode(["status" => "erro", "mensagem" => "ID da cotação não informado"]);
    exit;
}

$id = intval($data["id"]);

$stmt = $conn->prepare("DELETE FROM cotacoes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "mensagem" => "Cotação excluída com sucesso"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
