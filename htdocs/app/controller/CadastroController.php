<?php
require_once '../model/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifique campos obrigatórios
    $camposObrigatorios = ['tipo', 'nome', 'cpf_cnpj', 'email', 'senha', 'telefone', 'endereco', 'bairro', 'cidade', 'estado', 'cep'];

    foreach ($camposObrigatorios as $campo) {
        if (empty($_POST[$campo])) {
            echo "<script>alert('O campo " . ucfirst($campo) . " é obrigatório!'); window.history.back();</script>";
            exit;
        }
    }

    // Coletando e sanitizando os dados do formulário
    $dados = [
        'tipo'      => htmlspecialchars(trim($_POST['tipo'])),
        'nome'      => htmlspecialchars(trim($_POST['nome'])),
        'cpf_cnpj'  => htmlspecialchars(trim($_POST['cpf_cnpj'])),
        'email'     => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
        'senha'     => password_hash(trim($_POST['senha']), PASSWORD_DEFAULT), // Senha com hash
        'telefone'  => htmlspecialchars(trim($_POST['telefone'])),
        'endereco'  => htmlspecialchars(trim($_POST['endereco'])),
        'bairro'    => htmlspecialchars(trim($_POST['bairro'])),
        'cidade'    => htmlspecialchars(trim($_POST['cidade'])),
        'estado'    => htmlspecialchars(trim($_POST['estado'])),
        'cep'       => htmlspecialchars(trim($_POST['cep']))
    ];

    try {
        // Criando o objeto Usuario e cadastrando
        $usuario = new Usuario();

        if (!method_exists($usuario, 'cadastrar')) {
            throw new Exception("Método 'cadastrar' não encontrado na classe Usuario.");
        }

        $usuario->cadastrar($dados);

        // Redireciona após sucesso
        header('Location: ../view/areacliente.php');
        exit;

    } catch (Exception $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>
