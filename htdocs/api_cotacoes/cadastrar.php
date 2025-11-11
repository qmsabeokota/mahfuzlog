<?php
header('Content-Type: application/json');

// Conexão
$conn = new mysqli("localhost", "root", "", "sistema_cadastro");
if ($conn->connect_error) {
    die(json_encode(["status"=>"erro","mensagem"=>"Falha na conexão com o banco de dados."]));
}

// Recebe dados
$tipo_usuario = $_POST['tipo_usuario'] ?? ''; // 'cliente' ou 'entregador'
$tipo_pessoa = $_POST['tipo'] ?? ''; // 'Pessoa Física' ou 'Pessoa Jurídica' - apenas para cliente
$nome = $_POST['nome'] ?? '';
$cpf_cnpj = $_POST['cpf_cnpj'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$bairro = $_POST['bairro'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$estado = $_POST['estado'] ?? '';
$cep = $_POST['cep'] ?? '';

// Validação básica
if (empty($tipo_usuario) || empty($nome) || empty($cpf_cnpj) || empty($email) || empty($senha)) {
    echo json_encode(["status"=>"erro","mensagem"=>"Campos obrigatórios ausentes."]);
    exit();
}

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

// Verifica email duplicado (em ambas as tabelas)
$check = $conn->prepare("SELECT id FROM clientes WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
$exists_cliente = $check->num_rows > 0;
$check->close();

$check2 = $conn->prepare("SELECT id FROM entregadores WHERE email = ?");
$check2->bind_param("s", $email);
$check2->execute();
$check2->store_result();
$exists_entregador = $check2->num_rows > 0;
$check2->close();

if ($exists_cliente || $exists_entregador) {
    echo json_encode(["status"=>"erro","mensagem"=>"E-mail já cadastrado."]);
    exit();
}

// Inserção dependendo do tipo_usuario
if ($tipo_usuario === 'cliente') {
    // Garante que tipo_pessoa esteja definido (padrão Pessoa Física)
    if (empty($tipo_pessoa)) {
        $tipo_pessoa = "Pessoa Física";
    }

    $stmt = $conn->prepare("INSERT INTO clientes (tipo, nome, cpf_cnpj, email, senha, telefone, endereco, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $tipo_pessoa, $nome, $cpf_cnpj, $email, $senha_hash, $telefone, $endereco, $bairro, $cidade, $estado, $cep);
}
elseif ($tipo_usuario === 'entregador') {
    $stmt = $conn->prepare("INSERT INTO entregadores (nome, cpf_cnpj, email, senha, telefone, cidade, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome, $cpf_cnpj, $email, $senha_hash, $telefone, $cidade, $estado);
}
else {
    echo json_encode(["status"=>"erro","mensagem"=>"Tipo de usuário inválido."]);
    exit();
}

// Executa
if ($stmt->execute()) {
    echo json_encode(["status"=>"sucesso","mensagem"=>"Cadastro realizado com sucesso!"]);
} else {
    echo json_encode(["status"=>"erro","mensagem"=>"Erro ao cadastrar: ".$conn->error]);
}

$stmt->close();
$conn->close();
?>
