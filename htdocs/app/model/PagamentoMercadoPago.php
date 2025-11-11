<?php

class PagamentoMercadoPago {

    private $access_token_padrao = 'TEST-1969778664286283-052220-20e502da1f109e70df9e91eb89295692-218099717';
    private $access_token_pix = 'TEST-193117625704418-052918-0b04133cb6398f820943dc5bfc748f84-218099717';

    public function pagar($metodo, $id_cotacao, $valor, $descricao, $email_payer = null) {
        if ($metodo === 'pix') {
            return $this->criarPagamentoPIX($id_cotacao, $valor, $descricao, $email_payer);
        } else {
            return $this->criarPagamentoNormal($id_cotacao, $valor, $descricao);
        }
    }

    private function criarPagamentoNormal($id_cotacao, $valor, $nome_item) {
        $dados = [
            "items" => [
                [
                    "title" => "Pagamento da Cotação #" . $id_cotacao,
                    "quantity" => 1,
                    "currency_id" => "BRL",
                    "unit_price" => (float) $valor
                ]
            ],
            "back_urls" => [
                "success" => "https://localhost/app/view/areacliente.php",
                "failure" => "https://localhost/app/view/homepage.php",
                "pending" => "https://localhost/app/view/homepage.php"
            ],
            "auto_return" => "approved"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->access_token_padrao
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

        $resposta = curl_exec($ch);

        if ($resposta === false) {
            $erro = curl_error($ch);
            curl_close($ch);
            error_log("Erro cURL MercadoPago criarPagamentoNormal: " . $erro);
            return ["erro" => "Erro cURL: " . $erro];
        }

        curl_close($ch);

        $resultado = json_decode($resposta, true);

        if (isset($resultado['init_point'])) {
            $this->criarAgendamentoApartirDaCotacao($id_cotacao);
            return ["sucesso" => $resultado['init_point']];
        } else {
            error_log("Erro ao criar pagamento normal MercadoPago: " . json_encode($resultado));
            return ["erro" => "Erro na criação do pagamento", "detalhes" => $resultado];
        }
    }

    private function criarPagamentoPIX($id_cotacao, $valor, $descricao, $email_payer) {
        $url = 'https://api.mercadopago.com/v1/payments';

        $payload = [
            "transaction_amount" => (float) $valor,
            "description" => $descricao,
            "payment_method_id" => "pix",
            "external_reference" => (string) $id_cotacao,
            "payer" => [
                "email" => $email_payer
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->access_token_pix,
            'X-Idempotency-Key: ' . uniqid('cotacao_' . $id_cotacao . '_')
        ]);
        curl_setopt($ch, CURLOPT_POST, true);

        $response = curl_exec($ch);

        if ($response === false) {
            $erro = curl_error($ch);
            curl_close($ch);
            error_log("Erro cURL MercadoPago criarPagamentoPIX: " . $erro);
            return ['erro' => 'Erro cURL: ' . $erro];
        }

        curl_close($ch);

        $res = json_decode($response, true);

        if (
            isset($res['id']) &&
            isset($res['point_of_interaction']['transaction_data']['qr_code']) &&
            isset($res['point_of_interaction']['transaction_data']['qr_code_base64'])
        ) {
            $this->criarAgendamentoApartirDaCotacao($id_cotacao);
            return [
                'sucesso' => [
                    'id_pagamento' => $res['id'],
                    'qr_code' => $res['point_of_interaction']['transaction_data']['qr_code'],
                    'qr_code_base64' => $res['point_of_interaction']['transaction_data']['qr_code_base64'],
                    'link_pix' => $res['point_of_interaction']['transaction_data']['ticket_url'] ?? null
                ]
            ];
        }

        error_log("Falha ao criar pagamento PIX MercadoPago: " . json_encode($res));
        return ['erro' => 'Falha ao criar pagamento PIX', 'detalhes' => $res];
    }

    public function criarAgendamentoApartirDaCotacao($id_cotacao) {
        global $conn; // variável mysqli global

        $stmt = $conn->prepare("SELECT * FROM cotacoes WHERE id = ?");
        $stmt->bind_param("i", $id_cotacao);
        $stmt->execute();
        $result = $stmt->get_result();
        $cotacao = $result->fetch_assoc();
        $stmt->close();

        if (!$cotacao) {
            error_log("Cotação não encontrada para gerar agendamento: ID $id_cotacao");
            return;
        }

        $data_envio = $cotacao['data_envio'];
        $data_entrega_estimanda = date('Y-m-d H:i:s', strtotime($data_envio . ' +3 days'));

        $sql = "INSERT INTO agendamentos (
                    cliente_id, remetente, cliente_remetente, endereco_remetente,
                    destinatario, cliente_destinatario, endereco_destinatario,
                    tomador, endereco_tomador, pagamento, mercadoria, largura,
                    altura, comprimento, volume, peso, observacoes, data_envio,
                    data, status, valor_frete, data_cotacao, data_entrega_estimanda
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("Erro prepare inserir agendamento: " . $conn->error);
            return;
        }

        $status = 'Agendado';
        $data_atual = date('Y-m-d H:i:s');

        $stmt->bind_param(
            "issssssssssddddddsssdss",
            $cotacao['cliente_id'],
            $cotacao['remetente'],
            $cotacao['cliente_remetente'],
            $cotacao['endereco_remetente'],
            $cotacao['destinatario'],
            $cotacao['cliente_destinatario'],
            $cotacao['endereco_destinatario'],
            $cotacao['tomador'],
            $cotacao['endereco_tomador'],
            $cotacao['pagamento'],
            $cotacao['mercadoria'],
            $cotacao['largura'],
            $cotacao['altura'],
            $cotacao['comprimento'],
            $cotacao['volume'],
            $cotacao['peso'],
            $cotacao['observacoes'],
            $data_envio,
            $data_atual,
            $status,
            $cotacao['valor_frete'],
            $cotacao['data_cotacao'],
            $data_entrega_estimanda
        );

        if (!$stmt->execute()) {
            error_log("Erro ao inserir agendamento: " . $stmt->error);
        }

        $stmt->close();
    }
}

?>
