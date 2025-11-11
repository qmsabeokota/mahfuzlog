<?php
// Substitua pelos seus dados da conta sandbox
$email = 'rocketoficiial@gmail.com';
$token = 'C6718FE7E2074585B0B9684152D91C81';
$sandbox = true;

$url = $sandbox
    ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout'
    : 'https://ws.pagseguro.uol.com.br/v2/checkout';

$dadosPagamento = [
    'email' => $email,
    'token' => $token,
    'currency' => 'BRL',
    'itemId1' => '123',
    'itemDescription1' => 'Item de Teste',
    'itemAmount1' => number_format(10.00, 2, '.', ''),
    'itemQuantity1' => 1,
    'reference' => 'TESTE123'
];

$curl = curl_init($url);
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($dadosPagamento),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 60,
]);

$resposta = curl_exec($curl);

if (curl_errno($curl)) {
    echo "Erro cURL: " . curl_error($curl);
} else {
    echo "<pre>";
    echo "Resposta da API PagSeguro:\n";
    echo htmlspecialchars($resposta);
    echo "</pre>";
}

curl_close($curl);
