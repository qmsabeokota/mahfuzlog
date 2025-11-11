<?php
session_start(); // Inicia a sessão

// === Carrega PHPMailer ===
require_once __DIR__ . '/../lib/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer/SMTP.php';
require_once __DIR__ . '/../lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// === Conexão com o banco de dados ===
$conn = new mysqli("localhost", "root", "", "sistema_cadastro");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// === Verifica se cotação está na sessão ===
if (!isset($_SESSION['cotacao_id'])) {
    die("Nenhuma cotação selecionada.");
}

$id_cotacao = (int)$_SESSION['cotacao_id'];

// === Verifica se cliente está na sessão ===
if (!isset($_SESSION['cliente_id'])) {
    die("Cliente não autenticado.");
}

$cliente_id = (int)$_SESSION['cliente_id'];

// === Busca valor da cotação ===
$sql = "SELECT valor_frete, mercadoria FROM cotacoes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cotacao);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $valor = (float)$row['valor_frete'];
    $nome_item = $row['mercadoria']; // Novo campo


    // === Busca e-mail do cliente ===
    $sqlCliente = "SELECT email FROM clientes WHERE id = ?";
    $stmtCliente = $conn->prepare($sqlCliente);
    $stmtCliente->bind_param("i", $cliente_id);
    $stmtCliente->execute();
    $resultCliente = $stmtCliente->get_result();

    if ($rowCliente = $resultCliente->fetch_assoc()) {
        $email_cliente = $rowCliente['email'];

        // === Envia e-mail ===
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'contamahfuzlog@gmail.com';
            $mail->Password   = 'xoax oicn oejm qsig';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('contamahfuzlog@gmail.com', 'MahfuzLog');
            $mail->addAddress($email_cliente);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmação de Pagamento da Cotação #' . $id_cotacao;
            $mail->Body = "
                <h2>Pagamento Confirmado!</h2>
                <p>Olá, seu pagamento da cotação <strong>#$id_cotacao</strong> foi processado com sucesso.</p>
                <p><strong>Item:</strong> {$nome_item}</p>
                <p><strong>Valor:</strong> R$ " . number_format($valor, 2, ',', '.') . "</p>
                <p>Data: " . date('d/m/Y H:i') . "</p>
                <p>Obrigado por usar a MahfuzLog!</p>";

            $mail->send();

        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        }

        // === Cria pagamento no Mercado Pago ===
        $access_token = 'TEST-1969778664286283-052220-20e502da1f109e70df9e91eb89295692-218099717';

        $dados = [
            "items" => [
                [
                    "title" => "Pagamento da Cotação #" . $id_cotacao,
                    "quantity" => 1,
                    "currency_id" => "BRL",
                    "unit_price" => $valor
                ]
            ],
            "back_urls" => [
                "success" => "https://seusite.com/sucesso.php",
                "failure" => "https://seusite.com/falha.php",
                "pending" => "https://seusite.com/pendente.php"
            ],
            "auto_return" => "approved"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $access_token
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

        $resposta = curl_exec($ch);
        curl_close($ch);

        $resultado = json_decode($resposta, true);

        if (isset($resultado['init_point'])) {
            echo "<a href='{$resultado['init_point']}' target='_blank'>Pagar agora</a>";
        } else {
            echo "Erro ao criar pagamento: ";
            print_r($resultado);
        }

    } else {
        echo "Cliente não encontrado.";
    }

} else {
    echo "Cotação não encontrada.";
}

$stmt->close();
$stmtCliente->close();
$conn->close();
?>
