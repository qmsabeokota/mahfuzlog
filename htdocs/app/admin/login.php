<?php
session_start();
require_once '../Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM administradores WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($senha, $admin['senha'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
    } else {
        $erro = "Credenciais inválidas.";
    }
}

echo password_hash("maconha", PASSWORD_DEFAULT);

?>



<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Entrar</button>
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
</form>
