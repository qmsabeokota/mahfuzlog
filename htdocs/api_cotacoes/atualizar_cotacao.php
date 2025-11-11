<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
include 'conexao.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["id"])) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados inválidos ou ID ausente"]);
    exit;
}

$id = intval($data["id"]);
$remetente = $data["remetente"];
$destinatario = $data["destinatario"];
$mercadoria = $data["mercadoria"];
$largura = $data["largura"];
$altura = $data["altura"];
$comprimento = $data["comprimento"];
$peso = $data["peso"];
$valor_frete = $data["valor_frete"];
$pagamento = $data["pagamento"];

$sql = "UPDATE cotacoes SET 
    remetente = ?, 
    destinatario = ?, 
    mercadoria = ?, 
    largura = ?, 
    altura = ?, 
    comprimento = ?, 
    peso = ?, 
    valor_frete = ?, 
    pagamento = ?
WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssddddssi", 
    $remetente, 
    $destinatario, 
    $mercadoria, 
    $largura, 
    $altura, 
    $comprimento, 
    $peso, 
    $valor_frete, 
    $pagamento, 
    $id
);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "mensagem" => "Cotação atualizada com sucesso"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
