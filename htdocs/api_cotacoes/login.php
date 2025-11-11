<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include 'conexao.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    echo json_encode(["status" => "erro", "mensagem" => "Email ou senha não enviados"]);
    exit();
}

// Função genérica para checar login em uma tabela
function verificarLogin($conn, $tabela, $email, $senha, $tipoUsuario) {
    $stmt = $conn->prepare("SELECT id, senha, nome FROM $tabela WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $user = $resultado->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            return [
                "status" => "sucesso",
                "mensagem" => "Login realizado com sucesso",
                "tipo" => $tipoUsuario,
                "usuario" => [
                    "id" => $user['id'],
                    "nome" => $user['nome']
                ]
            ];
        } else {
            return ["status" => "erro", "mensagem" => "Senha incorreta"];
        }
    }

    return null;
}

// 1️⃣ tenta login como cliente
$resposta = verificarLogin($conn, "clientes", $email, $senha, "cliente");

// 2️⃣ se não for cliente, tenta como entregador
if (!$resposta) {
    $resposta = verificarLogin($conn, "entregadores", $email, $senha, "entregador");
}

// 3️⃣ se quiser incluir admin, pode descomentar abaixo
/*
if (!$resposta) {
    $resposta = verificarLogin($conn, "administradores", $email, $senha, "administrador");
}
*/

if ($resposta) {
    echo json_encode($resposta);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Email não encontrado em nenhuma conta"]);
}

$conn->close();
?>
