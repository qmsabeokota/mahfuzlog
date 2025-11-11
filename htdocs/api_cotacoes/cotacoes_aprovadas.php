<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include 'conexao.php';

$sql = "SELECT 
    id,
    cliente_id,
    remetente,
    destinatario,
    mercadoria,
    largura,
    altura,
    comprimento,
    peso,
    valor_frete,
    pagamento,
    status,
    DATE_FORMAT(data_cotacao, '%d/%m/%Y %H:%i') AS data_cotacao
FROM agendamentos
WHERE status = 'Aprovado'
ORDER BY id DESC";

$result = $conn->query($sql);
$cotacoes = [];
while ($row = $result->fetch_assoc()) {
    $cotacoes[] = $row;
}

echo json_encode($cotacoes, JSON_UNESCAPED_UNICODE);
$conn->close();
?>
