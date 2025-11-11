<?php
require_once '../model/Usuario.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['cliente_id'])) {
        echo "Usuário não autenticado.";
        exit;
    }

    $cliente_id = $_SESSION['cliente_id'];

    $camposObrigatorios = ['tipo', 'nome', 'cpf_cnpj', 'email', 'senha', 'telefone', 'endereco', 'bairro', 'cidade', 'estado', 'cep'];

    foreach ($camposObrigatorios as $campo) {
        if (empty($_POST[$campo])) {
            echo "O campo " . ucfirst($campo) . " é obrigatório!";
            exit;
        }
    }

    $dados = [
        'tipo'      => htmlspecialchars(trim($_POST['tipo'])),
        'nome'      => htmlspecialchars(trim($_POST['nome'])),
        'cpf_cnpj'  => htmlspecialchars(trim($_POST['cpf_cnpj'])),
        'email'     => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
        'senha'     => password_hash(trim($_POST['senha']), PASSWORD_DEFAULT),
        'telefone'  => htmlspecialchars(trim($_POST['telefone'])),
        'endereco'  => htmlspecialchars(trim($_POST['endereco'])),
        'bairro'    => htmlspecialchars(trim($_POST['bairro'])),
        'cidade'    => htmlspecialchars(trim($_POST['cidade'])),
        'estado'    => htmlspecialchars(trim($_POST['estado'])),
        'cep'       => htmlspecialchars(trim($_POST['cep']))
    ];

    try {
        $usuario = new Usuario();
        $usuario->atualizar($cliente_id, $dados);

        header('Location: ../view/areacliente.php');
        exit;

    } catch (Exception $e) {
        echo "Erro ao atualizar cadastro: " . $e->getMessage();
    }
}

?>
