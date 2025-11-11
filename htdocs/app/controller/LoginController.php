<?php
session_start();
require_once '../lib/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $db = new Database();
    $conn = $db->getConnection();

    // 1. Verifica se é cliente
    $sql_cliente = "SELECT * FROM clientes WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($sql_cliente);
    $stmt->execute([':email' => $email]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && password_verify($senha, $cliente['senha'])) {
        $_SESSION['cliente_id'] = $cliente['id'];
        $_SESSION['cliente_nome'] = $cliente['nome'];
        $_SESSION['tipo_usuario'] = 'cliente';
        header('Location: ../view/areacliente.php');
        exit;
    }

    // 2. Verifica se é administrador
    $sql_admin = "SELECT * FROM administradores WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($sql_admin);
    $stmt->execute([':email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($senha, $admin['senha'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nome'] = $admin['nome'];
        $_SESSION['tipo_usuario'] = 'admin';
        header('Location: ../admin/dashboard.php');
        exit;
    }

    // Se nenhum deu certo
    echo "<script>alert('E-mail ou senha inválidos!'); window.location.href='../view/login.php';</script>";
}
