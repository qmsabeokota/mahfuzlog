<?php
session_start();
require_once '../model/Usuario.php';
require_once '../model/Cotacao.php';
require_once '../model/Agendamento.php'; // ADICIONADO

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit;
}

$usuarioModel = new Usuario();
$cotacaoModel = new Cotacao();
$agendamentoModel = new Agendamento(); // ADICIONADO

$cliente = $usuarioModel->buscarPorId($_SESSION['cliente_id']);
$cotacoes = $cotacaoModel->listarPorCliente($_SESSION['cliente_id']);
$agendamentos = $agendamentoModel->listarPorCliente($_SESSION['cliente_id']); // ADICIONADO

?>