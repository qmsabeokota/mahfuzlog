<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include 'conexao.php';

// Recebe via application/json ou form-data — aqui consideramos form-data/post fields
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    // fallback para form-data
    $input = $_POST;
}

$cliente_id = intval($input['cliente_id'] ?? 0);
$remetente = $conn->real_escape_string($input['remetente'] ?? '');
$destinatario = $conn->real_escape_string($input['destinatario'] ?? '');
$mercadoria = $conn->real_escape_string($input['mercadoria'] ?? '');
$largura = floatval($input['largura'] ?? 0);
$altura = floatval($input['altura'] ?? 0);
$comprimento = floatval($input['comprimento'] ?? 0);
$peso = floatval($input['peso'] ?? 0);
$valor_frete = floatval($input['valor_frete'] ?? 0);
$pagamento = $conn->real_escape_string($input['pagamento'] ?? 'pix');

$sql = "INSERT INTO cotacoes (
    cliente_id, remetente, destinatario, mercadoria,
    largura, altura, comprimento, peso, valor_frete, pagamento, data_cotacao, status
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Em análise')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssddddds", $cliente_id, $remetente, $destinatario, $mercadoria, $largura, $altura, $comprimento, $peso, $valor_frete, $pagamento);
// Note: bind_param types must match — adjust if necessary; for safety simpler approach below:

// Simples fallback (sem bind) — caso prefira:
$sql2 = "INSERT INTO cotacoes (cliente_id, remetente, destinatario, mercadoria, largura, altura, comprimento, peso, valor_frete, pagamento, data_cotacao, status)
VALUES ($cliente_id, '$remetente', '$destinatario', '$mercadoria', $largura, $altura, $comprimento, $peso, $valor_frete, '$pagamento', NOW(), 'Em análise')";

if ($conn->query($sql2) === TRUE) {
    echo json_encode(["status"=>"sucesso","mensagem"=>"Cotação inserida"]);
} else {
    echo json_encode(["status"=>"erro","mensagem"=>"Erro: " . $conn->error]);
}

$conn->close();
?>
