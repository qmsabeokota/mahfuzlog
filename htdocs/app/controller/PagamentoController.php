<?php
session_start();

require_once '../model/PagamentoMercadoPago.php';
require_once '../lib/PHPMailer/PHPMailer.php';
require_once '../lib/PHPMailer/SMTP.php';
require_once '../lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

// Conexão com banco
$conn = new mysqli("localhost", "root", "", "sistema_cadastro");
if ($conn->connect_error) die("Erro na conexão: " . $conn->connect_error);

// Verifica cotação
if (isset($_POST['cotacao_id'])) {
    $_SESSION['cotacao_id'] = (int)$_POST['cotacao_id'];
}

if (!isset($_SESSION['cotacao_id'], $_SESSION['cliente_id'])) {
    die("Cotação ou cliente não definidos.");
}

$id_cotacao = $_SESSION['cotacao_id'];
$cliente_id = $_SESSION['cliente_id'];
$metodo = $_POST['metodo'] ?? '';

// Agora só aceitamos Mercado Pago
if ($metodo !== 'mercadopago') {
    die("Método de pagamento inválido.");
}

// Buscar dados da cotação, incluindo o tipo de pagamento
$sql = "SELECT valor_frete, mercadoria, pagamento FROM cotacoes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cotacao);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    die("Cotação não encontrada.");
}

$valor = (float) $row['valor_frete'];
$nome_item = $row['mercadoria'];
$tipo_pagamento = $row['pagamento']; // 'pix' ou 'cartao'

// Buscar email do cliente
$sql = "SELECT email FROM clientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    die("Cliente não encontrado.");
}

$email_cliente = $row['email'];

// Enviar e-mail (opcional)
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
date_default_timezone_set('America/Sao_Paulo');

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contamahfuzlog@gmail.com';
    $mail->Password   = 'xoax oicn oejm qsig'; // senha de app
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('contamahfuzlog@gmail.com', 'MahfuzLog');
    $mail->addAddress($email_cliente);

    $mail->isHTML(true);
    $mail->Subject = 'Início de Pagamento da Cotação #' . $id_cotacao;
    $mail->Body = "
        <h2>Pagamento Iniciado!</h2>
        <p>Olá, sua cotação <strong>#$id_cotacao</strong> está pronta para pagamento.</p>
        <p><strong>Item:</strong> {$nome_item}</p>
        <p><strong>Valor:</strong> R$ " . number_format($valor, 2, ',', '.') . "</p>
        <p>Data: " . date('d/m/Y H:i') . "</p>
        <p>Obrigado por usar a MahfuzLog!</p>";
    $mail->send();
} catch (Exception $e) {
    error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
}

// Processar pagamento Mercado Pago
$pagamento = new PagamentoMercadoPago();
$tipo_mp = ($tipo_pagamento === 'pix') ? 'pix' : 'normal';
$resultado = $pagamento->pagar($tipo_mp, $id_cotacao, $valor, $nome_item, $email_cliente);


// Exibir resultado
if (isset($resultado['sucesso'])) {
    if (is_array($resultado['sucesso'])) {
        header("Location: "  . htmlspecialchars($resultado['sucesso']['link_pix']));

        echo "<p style='color:green;'><strong>Seu pedido foi agendado com sucesso!</strong></p>";

    } else {
        // Checkout normal
        echo "<p style='color:green;'><strong>Seu pedido foi agendado com sucesso!</strong></p>";
        header("Location: " . $resultado['sucesso']);
        exit;
    }
} else {
    echo "<h3>Erro no pagamento via Mercado Pago</h3>";
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";
}

$conn->close();
?>