<?php
session_start();
require_once '../model/Cotacao.php';

if (!isset($_SESSION['cliente_id'])) {
    header('Location: ../view/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $dados = $_POST;
    $dados['cliente_id'] = $_SESSION['cliente_id'];
    $dados['largura'] = floatval($dados['largura']);
    $dados['altura'] = floatval($dados['altura']);
    $dados['comprimento'] = floatval($dados['comprimento']);
    $dados['peso'] = floatval($dados['peso']);

    // Cria o objeto Cotacao
    $cotacao = new Cotacao();
    
    // Chama o método registrar do modelo
    $valor_frete = $cotacao->registrar($dados);

    // Exibe uma mensagem e redireciona
    echo "<script>alert('Cotação enviada com sucesso! Valor estimado do frete: R$ " . number_format($dados['valor_frete'], 2, ',', '.') . "'); window.location.href='../view/cotacao.php';</script>";

} else {
    header('Location: ../view/cotacao.php');
}
?>
