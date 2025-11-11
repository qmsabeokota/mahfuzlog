<?php

$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';

// Dados mínimos para testar conexão (email e token válidos são necessários)
$dadosTeste = [
    'email' => 'rocketoficiial@gmail.com',
    'token' => 'C6718FE7E2074585B0B9684152D91C81',
    'currency' => 'BRL',
    'itemId1' => 1,
    'itemDescription1' => 'Teste de pagamento',
    'itemAmount1' => '1.00',
    'itemQuantity1' => 1,
    'reference' => 'teste123'
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($dadosTeste));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);

$resposta = curl_exec($curl);

if ($resposta === false) {
    $erro = curl_error($curl);
    echo "Erro CURL: $erro\n";
} else {
    echo "Resposta recebida:\n";
    echo $resposta;
}

curl_close($curl);
